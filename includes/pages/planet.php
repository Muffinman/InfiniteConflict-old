<?
$error = true;

$res = $IC->LoadResources();

if ($request[1]){
  if ($planet = $IC->LoadPlanet($request[1])){
    $error = false;
  }
}


if (!$error){
  if ($_POST['building-list']){
    $IC->Planet->QueueBuilding($_SESSION['ruler']['id'], $planet['id'], $_POST['building-list']);
  }

  $resources = $IC->Planet->CalcPlanetResources($planet['id']);
  $buildings = $IC->Planet->CalcBuildingResources($planet['id']);
  $availableBuildings = $IC->Planet->LoadAvailableBuildings($_SESSION['ruler']['id'], $planet['id']);
  $buildingsQueue = $IC->Planet->LoadBuildingsQueue($_SESSION['ruler']['id'], $planet['id']);

  $smarty->assign('resList', $res);
  $smarty->assign('resources', $resources);
  $smarty->assign('buildings', $buildings);
  $smarty->assign('availableBuildings', $availableBuildings);
  $smarty->assign('buildingsQueue', $buildingsQueue);
  $smarty->assign('planet', $planet);
  $smarty->assign('content', $smarty->fetch('planet.tpl'));
}


else{
  error_page(404);
}

?>
