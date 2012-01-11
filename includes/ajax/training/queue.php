<?

$db->cacheQueries = false;

$data = array();


if ($IC->Planet->RulerOwnsPlanet($_SESSION['ruler']['id'], $_POST['planet_id'])){
	switch($request[3]){
	
	  case 'add':
	  	
	  	foreach ($_POST['training_id'] as $resource_id => $qty){
	  		if ($qty){
	  			$IC->Planet->QueueConversion($_SESSION['ruler']['id'], $_POST['planet_id'], $resource_id, $qty);
	  		}
	  	}

	    $data['response'] = 'success';
	    $data['id'] = $id;

	    break;
	
	  case 'remove':
	      $IC->Planet->QueueConversionRemove($_SESSION['ruler']['id'], $_POST['planet_id'], $request[4]);
	    break;
	
	  case 'reorder':
	      $IC->Planet->QueueConversionReorder($_SESSION['ruler']['id'], $_POST['planet_id'], $_POST['hash']);
	    break;
	
	}
	
	
	if ($queue = $IC->Planet->LoadConversionQueue($_SESSION['ruler']['id'], $_POST['planet_id'])){
	  $data['queue'] = $queue;
	}
	$data['available'] = $IC->Planet->LoadAvailableConversions($_SESSION['ruler']['id'], $_POST['planet_id']);
	$data['resources'] = $IC->LoadResources();
	
}else{
	$data['response'] = 'failure';
}

echo json_encode($data);
die;

?>
