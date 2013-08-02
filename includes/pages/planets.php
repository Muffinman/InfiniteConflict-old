<?

$res = $IC->LoadResources();
$rulerPlanets = $Ruler->LoadRulerPlanets($_SESSION['ruler']['id']);

$planets = array();
foreach ($rulerPlanets as $p){
	
	$p['name'] = htmlspecialchars($p['name']);
	$p['resources'] = $Planet->LoadPlanetResources2($p['id']);
	$p['building'] = $Planet->LoadBuildingsQueue($_SESSION['ruler']['id'], $p['id']);
	$p['production'] = $Planet->LoadProductionQueue($_SESSION['ruler']['id'], $p['id']);
	$p['training'] = $Planet->LoadConversionQueue($_SESSION['ruler']['id'], $p['id']);
 	$planets[] = $p;
}

$smarty->assign('resList', $res);
$smarty->assign('planets', $planets);
$smarty->assign('content', $smarty->fetch('planets.tpl'));


?>
