<?
/*
 *  SCRIPT:      class.log.php
 *
 *  DESCRIPTION:
 *  Simple logging class for easy debugging of site errors
 *  If database connection is available the class will log
 *  to there, otherwise will be logged to file defined in
 *  ERROR_LOG.
 *
 *  @version     1.0a
 *  @author      Matt Jones <matt@azmatt.co.uk>
 *  @copyright   Matt Jones
 *  @package     KGL
 *  
 *  @requires    class.mysql.php
 */

class log{
  var $db;

  function log(){
    if (!file_exists(ERROR_LOG)){
      @touch(ERROR_LOG);
      @chmod(ERROR_LOG, 777);
    }
  }

  function add($logstr, $type='error'){
    $logstr = str_replace("\n", "\t", $logstr);
    while(strstr($logstr, "\t\t")){
      $logstr = str_replace("\t\t", " ", $logstr);
    }
    while(strstr($logstr, "  ")){
      $logstr = str_replace("  ", " ", $logstr);
    }

    // Best not to log people's passwords on form failure ;)
    $post = $_POST;
    if (isset($post['Password'])){
      $post['Password'] = '********';
    }
    if (isset($post['Confirm_Password'])){
      $post['Confirm_Password'] = '********';
    }

    $arr = array(
      'date' => date('H:i:s d/m/Y'),
      'ip' => $_SERVER['REMOTE_ADDR'],
      'user_id' => $_SESSION['user_id'],
      'username' => ($_SESSION['username'] ? $_SESSION['username'] : 'Guest'),
      'uri' => $_SERVER['REQUEST_URI'],
      'logstr' => $logstr,
      'get' => serialize($_GET),
      'post' => serialize($post),
      'session' => serialize($_SESSION),
      'cookie' => serialize($_COOKIE)
    );

    //FB::log($arr);

    if (!$this->db){
      # If we're logging to a file then we don't need the array keys.
      $str = array();
      foreach ($arr as $k=>$v){
        $str[] = $v;
      }
      $file = @fopen(ERROR_LOG, 'a+');
      @fwrite($file, implode("\t", $str) . "\n");
      @fclose($file);
    }else{
      # We'll keep all logs in one table, so check to see what type it is
      $arr['type'] = $type;
      # If we're logging to the DB this will be stored automatically under `created` or `updated`
      unset($arr['date']);
      $this->db->QuickInsert(MYSQL_DB_PREFIX . 'logs', $arr);
    }
  }

}