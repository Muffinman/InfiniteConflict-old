<?

$scripts = array();
$scripts[] = 'jquery-1.6.2.min.js';
$scripts[] = 'jquery-ui-1.8.14.custom.min.js';
$scripts[] = 'main.js';

if (file_exists($_GET['p'] . '.js')){
  $scripts[] = $_GET['p'] . '.js';
}


header('Content-type: application/javascript');
foreach ($scripts as $script){
  echo file_get_contents($script) . "\n";
}


?>
