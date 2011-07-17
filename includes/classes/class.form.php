<?
/*
 *  SCRIPT:      class.form.php
 *
 *  DESCRIPTION:
 *  Attmepts to make server-side form creation and validation easy!
 *
 *  @version     1.0a
 *  @author      Matt Jones <matt@azmatt.co.uk>
 *  @copyright   Matt Jones
 *  @package     KGL
 */

class Form {
  # config vars
  var $regexpEmail = '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$';
  // dd/mm/yy
  var $regexpDate = '^(((0[1-9]|[12]\d|3[01])\/(0[13578]|1[02])\/(\d{2}))|((0[1-9]|[12]\d|30)\/(0[13456789]|1[012])\/(\d{2}))|((0[1-9]|1\d|2[0-8])\/02\/(\d{2}))|(29\/02\/((0[48]|[2468][048]|[13579][26])|(00))))$';
  // dd/mm/yyyy
  var $regexpDate4 = '(^((((0[1-9])|([1-2][0-9])|(3[0-1]))|([1-9]))\x2F(((0[1-9])|(1[0-2]))|([1-9]))\x2F(([0-9]{2})|(((19)|([2]([0]{1})))([0-9]{2}))))$)';
  var $regexpTime = '^[0-9]+:[0-5][0-9]$';
  var $regexpDateTime = '^(((0[1-9]|[12]\d|3[01])\/(0[13578]|1[02])\/(\d{2}))|((0[1-9]|[12]\d|30)\/(0[13456789]|1[012])\/(\d{2}))|((0[1-9]|1\d|2[0-8])\/02\/(\d{2}))|(29\/02\/((0[48]|[2468][048]|[13579][26])|(00)))) [0-9]+:[0-5][0-9]$';
  var $regexpDateTime4 = '^(((0[1-9])|([1-2][0-9])|(3[0-1]))|([1-9]))\x2F(((0[1-9])|(1[0-2]))|([1-9]))\x2F(([0-9]{2})|(((19)|([2]([0]{1})))([0-9]{2}))) [0-9]+:[0-5][0-9]$';
  var $regexpFloat = '^[-+]?\d*\.?\d*$';
  var $regexpURL = "^(http|https)+://(([a-zA-Z0-9\.-]+\.[a-zA-Z]{2,4})|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(/[a-zA-Z0-9%:/-_\?\.'~]*)?";
  var $regexpUrlFriendlyStr = '^([a-z0-9_-]+)$';
  var $regexpUsername = '^([ a-zA-Z0-9._-]+)$';
  var $regexpIRC = '^#([a-zA-Z0-9._&+-]+)$';
  var $regexpSteam = '^STEAM_0:(0|1):([0-9]+)$';
  var $stripHTML = false;
  var $errorID = "formerrors";
  var $div = 'p';
  var $html = '';
  var $multipart = false;
  var $action = '';
  var $postData = true;
  var $labels = true;
  var $checkSelect = true; // Disbale this if using AJAX to load data into select fields

  # form data
  var $formData = array();

  # error records
  var $hasErrors = false;
  var $errHelp = array();
  var $errFields = array();


  function Clean($str){
    $str = str_replace(" ", "_", $str);
    $str = str_replace("[", "", $str);
    $str = str_replace("]", "", $str);
    $str = str_replace(":", "", $str);
    $str = str_replace(".", "", $str);
    $str = str_replace("|", "", $str);
    $str = str_replace("!", "", $str);
    return $str;
  }

  function Hidden($ref, $data){
    $this->formData[$ref] = $data;
    $this->html .= '<' . $this->div . ' style="display:none;">' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";
    $this->html .= '  <input type="hidden" name="' . $this->Clean($ref) . '" id="' . $this->Clean($ref) . '" value="' . htmlspecialchars($this->formData[$ref]) . '" />' . "\n";
    $this->html .= '</' . $this->div . '>' . "\n";
  }

  /*
   *  TEXT FIELD
   *
   *  Checks whether or not a text input is within the allowable length
   */
  function Text($ref, $optional=false, $min=0, $max=0) {
    $data = $GLOBALS['data'][$ref];
    if ($_POST && !$_POST['back'] && $this->postData){
      $data = $_POST[$this->Clean($ref)];
    }

    if ($optional === false && empty($data)) {
      $this->AddError($data, "$ref cannot be empty");
    } else if (!empty($data)) {
      if (strlen($data) < $min)
        $this->AddError($data, "$ref must be at least $min characters long");
      else if ($max && strlen($data) > $max)
        $this->AddError($data, "$ref cannot be more than $max characters long");
    }
    $this->formData[$ref] = $data;
    $this->html .= '<' . $this->div . '>' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";
    $this->html .= '  <input type="text" name="' . $this->Clean($ref) . '" id="' . $this->Clean($ref) . '" value="' . htmlspecialchars($this->formData[$ref]) . '" maxlength="' . $max . '" />' . "\n";
    if ($optional === false){
      $this->html .= '  <span class="required">*</span>' . "\n";
    }
    $this->html .= '</' . $this->div . '>' . "\n";
  }

