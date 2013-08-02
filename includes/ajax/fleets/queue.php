<?

$db->cacheQueries = false;

$data = array();

if ($Fleet->RulerOwnsFleet($_SESSION['ruler']['id'], $_POST['fleet_id'])){
	switch($request[3]){ 
	
	  case 'remove':
	      $Fleet->QueueRemove($_SESSION['ruler']['id'], $_POST['fleet_id'], $request[4]);
	    break;
	
	  case 'reorder':
	      $Fleet->QueueReorder($_SESSION['ruler']['id'], $_POST['fleet_id'], $_POST['hash']);
	    break;
	
	}
	
	if ($queue = $Fleet->LoadQueue($_POST['fleet_id'])){
	  $data['queue'] = $queue;
	}
	
}else{
	$data['response'] = 'failure';
}




echo json_encode($data);
die;

?>
