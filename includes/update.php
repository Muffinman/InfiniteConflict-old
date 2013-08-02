<?

if ($_SERVER['REMOTE_ADDR']){
	die();
}

$_SERVER['DOCUMENT_ROOT'] = '..';

#if (is_dir('/Applications/XAMPP/xamppfiles/')){
#	ini_set('mysql.default_socket', '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock');
#	ini_set('mysqli.default_socket', '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock');
#}

require_once('config.php');

FB::setEnabled(false);
ob_end_clean();

$IC = IC::getInstance();

$Update = new Update();
$Update->process();
$Update->pagestart = $pagestart;

if (is_numeric($argv[1]) && $argv[1] > 1){
	echo "Update 1 done\n\n";
	for ($i = 2; $i <= $argv[1]; $i++){
		$Update->db->ClearCache();
		$Update->process();
		echo "Update " . $i . " done\n\n";
	}
}

echo closedown($pagestart) . " Total time\n";
echo number_format($db->totalQueryTime, 3) . " Query time\n"; 
echo $db->numQueries . " Queries.\n";
echo $db->usedCache . " From cache.\n";

//echo "UPDATING";

?>