  /*
   *  STEAM ID FIELD
   *
   *  Checks whether or not a text input is within the allowable length
   */
  function SteamID($ref, $optional=false) {
    $data = $GLOBALS['data'][$ref];
    if ($_POST && !$_POST['back'] && $this->postData){
      $data = $_POST[$this->Clean($ref)];
    }

    if ($optional === false && empty($data)) {
      $this->AddError($data, "$ref cannot be empty");
    } else if (!empty($data)) {
      if (!eregi($this->regexpSteam, $data)){
        $this->AddError($data, "$ref is invalid. Should be in the format STEAM_0:X:XXXX");
      }
    }
    $this->formData[$ref] = $data;
    $this->html .= '<' . $this->div . '>' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";
    $this->html .= '  <input type="text" name="' . $this->Clean($ref) . '" id="' . $this->Clean($ref) . '" value="' . htmlspecialchars($this->formData[$ref]) . '" maxlength="32" />' . "\n";
    if ($optional === false){
      $this->html .= '  <span class="required">*</span>' . "\n";
    }
    $this->html .= '</' . $this->div . '>' . "\n";
  }

  /*
   *  TEXTAREA FIELD
   *
   *  Checks whether or not a text input is within the allowable length
   */
  function Textarea($ref, $optional=false, $html=false, $rows=4, $cols=25) {
    $data = $GLOBALS['data'][$ref];
    if ($_POST && !$_POST['back'] && $this->postData){
      $data = $_POST[$this->Clean($ref)];
    }

    if ($optional === false && empty($data)) {
      $this->AddError($data, "$ref cannot be empty");
    } else if (!empty($data)) {
      if (strlen($data) < $min)
        $this->AddError($data, "$ref must be at least $min characters long");
      else if ($max && strlen($data) > $max)
        $this->AddError($data, "$ref cannot be more than $max characters long");
    }

    if ($html === false){
      $data = strip_tags($data);
    }

    $this->formData[$ref] = $data;

    $this->html .= '<' . $this->div . '>' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";
    $this->html .= '  <textarea rows="' . $rows . '" cols="' . $cols . '" name="' . $this->Clean($ref) . '" id="' . $this->Clean($ref) . '">' . htmlspecialchars($this->formData[$ref]) . '</textarea>' . "\n";
    if ($optional === false){
      $this->html .= '  <span class="required">*</span>' . "\n";
    }
    $this->html .= '  <div style="clear:both;"></div>';
    $this->html .= '</' . $this->div . '>' . "\n";
  }

  /*
   *  TEXTEDITOR FIELD
   *
   *  Checks whether or not a text input is within the allowable length
   */
  function TextEditor($ref, $optional=false, $editor=true, $html=true, $width=500, $height=300) {
    $data = $GLOBALS['data'][$ref];
    if ($_POST && !$_POST['back'] && $this->postData){
      $data = $_POST[$this->Clean($ref)];
    }

    if ($optional === false && empty($data)) {
      $this->AddError($data, "$ref cannot be empty");
    } else if (!empty($data)) {
      if (strlen($data) < $min)
        $this->AddError($data, "$ref must be at least $min characters long");
      else if ($max && strlen($data) > $max)
        $this->AddError($data, "$ref cannot be more than $max characters long");
    }
    $this->formData[$ref] = $data;
    $this->html .= '<' . $this->div . ' style="height:' . ($height+15) . 'px;">' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";
    $this->html .= '  <textarea style="width:' . $width . 'px; height:' . $height . 'px;" rows="4" cols="25" class="tinymce" name="' . $this->Clean($ref) . '" id="' . $this->Clean($ref) . '">' . htmlspecialchars($this->formData[$ref]) . '</textarea>' . "\n";
    if ($optional === false){
      $this->html .= '  <span class="required">*</span>' . "\n";
    }
    $this->html .= '  <div style="clear:both;"></div>';
    $this->html .= '</' . $this->div . '>' . "\n";
  }

