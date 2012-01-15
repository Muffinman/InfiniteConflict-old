<?

$db->cacheQueries = false;

$data = array();

if ($IC->Planet->RulerOwnsPlanet($_SESSION['ruler']['id'], $_POST['planet_id'])){
	if ($_POST['newfleet']){
		$IC->Fleet = new Fleet($db);
		$data['id'] = $IC->Fleet->CreateFleet($_SESSION['ruler']['id'], $_POST['planet_id'], $_POST['newfleet']);
		$data['response'] = 'success';
	}else{
		$data['response'] = 'failure';
	}
}else{
	$data['response'] = 'failure';
}




echo json_encode($data);
die;

?>
