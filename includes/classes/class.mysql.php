<?
/*
 *  SCRIPT:      class.mysql.php
 *
 *  DESCRIPTION:
 *  Straightforward class to speed up and simplify MySQL operations
 *
 *  Key methods provide the ability to select, insert, update and delete. It
 *  also allows tables with a 'rank' field to be reordered, and it stores a full
 *  list of all queries run.
 *
 *  The basic error handling returns false on any error and places a reasonably
 *  meaningful message in $errStr.
 *
 *  @version     1.0a
 *  @author      Matt Jones <matt@azmatt.co.uk>
 *  @copyright   Matt Jones
 *  @package     KGL
 *  
 *  @requires    class.log.php
 */

class mysql {

  # config vars
  var $dbHost;
  var $dbName;
  var $dbUser;
  var $dbPass;
  var $dbLink;

  # status vars
  var $allQueries = array();
  var $numQueries;
  var $totalQueryTime;
  var $lastQueryTime;
  var $startTime;
  var $endTime;
  var $errStr;
  var $recordQueries = true;
  var $queryCache = array();

  function mysql() {
    $this->dbHost = 'localhost';
    $this->allQueries = array();
    $this->numQueries = 0;
    $this->errStr = '';
  }

  function esc($s){
    if ($s == 'id'){
      return $s;
    }
    return mysql_real_escape_string(trim($s));
  }

  /*
  *  SELECT QUERY
  *  ------------
  *  Returns associative array of results, if there are no results it will
  *  return an empty array.
  */
  function Select($q, $stripSlashes = false, $cacheQuery = true, $useCache = true) {
    global $log;

    # only allow select queries
    if (strtoupper(substr($q, 0, 6)) != 'SELECT' && strtoupper(substr($q, 0, 7)) != '(SELECT') {
      $this->errStr = "The Select method only support queries that begin with 'SELECT'.";
      return false;
    }

    if (array_key_exists(md5($q) , $this->queryCache) && $useCache === true){
      return $this->queryCache[md5($q)];
    }

    $this->startTiming();
    if ($r = mysql_query($q, $this->dbLink)) {
      $this->stopTiming();
      $allRows = array();
      $this->AddQuery($q);

      if (mysql_num_rows($r)) {
        while ($x = mysql_fetch_assoc($r)) {
          if ($stripSlashes) {
            foreach ($x as $k=>$v) {
              $v = stripslashes($v);
              $x[$k] = $v;
            }
          }

          $allRows[] = $x;
        }
        mysql_free_result($r);
        
        if ($cacheQuery === true){
          $this->queryCache[md5($q)] = $allRows;
        }

        return $allRows;
      } else {
        $this->errStr = "No database matches found";
        return false;
      }
    }
    else {
      $this->stopTiming();
      $this->errStr = mysql_error($this->dbLink);
      if ($log && $this->errStr !== 'No rows match the query definition.'){
        $log->add($this->errStr . ' : ' . $q);
      }
      return false;
    }
  }


  function QuickSelect($table, $id){
    if (!$table || !is_numeric($id) || empty($id)){
      return false;
    }    

    if ($this->ColExists($table, 'rank')){
      $orderBy = 'ORDER BY `rank` ASC';
    }

    $q = 'SELECT * FROM `' . $this->esc($table) . '` WHERE `id`=\'' . $this->esc($id) . '\' ' . $orderBy . ' LIMIT 1';
    if ($r = $this->Select($q)){
      return $r[0];
    }
    return false;
  }

  /*
  *  INSERT ROW
  *  ----------
  *  Inserts one row of data into a table and return the insert id.
  */
  function Insert($q) {
    global $log;
    # only allow insert queries
    if (strtoupper(substr($q, 0, 6) != 'INSERT')) {
      $this->errStr = "The Insert method only support queries that begin with 'INSERT'.";
      return false;
    }

    $this->startTiming();
    if ($r = mysql_query($q, $this->dbLink)) {
      $this->stopTiming();
      $this->AddQuery($q);
      return mysql_insert_id($this->dbLink);
    }
    else {
      $this->stopTiming();
      $this->errStr = mysql_error($this->dbLink);
      if ($log){
        $log->add($this->errStr . ' : ' . $q);
      }
      return false;
    }
  }