  /*
   *  IRC FIELD
   *
   *  Checks whether or not a text input is within the allowable length
   */
  function IRC($ref, $optional=false, $min=0, $max=0) {
    $data = $GLOBALS['data'][$ref];
    if ($_POST && !$_POST['back'] && $this->postData){
      $data = $_POST[$this->Clean($ref)];
    }

    if ($optional === false && empty($data)) {
      $this->AddError($data, "$ref cannot be empty");
    } else if (!empty($data)) {
      if (strlen($data) < $min){
        $this->AddError($data, "$ref must be at least $min characters long");
      }
      else if ($max && strlen($data) > $max){
        $this->AddError($data, "$ref cannot be more than $max characters long");
      }
      else if (!eregi($this->regexpIRC, $data)){
        $this->AddError($data, "$ref is not a valid IRC Channel");
      }
    }
    $this->formData[$ref] = $data;
    $this->html .= '<' . $this->div . '>' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";
    $this->html .= '  <input type="text" name="' . $this->Clean($ref) . '" id="' . $this->Clean($ref) . '" value="' . htmlspecialchars($this->formData[$ref]) . '" maxlength="' . $max . '" />' . "\n";
    if ($optional === false){
      $this->html .= '  <span class="required">*</span>' . "\n";
    }
    $this->html .= '</' . $this->div . '>' . "\n";
  }

  function URL($ref, $optional=false, $min=0, $max=255){
    $data = $GLOBALS['data'][$ref];
    if ($_POST && !$_POST['back'] && $this->postData){
      $data = $_POST[$this->Clean($ref)];
    }

    if ($optional === false && empty($data)) {
      $this->AddError($data, "$ref cannot be empty");
    } else if (!empty($data)) {
      if (strlen($data) < $min)
        $this->AddError($data, "$ref must be at least $min characters long");
      else if ($max && strlen($data) > $max)
        $this->AddError($data, "$ref cannot be more than $max characters long");
      else if (!eregi($this->regexpURL, $data)){
        $this->AddError($data, "$ref is not a valid URL, should be in the format http://www.example.com");
      }
    }
    $this->formData[$ref] = $data;
    $this->html .= '<' . $this->div . '>' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";
    $this->html .= '  <input type="text" name="' . $this->Clean($ref) . '" id="' . $this->Clean($ref) . '" value="' . htmlspecialchars($this->formData[$ref]) . '" maxlength="' . $max . '" />' . "\n";
    if ($optional === false){
      $this->html .= '  <span class="required">*</span>' . "\n";
    }
    $this->html .= '</' . $this->div . '>' . "\n";
  }

  function Username($ref, $optional=false, $min=0, $max=0) {
    $data = $GLOBALS['data'][$ref];
    if ($_POST && !$_POST['back'] && $this->postData){
      $data = $_POST[$this->Clean($ref)];
    }

    if ($optional === false || ($optional === true && strlen($data) != 0)) {
      if (!eregi($this->regexpUsername, $data)){
        $this->AddError($data, "$ref is not valid. Accepted characters are \"A-Z 0-9_-.\"");
      }else{
        if (strlen($data) < $min)
          $this->AddError($data, "$ref must be at least $min characters long");
        else if ($max && strlen($data) > $max)
          $this->AddError($data, "$ref cannot be more than $max characters long");
      }
    }

    $this->formData[$ref] = $data;
    $this->html .= '<' . $this->div . '>' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";
    $this->html .= '  <input type="text" name="' . $this->Clean($ref) . '" id="' . $this->Clean($ref) . '" value="' . htmlspecialchars($this->formData[$ref]) . '" />' . "\n";
    if ($optional === false){
      $this->html .= '  <span class="required">*</span>' . "\n";
    }
    $this->html .= '</' . $this->div . '>' . "\n";
  }

  function Password($ref, $optional=false, $min=0) {
    $data = $GLOBALS['data'][$ref];
    if ($_POST && !$_POST['back'] && $this->postData){
      $data = $_POST[$this->Clean($ref)];
    }

    if ($optional === false && empty($data)) {
      $this->AddError($data, "$ref cannot be empty");
    } else if (!empty($data)) {
      if (strlen($data) < $min)
        $this->AddError($data, "$ref must be at least $min characters long");
      else if ($max && strlen($data) > $max)
        $this->AddError($data, "$ref cannot be more than $max characters long");
    }
    $this->formData[$ref] = $data;
    $this->html .= '<' . $this->div . '>' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";
    $this->html .= '  <input type="password" name="' . $this->Clean($ref). '" id="' . $this->Clean($ref) . '" autocomplete="off" />' . "\n";
    if ($optional === false){
      $this->html .= '  <span class="required">*</span>' . "\n";
    }
    $this->html .= '</' . $this->div . '>' . "\n";
  }


