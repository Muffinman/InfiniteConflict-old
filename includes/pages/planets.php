<?

$res = $IC->LoadResources();
$rulerPlanets = $IC->Ruler->LoadRulerPlanets($_SESSION['ruler']['id']);

$planets = array();
foreach ($rulerPlanets as $p){
	
	$p['name'] = htmlspecialchars($p['name']);
	$p['resources'] = $IC->Planet->CalcPlanetResources($p['id']);
	$p['building'] = $IC->Planet->LoadBuildingsQueue($_SESSION['ruler']['id'], $p['id']);
	$p['production'] = $IC->Planet->LoadProductionQueue($_SESSION['ruler']['id'], $p['id']);
	$p['training'] = $IC->Planet->LoadConversionQueue($_SESSION['ruler']['id'], $p['id']);
 	$planets[] = $p;
}

$smarty->assign('resList', $res);
$smarty->assign('planets', $planets);
$smarty->assign('content', $smarty->fetch('planets.tpl'));


?>
