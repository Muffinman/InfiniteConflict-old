<?php

$IC->Fleet = new Fleet($db);

$fleets = $IC->Fleet->LoadRulerFleets($_SESSION['ruler']['id']);
$smarty->assign('fleets', $fleets);


$resources = $IC->LoadResources();

$smarty->assign('resources', $resources);
$smarty->assign('content', $smarty->fetch('fleets.tpl'));


?>