  /*
   *  SELECT
   *
   *  check input against allowed values
   */
  function Select($ref, $optional=false, $options, $type='assoc') {
    $data = $GLOBALS['data'][$ref];
    if ($_POST && !$_POST['back'] && $this->postData){
      $found = false;

      # If we have empty data, assume it is OK unless optional is false
      if (!$_POST[$this->Clean($ref)]){
        $found = true;
      }

      foreach ($options as $option=>$value){
        if ($value == $_POST[$this->Clean($ref)]){
          $found = true;
        }
      }
      if ($found === true || $this->checkSelect ===  false){
        $data = $_POST[$this->Clean($ref)];
      }else{
        $this->AddError($data, "The POST data did not match $ref options. This hack attempt has been logged.");
      }
    }

    if ($optional===false && !$data){
      $this->AddError($data, "You must select an opiton for $ref.");
    }

    $this->formData[$ref] = $data;

    $this->html .= '<' . $this->div . '>' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";
    $this->html .= '  <select name="' . $this->Clean($ref) . '" id="' . $this->Clean($ref) . '">' . "\n";
    $this->html .= '    <option value=""> -- please select -- </option>' . "\n";
    foreach($options as $option=>$value){
      if ($type == 'index'){
        $option = $value;
      }
      $this->html .= '    <option value="' . $value . '"' . ($this->formData[$ref]==$value ? ' selected="selected"' : '') . '>' . $option . '</option>' . "\n";
    }
    $this->html .= '  </select>' . "\n";
    if ($optional === false){
      $this->html .= '  <span class="required">*</span>' . "\n";
    }
    $this->html .= '</' . $this->div . '>' . "\n";
  }

  /*
   *  INTEGER FIELD
   *
   *  Checks whether or not a input is whole number within the allowable length
   */
  function Integer($ref, $optional=false, $min=0, $max=0) {
    $data = $GLOBALS['data'][$ref];

    if ($_POST && !$_POST['back'] && $this->postData){
      $data = (int)$_POST[$this->Clean($ref)];
    }

    if ($optional === false && strlen($data) == 0) {
      $this->AddError($data, "$ref must not be empty");
    }else{
      if (!is_int($data))
        $this->AddError($data, "$ref must be an integer");
      else if (strlen($data) < $min)
        $this->AddError($data, "$ref must be at least $min characters long");
      else if ($max && strlen($data) > $max)
        $this->AddError($data, "$ref cannot be more than $min characters long");
    }
    $this->formData[$ref] = $data;
    $this->html .= '<' . $this->div . '>' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";
    $this->html .= '  <input type="text" name="' . $this->Clean($ref) . '" id="' . $this->Clean($ref) . '" value="' . htmlspecialchars($this->formData[$ref]) . '" />' . "\n";
    if ($optional === false){
      $this->html .= '  <span class="required">*</span>' . "\n";
    }
    $this->html .= '</' . $this->div . '>' . "\n";
  }


  /*
   *  FLOAT FIELD
   *
   *  Checks whether or not a input is float value
   */
  function Float($ref, $optional=0) {
    $data = $GLOBALS['data'][$ref];
    if ($_POST && !$_POST['back'] && $this->postData){
      $data = $_POST[$this->Clean($ref)];
    }

    if ($optional === false || ($optional === true && strlen($data) != 0) ) {
      if (!mb_eregi($this->regexpFloat, $data))
        $this->AddError($data, "$ref is not a valid number");
    }
    $this->formData[$ref] = $data;
    $this->html .= '<' . $this->div . '>' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";
    $this->html .= '  <input type="text" name="' . $this->Clean($ref) . '" id="' . $this->Clean($ref) . '" value="' . htmlspecialchars($this->formData[$ref]) . '" />' . "\n";
    if ($optional === false){
      $this->html .= '  <span class="required">*</span>' . "\n";
    }
    $this->html .= '</' . $this->div . '>' . "\n";
  }


  /*
   *  EMAIL
   */
  function Email($ref, $optional=false) {
    $data = $GLOBALS['data'][$ref];
    if ($_POST && !$_POST['back'] && $this->postData){
      $data = $_POST[$this->Clean($ref)];
    }

    if ($optional === false || ($optional === true && strlen($data) != 0) ) {
      if (!eregi($this->regexpEmail, $data))
        $this->AddError($data, "$ref is not a valid address");
    }
    $this->formData[$ref] = $data;
    $this->html .= '<' . $this->div . '>' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";
    $this->html .= '  <input type="text" name="' . $this->Clean($ref) . '" id="' . $this->Clean($ref) . '" value="' . htmlspecialchars($this->formData[$ref]) . '"  autocomplete="off" />' . "\n";
    if ($optional === false){
      $this->html .= '  <span class="required">*</span>' . "\n";
    }
    $this->html .= '</' . $this->div . '>' . "\n";
  }


