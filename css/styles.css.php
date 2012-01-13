<?php

/**
* Inlcude all CSS files in here to ensure they're minified and 
* reduced to a single HTTP request.
*/


ob_start();
require_once 'reset.css';
require_once 'template.css';
//require_once 'login.css.php';
require_once 'planet.css';
require_once 'research.css';
require_once 'navigation.css';


$css = ob_get_contents();
ob_end_clean();

# output minified CSS only if live (to aid devleopment)
require_once 'includes/classes/cssmin.php';
$css = CssMin::minify($css);

$f = fopen('templates_c/styles.css', 'w+');
fwrite($f, $css);
fclose($f)

//header('Content-type: text/css'); 
//echo $css;

?>
