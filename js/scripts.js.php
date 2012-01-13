<?

$scripts = array();
$scripts[] = 'jquery-1.6.2.min.js';
$scripts[] = 'jquery-ui-1.8.14.custom.min.js';
$scripts[] = 'main.js';
$scripts[] = 'research.js';
$scripts[] = 'planet.js';

$js = '';
foreach ($scripts as $script){
  $js .= file_get_contents('js/' . $script);
}

require_once('includes/classes/jsmin.class.php');
$js = JSMin::minify($js);

$f = fopen('templates_c/scripts.js', 'w+');
fwrite($f, $js);
fclose($f)

?>
