<?
$error = true;

$res = $IC->LoadResources();

if ($request[1]){
  if ($planet = $IC->LoadPlanet($request[1])){
    $error = false;
    
    if (!$IC->Planet->RulerOwnsPlanet($_SESSION['ruler']['id'], $planet['id'])){
    	$error = true;
    }
  }
}

if (!$error){
  if ($_POST['building-list']){
    $IC->Planet->QueueBuilding($_SESSION['ruler']['id'], $planet['id'], $_POST['building-list']);
  }

  $resources = $IC->Planet->CalcPlanetResources($planet['id']);
  $buildings = $IC->Planet->CalcBuildingResources($planet['id']);
  $template = 'planet.tpl';

  switch ($request[2]){
    case 'production':
        $template = 'production.tpl';
      break;
  
    default:
        $availableBuildings = $IC->Planet->LoadAvailableBuildings($_SESSION['ruler']['id'], $planet['id']);
        $buildingsQueue = $IC->Planet->LoadBuildingsQueue($_SESSION['ruler']['id'], $planet['id']);    
        $smarty->assign('availableBuildings', $availableBuildings);
        $smarty->assign('buildingsQueue', $buildingsQueue);
      break;
  }


  $smarty->assign('resList', $res);
  $smarty->assign('resources', $resources);
  $smarty->assign('buildings', $buildings);
  $smarty->assign('planet', $planet);
  $smarty->assign('content', $smarty->fetch($template));
}


else{
  error_page(404);
}

?>
