<?php

/**
* Inlcude all CSS files in here to ensure they're minified and 
* reduced to a single HTTP request.
*/

ob_start();
require_once 'reset.css.php';
require_once 'template.css.php';



if ($_GET['p'] == 'login' || $_GET['p'] == 'register' || $_GET['p'] == 'forgetten' || $_GET['p'] == 'confirm'){
  require_once 'login.css.php';
}

if ($_GET['p'] == 'planets'){
  require_once 'planet.css.php';
}

if (file_exists($_GET['p'] . '.css.php')){
  require_once $_GET['p'] . '.css.php';
}

$css = ob_get_contents();
ob_end_clean();

# output minified CSS only if live (to aid devleopment)
#require_once '../includes/classes/cssmin.php';
#$css = CssMin::minify($css);

header('Content-type: text/css'); 
echo $css;

?>
