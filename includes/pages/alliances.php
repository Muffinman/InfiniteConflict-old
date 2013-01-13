<?php

$_SESSION['ruler']['id'];

// If ruler is in alliance
if ($_SESSION['ruler']['alliance_id']) {
	$alliance = $IC->Ruler->LoadAlliance($_SESSION['ruler']['alliance_id']);
	$smarty->assign('alliance', $alliance);
}


// If ruler is not in alliance
else {

	if ($request[1] == 'create' && $_POST['name']){
		if ($alliance = $IC->Ruler->CreateAlliance($_POST['name'], $_SESSION['ruler']['id'])){
			$_SESSION['ruler']['alliance_id'] = $alliance['id'];
			header('Location: /alliances');
			die;
		}
	}

	$alliances = $IC->Ruler->LoadAlliances();
	$smarty->assign('alliances', $alliances);

}

$smarty->assign('content', $smarty->fetch('alliances.tpl'));

?>