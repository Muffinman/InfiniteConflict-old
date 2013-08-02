<?

$research = $Research->LoadAvailableResearch($_SESSION['ruler']['id']);
$queue = $Research->LoadResearchQueue($_SESSION['ruler']['id']);

$smarty->assign('research', $research);
$smarty->assign('queue', $queue);

$smarty->assign('content', $smarty->fetch('research.tpl'));


?>
