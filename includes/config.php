<?php
# Automatically send script report to Firebug on completion
$pagestart = time_tracker();
#register_shutdown_function('closedown', $pagestart);

# FirePHP and error reporting
ob_start();
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_DEPRECATED);
ini_set("display_errors", 'On');
require_once 'classes/fb.php';
//set_error_handler("myErrorHandler");

if (!session_id()) {
	session_start();
}

# Definitions
define('DEBUG', false);
define('SMTP_HOST', 'localhost');
define('SITE_LOCATION', 'http://'.$_SERVER['HTTP_HOST'].'/');
define('SITE_ROOTPATH', $_SERVER['DOCUMENT_ROOT'].'/');
define('SITE_HTTPPATH', SITE_LOCATION);
define('SCRIPT', basename($_SERVER['SCRIPT_FILENAME']));
define('COOKIE_NAME', 'ic_session');
define('COOKIE_LIFETIME', 365*24*3600);

# Environment settings (abve definitions can moved here if necessary)
if ($_SERVER['ENVIRONMENT'] == 'beta') {
  FB::setEnabled(true);
  $db_name = 'infiniteconflict';
  $db_user = 'infiniteconflict';
  $db_pass = 'n._aB-0n}*';
  $db_host = 'localhost';
} else {
  FB::setEnabled(false);
  $db_name = 'ic';
  $db_user = 'ic';
  $db_pass = 'matt15';
  $db_host = 'localhost';
  
  /*
  if ($_SERVER['REMOTE_ADDR']){
	  // If we're using the live server, then we need to force the main URL for the payment processing to work.
	  if ($_SERVER['HTTP_HOST'] != 'www.infiniteconflict.com'){
	    header('HTTP/1.1 301 Moved Permanently');
	    header('Location: http://www.infiniteconflict.com' . $_SERVER['REQUEST_URI']);
	  }
  }
  */
}

# Store paths in session (for AJAX scripts)
$_SESSION['paths']['website_root'] = SITE_ROOTPATH;
$_SESSION['paths']['website_http'] = SITE_HTTPPATH;

# Smarty
require_once 'smarty/Smarty.class.php';
$smarty = new Smarty;
$smarty->compile_check = true;
$smarty->debugging = false;

# Database connection
require_once 'classes/class.mysql.php';
$db = new mysql();
$db->dbName = $db_name;
$db->dbUser = $db_user;
$db->dbPass = $db_pass;
if (isset($db_host)){
  $db->dbHost = $db_host;
}
$db->Connect();
mysql_set_charset('utf8', $db->dbLink);

# Other includes
require_once 'functions.php';

/**
 * ONLY FUNCTIONS REQUIRED BY THIS SCRIPT ARE INCLUDED HERE. ALL OTHER
 * FUNCTIONS BELONG IN SEPARATE FILES
 */

function ReturnLink($url='', $label='') {
  $out = "<div class=\"backlink\">";
  $out .= "<a href=\"";
  !empty($url) ? $out .= $url : $out .= "javascript:history.go(-1)";
  $out .= "\">";
  !empty($label) ? $out .= $label : $out .= "Go back";
  $out .= "</a>";
  $out .= "</div>";
  return $out;
}

function time_tracker($start=0, $note='') {
  global $smarty;
	list($usec, $sec) = explode(" ", microtime());
  $t = ((float)$usec + (float)$sec);
	if ($start == 0) {
	  return $t;
  } else {
  	$t = number_format(($t - $start), 3);
		FB::info($t.'s', $note);
		$smarty->assign('page_time', $t);
		return $t;
	}
}

function closedown($pagestart) {
	global $db, $smarty;
	FB::info($db->numQueries.' ('.number_format($db->totalQueryTime, 3).'s)', 'Database queries');
	$smarty->assign('page_queries', $db->numQueries);
	$smarty->assign('page_query_time', number_format($db->totalQueryTime, 3));
	return time_tracker($pagestart, 'Total page time');
}

function myErrorHandler($errno, $errstr, $errfile, $errline) {
  $showDepreciated = false;
  $showUndefined = false;
  $ignoreScripts = array('nusoap.php');
  foreach ($ignoreScripts as $scriptName) {
    if ($errno != E_USER_ERROR && strpos($errfile, $scriptName)) {
      return true;
    }
  }
  $msg = " Line $errline in $errfile >> $errstr";
  switch ($errno) {
    case E_USER_ERROR:
      FB::error("FATAL ERROR: ".$msg." >> PHP " . PHP_VERSION . " (" . PHP_OS . ") ... Aborting!");
      exit(1);
      break;
    case E_USER_WARNING:
      FB::warn("WARNING: ".$msg);
      break;
    case E_USER_NOTICE:
      FB::info("NOTICE: ".$msg);
      break;
    case E_DEPRECATED:
      if (!$showDepreciated) {
        return true;
      } else {
        FB::info("DEPRECATED: ".$msg);
      }
      break;
    default:
      if (!$showUndefined && substr($errstr, 0, 9) == 'Undefined') {
        return true;
      } else {
        FB::info("Unknown error [$errno]: ".$msg);
      }
      break;
  }
  return true;
}
