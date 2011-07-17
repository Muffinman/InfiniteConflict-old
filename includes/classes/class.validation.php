<?php
/**
 *  SCRIPT:      validation.class.php
 *  CREATED BY:  Ed Jeavons, Orphans Press
 *  VERSION:     1.0 (June 2010)
 *
 *  DESCRIPTION:
 *  Attmepts to make server-side form validation easy!
 *
 *  This class does not interact with the form layout because template designers
 *  require full flexibility of that. Here we collects form data (having been given 
 *  a rule for each form entry) and keep a record of any errors found.
 *
 *  1.0 - Taken from v1.2 of Orphans Press' similar class
 */

class validation {
  # config vars
  var $regexpEmail = '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$';
  // dd/mm/yy
  var $regexpDate = '^(((0[1-9]|[12]\d|3[01])\/(0[13578]|1[02])\/(\d{2}))|((0[1-9]|[12]\d|30)\/(0[13456789]|1[012])\/(\d{2}))|((0[1-9]|1\d|2[0-8])\/02\/(\d{2}))|(29\/02\/((0[48]|[2468][048]|[13579][26])|(00))))$';
  // dd/mm/yyyy
  var $regexpDate4 = '(^((((0[1-9])|([1-2][0-9])|(3[0-1]))|([1-9]))\x2F(((0[1-9])|(1[0-2]))|([1-9]))\x2F(([0-9]{2})|(((19)|([2]([0]{1})))([0-9]{2}))))$)';
  var $regexpTime = '^[0-9]+:[0-5][0-9]$';
  var $regexpDateTime = '^(((0[1-9]|[12]\d|3[01])\/(0[13578]|1[02])\/(\d{2}))|((0[1-9]|[12]\d|30)\/(0[13456789]|1[012])\/(\d{2}))|((0[1-9]|1\d|2[0-8])\/02\/(\d{2}))|(29\/02\/((0[48]|[2468][048]|[13579][26])|(00)))) [0-9]+:[0-5][0-9]$';
  var $regexpFloat = '^[-+]?\d*\.?\d*$';
  var $regexpURL = "";
  var $regexpUrlFriendlyStr = '^([a-z0-9_-]+)$';
  var $stripHTML = false;
  var $errorID = "formerrors";

  # form data
  var $formData = array();

  # error records
  var $hasErrors = false;
  var $errHelp = array();
  var $errFields = array();

  /*
   *  TEXT FIELD
   *
   *  Checks whether or not a text input is within the allowable length
   */
  function Text($fieldname, $ref, $optional=0, $min=0, $max=0) {
  	$data = $_POST[$fieldname];
    if ($optional == 0 && empty($data)) {
      $this->AddError($fieldname, "$ref cannot be empty");
    } else if (!empty($data)) {
      if (strlen($data) < $min)
        $this->AddError($fieldname, "$ref must be at least $min characters long");
      else if ($max && strlen($data) > $max)
        $this->AddError($fieldname, "$ref cannot be more than $max characters long");
    }
    $this->formData[$fieldname] = stripslashes($data);
  }

  /*
   *  TEXT FIELD (REGEX)
   *
   *  Checks whether or not a text input matches a specific regex
   */
  function Regex($data, $ref, $regex) {
    if (!mb_eregi($regex, $data)) {
      $this->AddError($ref, "$ref is not valid");
    }
    $this->formData[$ref] = $data;
  }


  /*
   *  INTEGER FIELD
   *
   *  Checks whether or not a input is whole number within the allowable length
   */
  function Integer($fieldname, $ref, $optional=0, $min=0, $max=0) {
  	$data = $_POST[$fieldname];
    if ($optional == 0 || ($optional == 1 && strlen($data) != 0) ) {
      if (!ctype_digit($data))
        $this->AddError($fieldname, "$ref must be an integer");
      else if (strlen($data) < $min)
        $this->AddError($fieldname, "$ref must be at least $min characters long");
      else if ($max && strlen($data) > $max)
        $this->AddError($fieldname, "$ref cannot be more than $min characters long");
    }
    $this->formData[$fieldname] = $data;
  }


  /*
   *  FLOAT FIELD
   *
   *  Checks whether or not a input is float value
   */
  function Float($data, $ref, $optional=0) {
    if ($optional == 0 || ($optional == 1 && strlen($data) != 0) ) {
      if (!mb_eregi($this->regexpFloat, $data))
        $this->AddError($ref, "$ref is not a valid number");
    }
    $this->formData[$ref] = $data;


  }


  /*
   *  EMAIL
   */
  function Email($fieldname, $ref, $optional=0) {
  	$data = $_POST[$fieldname];
    if ($optional == 0 || ($optional == 1 && strlen($data) != 0) ) {
      if (!eregi($this->regexpEmail, $data))
        $this->AddError($fieldname, "$ref is not a valid address");
    }
    $this->formData[$fieldname] = $data;
  }