  /*
   *  DATE
   */
  function Date($ref, $optional=false, $format='dd/mm/yy') {
    $data = $GLOBALS['data'][$ref];
    if ($_POST && !$_POST['back'] && $this->postData){
      $data = $_POST[$this->Clean($ref)];
    }

    if ($format == 'dd/mm/yyyy')
      $regexp = $this->regexpDate4;
    else
      $regexp = $this->regexpDate;

    if ($optional === false || ($optional === true && strlen($data) != 0) ) {
      if (!mb_eregi($regexp, $data))
        $this->AddError($data, "$ref is not a valid date");
    }
    $this->formData[$ref] = $data;

    $this->html .= '<' . $this->div . '>' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";
    $this->html .= '  <input type="text" name="' . $this->Clean($ref) . '" id="' . $this->Clean($ref) . '" maxlength="10" value="' . htmlspecialchars($this->formData[$ref]) .'" />' . "\n";
    if ($optional === false){
      $this->html .= '  <span class="required">*</span>' . "\n";
    }
    $this->html .= '</' . $this->div . '>' . "\n";

  }



  function DateDropDown($ref, $optional=false, $time=false){
    if ($GLOBALS['data'][$ref]){
      $tmp = $GLOBALS['data'][$ref];
      $tmp = explode(' ', $tmp);
      if (strpos('/', $tmp[0])){
        $d = explode('/', $tmp[0]);
      } else {
        $d = array_reverse(explode('-', $tmp[0]));
      }
      $t = explode(':', $tmp[1]);
      $GLOBALS['data'][$this->Clean($ref) . "_dd"] = $d[0];
      $GLOBALS['data'][$this->Clean($ref) . "_mm"] = $d[1];
      $GLOBALS['data'][$this->Clean($ref) . "_yyyy"] = $d[2];

      if ($time && $t){
        $GLOBALS['data'][$this->Clean($ref) . "_hr"] = $t[0];
        $GLOBALS['data'][$this->Clean($ref) . "_mi"] = $t[1];
      }
    }
    $data = $GLOBALS['data'][$this->Clean($ref) . "_dd"] . '/' . $GLOBALS['data'][$this->Clean($ref) . "_mm"] . '/'  . $GLOBALS['data'][$this->Clean($ref) . "_yyyy"];

    if ($time){
      $data .= ' ' . $GLOBALS['data'][$this->Clean($ref) . "_hr"] . ':' . $GLOBALS['data'][$this->Clean($ref) . "_mi"];
    }

    if ($_POST && !$_POST['back'] && $this->postData){
      if ($_POST[$this->Clean($ref) . "_dd"] < 10){
        $_POST[$this->Clean($ref) . "_dd"] = '0'.$_POST[$this->Clean($ref) . "_dd"];
      }
      if ($_POST[$this->Clean($ref) . "_mm"] < 10){
        $_POST[$this->Clean($ref) . "_mm"] = '0'.$_POST[$this->Clean($ref) . "_mm"];
      }
      if ($time){
        if ($_POST[$this->Clean($ref) . "_hr"] < 10){
          $_POST[$this->Clean($ref) . "_hr"] = '0'.$_POST[$this->Clean($ref) . "_hr"];
        }
        if ($_POST[$this->Clean($ref) . "_mi"] < 10){
          $_POST[$this->Clean($ref) . "_mi"] = '0'.$_POST[$this->Clean($ref) . "_mi"];
        }
      }
      $data = $_POST[$this->Clean($ref) . "_dd"] . '/' . $_POST[$this->Clean($ref) . "_mm"] . '/'  . $_POST[$this->Clean($ref) . "_yyyy"];
      if ($time){
        $data .= ' ' . $_POST[$this->Clean($ref) . "_hr"] . ':' . $_POST[$this->Clean($ref) . "_mi"];
      }
      $_POST[$this->Clean($ref)] = $data;
    }

    if ($optional === false || ($optional === true && strlen($data) != 0) ) {
      if ($time){
        $ereg = $this->regexpDateTime4;
      }else{
        $ereg = $this->regexpDate4;
      }
      if (!mb_eregi($ereg, $data)){
        $this->AddError($data, "$ref is not a valid date");
      }
    }
    $this->formData[$ref] = $data;
    $tmp = explode(' ', $data);
    $d = explode('/', $tmp[0]);
    $t = explode(':', $tmp[1]);

    $this->html .= '<' . $this->div . '>' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";

    # days
    $this->html .= '  <select name="' . $this->Clean($ref) . '_dd" id="' . $this->Clean($ref) . '">' . "\n";
    $this->html .= '    <option value="">dd</option>' . "\n";
    for($i=1; $i<=31; $i++){
      $this->html .= '    <option value="' . $i . '"' . ($d[0]== $i ? ' selected="selected"' : '') . '>' . $i . '</option>' . "\n";
    }
    $this->html .= '  </select> /' . "\n";
    
    # months
    $this->html .= '  <select name="' . $this->Clean($ref) . '_mm">' . "\n";
    $this->html .= '    <option value="">mm</option>' . "\n";
    for($i=1; $i<=12; $i++){
      $this->html .= '    <option value="' . $i . '"' . ($d[1]==$i ? ' selected="selected"' : '') . '>' . $i . '</option>' . "\n";
    }
    $this->html .= '  </select> /' . "\n";

    # years
    $this->html .= '  <select name="' . $this->Clean($ref) . '_yyyy">' . "\n";
    $this->html .= '    <option value="">yyyy</option>' . "\n";
    $startY = date('Y')+1;
    $endY = date('Y')-100;
    for($i=$startY; $i>=$endY; $i--){
      $this->html .= '    <option value="' . $i . '"' . ($d[2]==$i ? ' selected="selected"' : '') . '>' . $i . '</option>' . "\n";
    }
    $this->html .= '  </select>' . "\n";
    
    if ($time){
      $this->html .= ' - ';
      # hours
      $this->html .= '  <select name="' . $this->Clean($ref) . '_hr">' . "\n";
      $this->html .= '    <option value="">hr</option>' . "\n";
      for($i=0; $i<=23; $i++){
        $this->html .= '    <option value="' . $i . '"' . ($t[0]==$i ? ' selected="selected"' : '') . '>' . ($i<10 ? '0'.$i : $i) . '</option>' . "\n";
      }
      $this->html .= '  </select> : ' . "\n";
      
      # mins
      $this->html .= '  <select name="' . $this->Clean($ref) . '_mi">' . "\n";
      $this->html .= '    <option value="">mi</option>' . "\n";
      for($i=0; $i<=55; $i+=5){
        $this->html .= '    <option value="' . $i . '"' . ($t[1]==$i ? ' selected="selected"' : '') . '>' . ($i<10 ? '0'.$i : $i) . '</option>' . "\n";
      }
      $this->html .= '  </select>' . "\n";          
    }
    
    if ($optional === false){
      $this->html .= '  <span class="required">*</span>' . "\n";
    }
    $this->html .= '</' . $this->div . '>' . "\n";
  }



