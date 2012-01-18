<?php

$IC->Fleet = new Fleet($db);

$fleets = $IC->Fleet->LoadRulerFleets($_SESSION['ruler']['id']);
$resources = $IC->LoadResources();


$smarty->assign('fleets', $fleets);
$smarty->assign('resources', $resources);
$smarty->assign('content', $smarty->fetch('fleets.tpl'));


?>