<?
$error = true;

$res = $IC->LoadResources();

if ($request[1]){
  if ($planet = $IC->LoadPlanet($request[1])){
    $error = false;
    
    $planet['name'] = htmlspecialchars($planet['name']);
    
    if (!$Planet->RulerOwnsPlanet($_SESSION['ruler']['id'], $planet['id'])){
    	$error = true;
    }
  }
}

if (!$error){
  if ($_POST['building-list']){
    $Planet->QueueBuilding($_SESSION['ruler']['id'], $planet['id'], $_POST['building-list']);
  }

  $planet['next'] = $Planet->LoadNextPlanet($_SESSION['ruler']['id'], $planet['id']);
  $planet['previous'] = $Planet->LoadPreviousPlanet($_SESSION['ruler']['id'], $planet['id']);

  $resources = $Planet->CalcPlanetResources($planet['id']);
  $template = 'planet.tpl';

  switch ($request[2]){
    case 'production':
		$availableProduction = $Planet->LoadAvailableProduction($_SESSION['ruler']['id'], $planet['id']);
        $productionQueue = $Planet->LoadProductionQueue($_SESSION['ruler']['id'], $planet['id']); 
        $produced = $Planet->LoadProduced($planet['id']);
        $smarty->assign('produced', $produced);
        $smarty->assign('availableProduction', $availableProduction);
        $smarty->assign('productionQueue', $productionQueue);
        $template = 'production.tpl';
      break;

    case 'training':
        $availableTraining = $Planet->LoadAvailableConversions($_SESSION['ruler']['id'], $planet['id']);
        $trainingQueue = $Planet->LoadConversionQueue($_SESSION['ruler']['id'], $planet['id']); 
        $smarty->assign('availableTraining', $availableTraining);
        $smarty->assign('trainingQueue', $trainingQueue);
        $template = 'training.tpl';
      break;

    case 'comms':
        $template = 'comms.tpl';
      break;
  
    default:
        $availableBuildings = $Planet->LoadAvailableBuildings($_SESSION['ruler']['id'], $planet['id']);
        $buildingsQueue = $Planet->LoadBuildingsQueue($_SESSION['ruler']['id'], $planet['id']);    
        $buildings = $Planet->CalcBuildingResources($planet['id']);
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
