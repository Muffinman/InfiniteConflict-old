<?

$res = $IC->LoadResources();
$rulerPlanets = $IC->Ruler->LoadRulerPlanets($_SESSION['ruler']['id']);

$planets = array();
foreach ($rulerPlanets as $p){
  $p['resources'] = $IC->Planet->CalcPlanetResources($p['id']);
  $planets[] = $p;
}

$smarty->assign('resList', $res);
$smarty->assign('planets', $planets);
$smarty->assign('content', $smarty->fetch('planets.tpl'));


?>
