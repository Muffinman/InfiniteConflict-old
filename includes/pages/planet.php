<?
$error = false;
$res = $IC->Planet->LoadResources();


if ($request[1]){
  if ($planet = $IC->LoadPlanet($request[1])){
    $resources = $IC->Planet->CalcPlanetResources($planet['id']);
    $buildings = $IC->Planet->CalcBuildingResources($planet['id']);
  }else{
    $error = true;
  }
}else{
  $error = true;
}

$smarty->assign('resList', $res);
$smarty->assign('resources', $resources);
$smarty->assign('buildings', $buildings);
$smarty->assign('planet', $planet);
$smarty->assign('content', $smarty->fetch('planet.tpl'));



if ($error){
  error_page(404);
}

?>