  function QuickInsert($table, $data){
    if (!$table || !is_array($data) || empty($data)){
      return false;
    }

    foreach ($data as $k => $v){
      $cols[] = "`" . $this->esc($k) . "`";
      $vals[] = "'" . $this->esc($v) . "'";
    }

    if ($this->ColExists($table, 'created')){
      $cols[]  = '`created`';
      $vals[] = 'NOW()';
    }

    $q = 'INSERT INTO `' . $this->esc($table) . '` (' . implode(',', $cols) . ') VALUES (' . implode(',', $vals) . ')';

    if ($id = $this->Insert($q)){
      return $id;
    }
    return false;
  }


  function MultiInsert($table, $arr){
    if (is_array($arr) && !empty($arr)){
      $IDs = array();
      foreach ($arr as $row){
        $IDs[] = $this->QuickInsert($table, $row);
      }
    }
    return $IDs;
  }

  function ExtendedInsert($table, $arr){
    $headers = array();
    $cols = array();
    $parts = array();

    if (is_array($arr) && !empty($arr)){
      $q = 'LOCK TABLES `' . $this->esc($table) . '` WRITE';
      $this->Query($q);

      $q = 'INSERT INTO `' . $this->esc($table) . '` ';

      foreach ($arr[0] as $k => $v){
        $headers[] = "`" . $this->esc($k) . "`";
        $cols[] = $k;
      }
      $q .= ' (' . implode(',', $headers) . ') VALUES ';

      foreach ($arr as $data){
        $vals = array();
        foreach ($cols as $col){
          $vals[] = "'" . $this->esc($data[$col]) . "'";
        }
        $parts[] = '(' . implode(',', $vals) . ')';
      }
      $q .= implode(", ", $parts);
      $this->Query($q);

      $q = 'UNLOCK TABLES';
      $this->Query($q);

    }
    return true;
  }

  /*
  *  EDIT ROWS
  *  ---------
  *  Can be used to delete or update rows, it will return the number of
  *  affected rows.
  */
  function Edit($q) {
    global $log;
    # only allow update or delete queries
    if ( strtoupper((substr($q, 0, 6) != 'UPDATE')) && (strtoupper(substr($q, 0, 6) != 'DELETE')) ) {
      $this->errStr = "The Edit method only support queries that begin with 'UPDATE' or 'DELETE'.";
      return false;
    }

    $this->startTiming();
    if ($r = mysql_query($q, $this->dbLink)) {
      $this->stopTiming();
      $this->AddQuery($q);
      if (mysql_affected_rows($this->dbLink) > 0 )
      return mysql_affected_rows($this->dbLink);
      else
      {
        $this->errStr = "No rows match the query definition.";
        return false;
      }
    }
    else {
      $this->stopTiming();
      $this->errStr = mysql_error($this->dbLink);
      if ($log){
        $log->add($this->errStr . ' : ' . $q);
      }
      return false;
    }
  }

  function QuickEdit($table, $data, $mode='UPDATE', $PK='id', $limit=1){
    global $log;
    if (!$table || !is_array($data) || empty($data)){
      return false;
    }

    if ($mode == 'UPDATE'){
      $qs = array();

      if ($this->ColExists($table, 'updated')){
        unset($data['updated']);
        $qs[] = '`updated` = NOW()';
      }

      foreach ($data as $k => $v){
        if ($v === NULL){
          $qs[] = '`' . $this->esc($k) . '` = NULL';
        }else{
          $qs[] = '`' . $this->esc($k) . '` = \'' . $this->esc($v) . '\'';
        }
      }


      $q = 'UPDATE `' . $this->esc($table) . '`
              SET ' . implode(', ', $qs) . '
              WHERE `' . $this->esc($PK) . '` = \'' . $this->esc($data[$PK]) . '\'';
    }

    else if ($mode == 'DELETE'){
       $q = 'DELETE FROM `' . $this->esc($table) . '`
              WHERE `' . $this->esc($PK) . '` = \'' . $this->esc($data[$PK]) . '\'';
    }

    if ($limit){
      $q .= " LIMIT " . $limit;
    }

    if ($this->Edit($q)){
      return true;
    }
    return false;
  }