  function TimeDropDown($ref, $optional=false){
    if ($GLOBALS['data'][$ref]){
      $tmp = $GLOBALS['data'][$ref];
      $t = explode(':', $tmp);

      $GLOBALS['data'][$this->Clean($ref) . "_hr"] = $t[0];
      $GLOBALS['data'][$this->Clean($ref) . "_mi"] = $t[1];
    }

    $data = $GLOBALS['data'][$this->Clean($ref) . "_hr"] . ':' . $GLOBALS['data'][$this->Clean($ref) . "_mi"];

    if ($_POST && !$_POST['back'] && $this->postData){
      if ($_POST[$this->Clean($ref) . "_hr"] < 10){
        $_POST[$this->Clean($ref) . "_hr"] = '0'.$_POST[$this->Clean($ref) . "_hr"];
      }
      if ($_POST[$this->Clean($ref) . "_mi"] < 10){
        $_POST[$this->Clean($ref) . "_mi"] = '0'.$_POST[$this->Clean($ref) . "_mi"];
      }

      $data = $_POST[$this->Clean($ref) . "_hr"] . ':' . $_POST[$this->Clean($ref) . "_mi"];
    }

    if ($optional === false || ($optional === true && strlen($data) != 0)) {
      $ereg = $this->regexpTime;
      if (!mb_eregi($ereg, $data)){
        $this->AddError($data, "$ref is not a valid date");
      }
    }
    $this->formData[$ref] = $data;
    $t = explode(':', $data);

    $this->html .= '<' . $this->div . '>' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";
    
    # hours
    $this->html .= '  <select name="' . $this->Clean($ref) . '_hr">' . "\n";
    $this->html .= '    <option value="">hr</option>' . "\n";
    for($i=0; $i<=23; $i++){
      $this->html .= '    <option value="' . $i . '"' . ($t[0]==$i ? ' selected="selected"' : '') . '>' . ($i<10 ? '0'.$i : $i) . '</option>' . "\n";
    }
    $this->html .= '  </select> : ' . "\n";
    
    # mins
    $this->html .= '  <select name="' . $this->Clean($ref) . '_mi">' . "\n";
    $this->html .= '    <option value="">mi</option>' . "\n";
    for($i=0; $i<=55; $i+=5){
      $this->html .= '    <option value="' . $i . '"' . ($t[1]==$i ? ' selected="selected"' : '') . '>' . ($i<10 ? '0'.$i : $i) . '</option>' . "\n";
    }
    $this->html .= '  </select>' . "\n";          
    
    if ($optional === false){
      $this->html .= '  <span class="required">*</span>' . "\n";
    }
    $this->html .= '</' . $this->div . '>' . "\n";
  }


