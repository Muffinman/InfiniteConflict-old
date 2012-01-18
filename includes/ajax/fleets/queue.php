<?

$db->cacheQueries = false;

$IC->Fleet = new Fleet($db);

$data = array();

if ($IC->Fleet->RulerOwnsFleet($_SESSION['ruler']['id'], $_POST['fleet_id'])){
	switch($request[3]){ 
	
	  case 'remove':
	      $IC->Fleet->QueueRemove($_SESSION['ruler']['id'], $_POST['fleet_id'], $request[4]);
	    break;
	
	  case 'reorder':
	      $IC->Fleet->QueueReorder($_SESSION['ruler']['id'], $_POST['fleet_id'], $_POST['hash']);
	    break;
	
	}
	
	if ($queue = $IC->Fleet->LoadQueue($_SESSION['ruler']['id'], $_POST['fleet_id'])){
	  $data['queue'] = $queue;
	}
	
}else{
	$data['response'] = 'failure';
}




echo json_encode($data);
die;

?>