  /*
   *  DATE
   */
  function Date($fieldname, $ref, $optional=0, $format='dd/mm/yy') {
    $data = $_POST[$fieldname];
    if ($format == 'dd/mm/yyyy')
      $regexp = $this->regexpDate4;
    else
      $regexp = $this->regexpDate;

    if ($optional == 0 || ($optional == 1 && strlen($data) != 0) ) {
      if (!mb_eregi($regexp, $data))
        $this->AddError($ref, "$ref is not a valid date");
    }
    $this->formData[$fieldname] = $data;
  }


  /*
   *  TIME
   */
  function Time($data, $ref, $optional=0) {
    if ($optional == 0 || ($optional == 1 && strlen($data) != 0) ) {
      if (!eregi($this->regexpTime, $data))
        $this->AddError($ref, "$ref is not a valid time");
      $arrTime = explode(':', $data);
      if ($arrTime[0] > 23)
        $this->AddError($ref, "$ref is not a valid time");
    }
    $this->formData[$ref] = $data;
  }


  /*
   *  DATETIME
   */
  function DateTime($data, $ref, $optional=0, $format='dd/mm/yy hh:mm') {
    $regexp = $this->regexpDateTime;

    if ($optional == 0 || ($optional == 1 && strlen($data) != 0) ) {
      if (!mb_eregi($regexp, $data))
        $this->AddError($ref, "$ref is not a valid date");
    }
    $this->formData[$ref] = $data;
  }


  /*
   *  URL FRIENDLY
   */
  function UrlFriendly($data, $ref, $optional=0) {
    $data = trim(strtolower($data));
    $regexp = $this->regexpUrlFriendlyStr;
    if ($optional == 0 || ($optional == 1 && strlen($data) != 0) ) {
      if (!mb_eregi($regexp, $data))
        $this->AddError($ref, "$ref contains some invalid characters");
    }
    $this->formData[$ref] = $data;
  }


  /*
   *  BOOLEAN
   *
   *  Just looks for a true or false due, and returns '1' or '0' assuming this
   *  will placed into a db column that might only support a 1-bit integer
   */
  function Boolean($fieldname, $ref) {
  	$data = strtolower($_POST[$fieldname]);
    if ($data == 1 || $data == "true")
      $this->formData[$fieldname] = 1;
    else if ($data == 0 || $data == "false")
      $this->formData[$fieldname] = 0;
    else {
      $this->AddError($fieldname, "$ref must be true or false");
      $this->formData[$fieldname] = $data;
    }
  }

  /*
   *  CHECKBOX
   *
   *  No error checking for now, just convert to csv
   */
  function Checkbox($data, $ref, $serialise=false) {
    $out = '';
    if (is_array($data) && $serialise == true) {
      foreach ($data as $v)
        $out .= $v . ',';
      $out = substr($out, 0 , -1);
    } else if (is_array($data)) {
      $out = $data;
    } else {
      $out = array();
    }
    $this->formData[$ref] = $out;
  }


  /*
   *  MATCH TWO FIELDS
   *
   *  This method is unique in that it doesn't store the form data. It assumes
   *  the field's content has been didated in another method and here it
   *  only records an error when necessary.
   */
  function Match($fieldname, $data2, $ref) {
  	$data1 = strtolower($_POST[$fieldname]);
    if (is_array($data2) && !in_array($data1, $data2)) {
      $this->AddError($fieldname, "$ref is not valid");
    } else if (!is_array($data2) && $data1 != $data2)
      $this->AddError($fieldname, "$ref fields do not match");
    $this->formData[$fieldname] = $data1;
  }


  /*
   *  STRIP HTML
   *
   *  Goes through the data array and removes all HTML, unless the field has
   *  been told to be ignored.
   */
  function StripHTML($ignore = array()) {
    foreach ($this->formData as $k=>$v) {
      if (!in_array($k, $ignore) && !is_array($v))
        $this->formData[$k] = strip_tags($v);
    }
  }


  /*
   *  ADD SLASHES
   *
   *  Prepares all elements for database entry
   */
  function AddSlashes($ignore = array()) {
    foreach ($this->formData as $k=>$v) {
      if (!in_array($k, $ignore) && !is_array($v))
        $this->formData[$k] = addslashes($v);
    }
  }


  /*
   *  DISPLAY ERRORS
   */
  function DisplayErrors() {
    $out = "";
    if ($this->hasErrors) {
      $out .= "<div id=\"".$this->errorID."\">";
      $out .= "<ul>";
      foreach ($this->errHelp as $k=>$v) {
        $out .= "<li>".$v."</li>";
      }
      $out .= "</ul>";
      $out .= "</div>";
    }
    return $out;
  }


  /*
   *  ADD ERROR
   */
  function AddError($field, $msg) {
    $this->hasErrors = true;
    $this->errFields[$field] = true;
    $this->errHelp[] = $msg;
  }
}

?>