  /*
   *  TIME
   */
  function Time($ref, $optional=false) {
    $data = $GLOBALS['data'][$ref];
    if ($_POST && !$_POST['back'] && $this->postData){
      $data = $_POST[$this->Clean($ref)];
    }

    if ($optional === false || ($optional === true && strlen($data) != 0) ) {
      if (!eregi($this->regexpTime, $data))
        $this->AddError($data, "$ref is not a valid time");
      $arrTime = explode(':', $data);
      if ($arrTime[0] > 23)
        $this->AddError($data, "$ref is not a valid time");
    }
    $this->formData[$ref] = $data;
    $this->html .= '<' . $this->div . '>' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";
    $this->html .= '  <input type="text" name="' . $this->Clean($ref) . '" id="' . $this->Clean($ref) . '" value="' . htmlspecialchars($this->formData[$ref]) . '" maxlengh="5" />' . "\n";
    if ($optional === false){
      $this->html .= '  <span class="required">*</span>' . "\n";
    }
    $this->html .= '</' . $this->div . '>' . "\n";
  }


  /*
   *  DATETIME
   */
  function DateTime($ref, $optional=false, $format='dd/mm/yy hh:mm') {
    $data = $GLOBALS['data'][$ref];
    if ($_POST && !$_POST['back'] && $this->postData){
      $data = $_POST[$this->Clean($ref)];
    }

    if ($optional === false || ($optional === true && strlen($data) != 0) ) {
      if (!mb_eregi($this->regexpDateTime, $data))
        $this->AddError($data, "$ref is not a valid date");
    }
    $this->formData[$ref] = $data;
  }


  /*
   *  URL FRIENDLY
   */
  function UrlFriendly($ref, $optional=false) {
    $data = $GLOBALS['data'][$ref];
    if ($_POST && !$_POST['back'] && $this->postData){
      $data = $_POST[$this->Clean($ref)];
    }

    $data = trim(strtolower($data));
    $regexp = $this->regexpUrlFriendlyStr;
    if ($optional === false || ($optional === true && strlen($data) != 0) ) {
      if (!mb_eregi($regexp, $data))
        $this->AddError($data, "$ref contains some invalid characters");
    }
    $this->formData[$ref] = $data;
  }


  /*
   *  BOOLEAN
   *
   *  Just looks for a true or false due, and returns '1' or '0' assuming this
   *  will placed into a db column that might only support a 1-bit integer
   */
  function Boolean($ref) {
    $data = $GLOBALS['data'][$ref];
    if ($_POST && !$_POST['back'] && $this->postData){
      $data = $_POST[$this->Clean($ref)];
    }

    $data = strtolower($data);
    if ($data == 1 || $data == "true")
      $this->formData[$ref] = 1;
    else if ($data == 0 || $data == "false")
      $this->formData[$ref] = 0;
    else {
      $this->AddError($data, "$ref must be true or false");
      $this->formData[$ref] = $data;
    }
  }

  /*
   *  CHECKBOX
   *
   *  No error checking for now, just convert to csv
   */
  function Checkbox($ref, $optional=false, $array=false) {
    $data = isset($GLOBALS['data'][$ref]) ? $GLOBALS['data'][$ref] : '';
    if ($_POST && !$_POST['back'] && $this->postData){
      $data = $_POST[$this->Clean($ref)];
    }

    if ($optional === false && !isset($_POST[$this->Clean($ref)])) {
      $this->AddError($data, "$ref is required");
    }

    $this->formData[$ref] = $data;

    $this->html .= '<' . $this->div . '>' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";
    $this->html .= '  <input type="checkbox" name="' . $this->Clean($ref) . ($array ? '[]' : '') . '" id="' . $this->Clean($ref) . '" ' . ($data=='on' || $data==1 ? ' checked="checked" ':'') . ' />' . "\n";
    if ($optional === false){
      $this->html .= '  <span class="required">*</span>' . "\n";
    }
    $this->html .= '</' . $this->div . '>' . "\n";
  }


  /*
   *  CHECKBOX
   *
   *  No error checking for now, just convert to csv
   */
  function Radio($ref, $optional=false, $options) {
    $data = $GLOBALS['data'][$ref];
    if ($_POST && !$_POST['back'] && $this->postData){
      $data = $_POST[$this->Clean($ref)];
    }

    if ($optional === false && !isset($_POST[$this->Clean($ref)])) {
      $this->AddError($data, "$ref is required");
    }

    $this->formData[$ref] = $data;

    $this->html .= '<' . $this->div . '>' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";
    $this->html .= '<span class="radio">';
    foreach ($options as $k => $v){
      $this->html .= '  <label class="radio"><input type="radio" ';
      $this->html .= 'name="' . $this->Clean($ref) . '" ';
      $this->html .= 'id="' . $this->Clean($ref) . '_' . $v . '" ';
      $this->html .= 'value="' . $v . '" ';
      $this->html .= ($data==$v ? ' checked="checked" ':'') . ' />' . $k . '</label>' . "\n";
    }
    if ($optional === false){
      $this->html .= '  <span class="required">*</span>' . "\n";
    }
    $this->html .= '</span>';
    $this->html .= '</' . $this->div . '>' . "\n";
  }

