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

$Update = new Update($db);
$Update->process();


echo closedown($pagestart) . " Total time\n";
echo number_format($db->totalQueryTime, 3) . " Query time\n"; 
echo $db->numQueries . " Queries.\n";
echo $db->usedCache . " From cache.\n";

//echo "UPDATING";

?>
