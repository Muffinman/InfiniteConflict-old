<?

$db->cacheQueries = false;

$data = array();

if ($IC->Planet->RulerOwnsPlanet($_SESSION['ruler']['id'], $_POST['planet_id'])){
	$data['planet_id'] = $_POST['planet_id'];
	
	switch($request[3]){
	
	  case 'add':
	      if ($id = $IC->Planet->QueueBuilding($_SESSION['ruler']['id'], $_POST['planet_id'], $_POST['building_id'])){
	        $data['response'] = 'success';
	        $data['id'] = $id;
	      }else{
	        $data['response'] = 'failure';
	        $data['id'] = $db->err_str;
	      }
	    break;
	    
	  case 'demolish':
	      if ($id = $IC->Planet->QueueBuilding($_SESSION['ruler']['id'], $_POST['planet_id'], $_POST['building_id'], true)){
	        $data['response'] = 'success';
	        $data['id'] = $id;
	      }else{
	        $data['response'] = 'failure';
	        $data['id'] = $db->err_str;
	      }
	    break;	    
	
	  case 'remove':
	      $IC->Planet->QueueBuildingRemove($_SESSION['ruler']['id'], $_POST['planet_id'], $request[4]);
	    break;
	
	  case 'reorder':
	      $IC->Planet->QueueBuildingReorder($_SESSION['ruler']['id'], $_POST['planet_id'], $_POST['hash']);
	    break;
	
	}
	
	if ($queue = $IC->Planet->LoadBuildingsQueue($_SESSION['ruler']['id'], $_POST['planet_id'])){
	  $data['queue'] = $queue;
	}
	$data['available'] = $IC->Planet->LoadAvailableBuildings($_SESSION['ruler']['id'], $_POST['planet_id']);
	$data['resources'] = $IC->LoadResources();
	
}else{
	$data['response'] = 'failure';
}




echo json_encode($data);
die;

?>
