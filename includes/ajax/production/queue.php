<?

$db->cacheQueries = false;

$data = array();


if ($IC->Planet->RulerOwnsPlanet($_SESSION['ruler']['id'], $_POST['planet_id'])){
	switch($request[3]){
	
	  case 'add':
	  	
	  	foreach ($_POST['production_id'] as $production_id => $qty){
	  		if ($qty){
	  			$IC->Planet->QueueProduction($_SESSION['ruler']['id'], $_POST['planet_id'], $production_id, $qty);
	  		}
	  	}

	    $data['response'] = 'success';
	    $data['id'] = $id;

	    break;
	
	  case 'remove':
	      $IC->Planet->QueueProductionRemove($_SESSION['ruler']['id'], $_POST['planet_id'], $request[4]);
	    break;
	
	  case 'reorder':
	      $IC->Planet->QueueProductionReorder($_SESSION['ruler']['id'], $_POST['planet_id'], $_POST['hash']);
	    break;
	
	}
	
	
	if ($queue = $IC->Planet->LoadProductionQueue($_SESSION['ruler']['id'], $_POST['planet_id'])){
	  $data['queue'] = $queue;
	}
	$data['available'] = $IC->Planet->LoadAvailableProduction($_SESSION['ruler']['id'], $_POST['planet_id']);
	$data['resources'] = $IC->LoadResources();
	
}else{
	$data['response'] = 'failure';
}

echo json_encode($data);
die;

?>
