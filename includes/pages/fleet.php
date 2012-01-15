<?
$error = true;

$IC->Fleet = new Fleet($db);

if ($request[1]){
	if ($fleet = $IC->Fleet->LoadFleet($request[1])){
		if ($IC->Fleet->RulerOwnsFleet($_SESSION['ruler']['id'], $fleet['id'])){
			$error = false;
		}else{
			$error = true;
		}
	}
}

if (!$error){
	$smarty->assign('fleet', $fleet);
	$smarty->assign('content', $smarty->fetch('fleet.tpl'));
}else{
  error_page(404);
}


?>