  function MultiEdit($table, $arr, $mode='UPDATE', $PK='id'){
    if (is_array($arr) && !empty($arr)){
      $IDs = array();
      foreach ($arr as $row){
        if ($row[$PK]){
          $IDs[] = $this->QuickEdit($table, $row, $mode, $PK);
        }else{
          $IDs[] = $this->QuickInsert($table, $row);
        }
      }
    }
    return $IDs;
  }


  /*
  *  GENERIC QUERY
  *  -------------
  *  Can be used with any query to cover all bases. No useful data is returned.
  */
  function Query($q) {
    global $log;
    $this->startTiming();
    if ($r = mysql_query($q, $this->dbLink)) {
      $this->stopTiming();
      $this->AddQuery($q);
      return $r;
    }
    else {
      $this->stopTiming();
      $this->errStr = mysql_error($this->dbLink);
      if ($log){
        $log->add($this->errStr . ' : ' . $q);
      }
      return false;
    }
  }


  /*
  *  CHECK FOR ROW EXISTENCE
  *  -----------------------
  *  Returns true if a row exists, otherwise false.
  */
  function Exists($table, $id, $primaryCol='id', $andClause='') {
    $q = "SELECT * FROM $table WHERE $primaryCol='$id' $andClause LIMIT 1";
    if ($this->Select($q)){
      return true;
    }else{
      return false;
    }
  }


  /*
  *  CHECK FOR TABLE EXISTENCE
  */
  function TableExists($table) {
    $q = "SHOW TABLES LIKE '$table'";
    if (mysql_num_rows($this->Query($q))){
      return true;
    }else{
      return false;
    }
  }


  /*
  *  SHIFT ROW
  *  ---------
  *  This method assumes that the table uses an integer column to control the
  *  order in which rows are returned. It allows any given row to be shifted up
  *  or down by any number of spaces (up < shift = 0 > down).
  *
  *  The 'where clause' is optional, but is useful if you wish to store > 1
  *  independantly ordered list within the same table.
  */
  function ShiftRow($table, $shiftrow, $shiftval, $whereclause='', $primarycolumn='id', $rankcolumn='rank') {
    # don't do anything unless $shift is a valid number
    if ($shiftval == 0) {
      $this->errStr = "\$shift must be an integer greater than, or less than, zero.";
      return false;
    }

    # first get an array of all rows in their existing order, but with a new contiguous rank
    $q = "SELECT $primarycolumn, $rankcolumn FROM $table $whereclause ORDER BY $rankcolumn";
    if ($x = $this->Select($q)) {
      $sortableRows = array();
      $nextRank = 0;

      # now put this into a 'walkable' array
      foreach ($x as $thisRow) {
        $nextRank++;
        $newRank = $nextRank;
        $sortableRows[$thisRow[$primarycolumn]]['old'] = $nextRank;
        if ($thisRow[$primarycolumn] == $shiftrow)
          $anchorRank = $nextRank;
        $sortableRows[$thisRow[$primarycolumn]]['new'] = $newRank;
      }

      # override shift value if it's going to take us off the scale
      if (($anchorRank + $shiftval) < 1)
        $shiftval = 1 - $anchorRank;
      else if (($anchorRank + $shiftval) > $nextRank)
        $shiftval = $nextRank - $anchorRank;

      # now go through the walkable array, chaning any necessary ranks
      foreach ($sortableRows as $rowId => $thisRow) {
        if ($thisRow['old'] == $anchorRank)
          $sortableRows[$rowId]['new'] = $thisRow['old'] + $shiftval;
        else if ( ($shiftval > 0) && ($thisRow['old'] > $anchorRank) && ($thisRow['old'] <= ($anchorRank + $shiftval)) )
          $sortableRows[$rowId]['new'] = $thisRow['old'] - 1;
        else if ( ($shiftval < 0) && ($thisRow['old'] < $anchorRank) && ($thisRow['old'] >= ($anchorRank + $shiftval)) )
          $sortableRows[$rowId]['new'] = $thisRow['old'] + 1;
      }

      # finally update the table itself (NEEDS ERROR CHECKING)
      foreach ($sortableRows as $rowId => $thisRow) {
        $q = "UPDATE $table SET $rankcolumn = '".$thisRow['new']."' WHERE $primarycolumn = '".$rowId."' LIMIT 1";
        $this->Edit($q);
      }
    }
    else
    return false;
  }


