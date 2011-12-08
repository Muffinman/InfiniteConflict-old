<?

$research = $IC->Research->LoadAvailableResearch($_SESSION['ruler']['id']);
$queue = $IC->Research->LoadResearchQueue($_SESSION['ruler']['id']);

FB::log($queue);

$smarty->assign('research', $research);
$smarty->assign('queue', $queue);

$smarty->assign('content', $smarty->fetch('research.tpl'));


?>