  function File($ref, $optional=false){
    $this->multipart = true;
    $this->html .= '<' . $this->div . '>' . "\n";
    if ($this->labels)
      $this->html .= '  <label for="' . $this->Clean($ref) . '">' . $ref . '</label>' . "\n";
    $this->html .= '  <input type="file" name="' . $this->Clean($ref) . '" id="' . $this->Clean($ref) . '"/>' . "\n";
    if ($optional === false){
      $this->html .= '  <span class="required">*</span>' . "\n";
    }
    $this->html .= '</' . $this->div . '>' . "\n";
  }

  /*
   *  MATCH TWO FIELDS
   *
   *  This method is unique in that it doesn't store the form data. It assumes
   *  the field's content has been dictated in another method and here it
   *  only records an error when necessary.
   */
  function Match($ref1, $ref2, $ref) {
    $data1 = $_POST[str_replace(" ", "_", $ref1)];
    $data2 = $_POST[str_replace(" ", "_", $ref2)];
    if (is_array($data2) && !in_array($data1, $data2)) {
      $this->AddError($data1, "$ref is not valid");
    } else if (!is_array($data2) && $data1 != $data2)
      $this->AddError($data1, "$ref fields do not match");
    $this->formData[$ref] = $data1;
  }


  /*
   *  STRIP HTML
   *
   *  Goes through the data array and removes all HTML, unless the field has
   *  been told to be ignored.
   */
  function StripHTML($ignore = array()) {
    foreach ($this->formData as $k=>$v) {
      if (!in_array($k, $ignore)){
        $this->formData[$k] = strip_tags($v);
      }else{
        # echo "Stripping $k with allowable_html";
        $this->formData[$k] = strip_tags($v, ALLOWABLE_HTML);
      }
    }
  }

  /*
   *  STRIP HTML
   *
   *  Goes through the data array and removes all HTML, unless the field has
   *  been told to be ignored.
   */
  function StripHTMLFields($fields = array()) {
    foreach ($this->formData as $k=>$v) {
      if (in_array($k, $fields)){
        # echo "Stripping $k with allowable_html";
        $this->formData[$k] = strip_tags($v, ALLOWABLE_HTML);
      }
    }
  }


  /*
   *  ADD SLASHES
   *
   *  Prepares all elements for database entry
   */
  function AddSlashes($ignore = array()) {
    foreach ($this->formData as $k=>$v) {
      if (!in_array($k, $ignore))
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

  function UrlString($ref, $delim="-"){
    $ref = strtolower($ref);
    $ref = stripslashes($ref);
    $replace = array(
      array(" ", $delim),
      array("&", "and"),
      array("!", ""),
      array("?", ""),
      array('"', ""),
      array("'", ""),
      array("/", ""),
      array("\\", ""),
      array(".", ""),
      array(",", ""),
      array(":", ""),
      array(";", ""),
      array("!", ""),
      array("#", "")
    );

    # Replace unwanted chars...
    foreach ($replace as $str){
      $ref = str_replace($str[0], $str[1], $ref);
    }

    # Removes multiple __ or -- etc.
    while(strstr($ref, $delim.$delim)){
      $ref = str_replace($delim.$delim, $delim, $ref);
    }

    $ref = urlencode($ref);
    return $ref;
  }

  /*
   *  ADD ERROR
   */
  function AddError($field, $msg) {
    global $log;
    if ($_POST){
      $log->add($msg);
    }
    $this->hasErrors = true;
    $this->errFields[] = $field;
    $this->errHelp[] = $msg;
  }

  function FieldSet($name, $open=true, $class=''){
    if ($open){
      $this->html .= '<fieldset class="' . $class . '">' . "\n";
      $this->html .= ' <legend>' . htmlspecialchars($name) . '</legend>' . "\n";
    }else{
      $this->html .= '</fieldset>' . "\n";
    }
  }

  function DrawForm($id="form", $submit, $cancel=false){
    $this->html = '<form id="' . $id . '" action="' . $this->action . '" method="post"' . ($this->multipart ? ' enctype="multipart/form-data"' : '') . '>' . "\n" . $this->html;
    $this->html .= '<' . $this->div . ' class="formoptions">' . "\n";
    $this->html .= '  <input type="submit" class="submit" value="' . $submit . '" />' . "\n";
    if ($cancel){
      $this->html .= '  <input type="button" class="cancel" value="' . $cancel . '" onclick="javascript:history.go(-1);" />' . "\n";
    }
    $this->html .= '</' . $this->div . '>' . "\n";
    $this->html .= '<div style="clear:both;"></div>';
    $this->html .= '</form>';
    echo $this->html;
  }

}