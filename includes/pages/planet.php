<?
$error = true;

$res = $IC->LoadResources();

if ($request[1]){
  if ($planet = $IC->LoadPlanet($request[1])){
    $error = false;
    
    $planet['name'] = htmlspecialchars($planet['name']);
    
    if (!$IC->Planet->RulerOwnsPlanet($_SESSION['ruler']['id'], $planet['id'])){
    	$error = true;
    }
  }
}

if (!$error){
  if ($_POST['building-list']){
    $IC->Planet->QueueBuilding($_SESSION['ruler']['id'], $planet['id'], $_POST['building-list']);
  }

  $planet['next'] = $IC->Planet->LoadNextPlanet($_SESSION['ruler']['id'], $planet['id']);
  $planet['previous'] = $IC->Planet->LoadPreviousPlanet($_SESSION['ruler']['id'], $planet['id']);

  $resources = $IC->Planet->CalcPlanetResources($planet['id']);
  $template = 'planet.tpl';

  switch ($request[2]){
    case 'production':
		$availableProduction = $IC->Planet->LoadAvailableProduction($_SESSION['ruler']['id'], $planet['id']);
        $productionQueue = $IC->Planet->LoadProductionQueue($_SESSION['ruler']['id'], $planet['id']); 
        $produced = $IC->Planet->LoadProduced($planet['id']);
        $smarty->assign('produced', $produced);
        $smarty->assign('availableProduction', $availableProduction);
        $smarty->assign('productionQueue', $productionQueue);
        $template = 'production.tpl';
      break;

    case 'training':
        $availableTraining = $IC->Planet->LoadAvailableConversions($_SESSION['ruler']['id'], $planet['id']);
        $trainingQueue = $IC->Planet->LoadConversionQueue($_SESSION['ruler']['id'], $planet['id']); 
        $smarty->assign('availableTraining', $availableTraining);
        $smarty->assign('trainingQueue', $trainingQueue);
        $template = 'training.tpl';
      break;

    case 'comms':
        $template = 'comms.tpl';
      break;
  
    default:
        $availableBuildings = $IC->Planet->LoadAvailableBuildings($_SESSION['ruler']['id'], $planet['id']);
        $buildingsQueue = $IC->Planet->LoadBuildingsQueue($_SESSION['ruler']['id'], $planet['id']);    
        $buildings = $IC->Planet->CalcBuildingResources($planet['id']);
  		$smarty->assign('buildings', $buildings);
        $smarty->assign('availableBuildings', $availableBuildings);
        $smarty->assign('buildingsQueue', $buildingsQueue);
      break;
  }


  $smarty->assign('resList', $res);
  $smarty->assign('resources', $resources);
  $smarty->assign('planet', $planet);
  $smarty->assign('content', $smarty->fetch($template));
}


else{
  error_page(404);
}

?>
