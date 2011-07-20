<?
$error = false;

if ($request[1]){
  if ($planet = $IC->LoadPlanet($request[1])){
    $resources = $IC->Planet->CalcPlanetResources($planet['id']);
    FB::log($resources);
  }else{
    $error = true;
  }
}else{
  $error = true;
}

$smarty->assign('resouces', $resources);
$smarty->assign('planet', $planet);
$smarty->assign('content', $smarty->fetch('planet.tpl'));



if ($error){
  error_page(404);
}

?>
