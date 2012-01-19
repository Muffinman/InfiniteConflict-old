<?php

$IC->Fleet = new Fleet($db);

if ($rulerFleets = $IC->Fleet->LoadRulerFleets($_SESSION['ruler']['id'])){
	$fleets = array();
	foreach ($rulerFleets as $f) {
		$f['name'] = htmlspecialchars($f['name']);
		$f['planet_name'] = htmlspecialchars($f['planet_name']);
		$fleets[] = $f;
	}
}

$resources = $IC->LoadResources();


$smarty->assign('fleets', $fleets);
$smarty->assign('resources', $resources);
$smarty->assign('content', $smarty->fetch('fleets.tpl'));


?>