  /*
  *  NEXT RANK
  *  ---------
  *  Useful for inserting a new row where a rank column is used in the table.
  *  It will return the next rank to be used, i.e. the highest esiting rank+1.
  *
  *  The 'where clause' is option, but is useful if you wish to store > 1
  *  independantly ordered list within the same table.
  */
  function NextRank($table, $rankcolumn, $whereclause='') {
    $q = "SELECT MAX($rankcolumn) AS max_rank FROM $table $whereclause";
    if ($x = $this->Select($q, false, false, false)) {
      $nextRank = $x[0]['max_rank'] + 1;
      return $nextRank;
    }
    else
    return false;
  }


  /*
  *  DATE ENCODE
  *  -----------
  *  Converts a date into MySQL format. Source format must be validated before calling this function.
  */
  function EncodeDate($input, $inputFormat='dd/mm/yyyy') {
    # 'dd/mm/yy' - always 2-digit dates but separator is variable
    if ($inputFormat == 'dd/mm/yy') {
      return '20'.substr($input, 6, 2).'-'.substr($input, 3, 2).'-'.substr($input, 0, 2);
    } else if ($inputFormat == 'dd/mm/yyyy') {
      return substr($input, 6, 4).'-'.substr($input, 3, 2).'-'.substr($input, 0, 2);
    } else if ($inputFormat == 'dd/mm/yyyy hh:mm') {
      return substr($input, 6, 4).'-'.substr($input, 3, 2).'-'.substr($input, 0, 2).' '.substr($input, 11, 2).':'.substr($input, 14, 2).':00';
    } else if ($inputFormat == 'dd/mm/yy hh:mm') {
      return '20'.substr($input, 6, 2).'-'.substr($input, 3, 2).'-'.substr($input, 0, 2).' '.substr($input, 9, 2).':'.substr($input, 12, 2).':00';
    }

    # if no matching patterns just return the input
    else {
      return $input;
    }
  }

  /*
  *  CHECK IF COLUMN EXISTS
  *  ----------------------
  *  Only returns true of the column appears on the table
  */
  function ColExists($tableName, $colName) {
    $q = "SHOW COLUMNS FROM $tableName LIKE '$colName'";
    $r = $this->Query($q);
    if (@mysql_num_rows($r))
      return true;
    else
      return false;
  }

  /*
  *  START TIMER
  */
  function startTiming(){
    $starttime = explode( ' ' , microtime());
    $starttime = $starttime[0] + $starttime[1];
    $this->startTime = $starttime;
  }

  /*
  *  STOP TIMER
  */
  function stopTiming(){
    $endtime = explode( ' ' , microtime());
    $endtime = $endtime[0] + $endtime[1];
    if ($this->startTime){
      $this->endTime = $endtime;
      $this->lastQueryTime = $this->endTime - $this->startTime;
      $this->totalQueryTime += $this->lastQueryTime;
      unset($this->startTime);
    }
  }

  /*
  *  INITIAL CONNECTION
  *  ------------------
  *  Connection to database (will automatically close when script terminates)
  */
  function Connect() {
    if ($this->dbLink = mysql_connect($this->dbHost, $this->dbUser, $this->dbPass)) {
      if (mysql_select_db($this->dbName, $this->dbLink)) {
        return true;
      }
      else {
        $this->errStr = mysql_error($this->dbLink);
        if ($log){
          $log->add($this->errStr . ' : ' . $q);
        }
        return false;
      }
    }
    else {
      $this->errStr = mysql_error($this->dbLink);
      if ($log){
        $log->add($this->errStr . ' : ' . $q);
      }
      return false;
    }
  }


  /*
  *  REMEMBER QUERY
  *  --------------
  *  Stores a record of each query used during this execution, purely to help
  *  developers debug their code.
  */
  function AddQuery($q) {
    if ($this->recordQueries){
      $this->allQueries[] = array('time' => round($this->lastQueryTime,4), 'query' => $q);
    }
    $this->numQueries++;
  }
  
  function ClearCache(){
    $this->queryCache = array();
    return true;
  }
}