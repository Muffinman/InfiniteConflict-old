<?php

$_SESSION['ruler']['id'];

// If ruler is in alliance
if ($_SESSION['ruler']['alliance_id']){
	$alliance = $Ruler->LoadAlliance($_SESSION['ruler']['alliance_id']);
	$smarty->assign('alliance', $alliance);

	if ($request[1] == 'members'){
		$members = $Ruler->LoadAllianceMembers($alliance['id']);
		$smarty->assign('members', $members);
		$smarty->assign('content', $smarty->fetch('alliance_members.tpl'));
	}

	elseif ($request[1] == 'requests'){
		$smarty->assign('content', $smarty->fetch('alliance_requests.tpl'));
	}

	elseif ($request[1] == 'forums'){
		$smarty->assign('content', $smarty->fetch('alliance_forums.tpl'));
	}

	elseif ($request[1] == 'diplomacy'){
		$smarty->assign('content', $smarty->fetch('alliance_diplomacy.tpl'));
	}

	else {
		$smarty->assign('content', $smarty->fetch('alliance_members.tpl'));
	}
}


// If ruler is not in alliance
else {

	if ($request[1] == 'create' && $_POST['name']){
		if ($alliance = $Ruler->CreateAlliance($_POST['name'], $_SESSION['ruler']['id'])){
			$_SESSION['ruler']['alliance_id'] = $alliance['id'];
			header('Location: /alliances');
			die;
		}
	}

	$alliances = $Ruler->LoadAlliances();
	$smarty->assign('alliances', $alliances);
	$smarty->assign('content', $smarty->fetch('alliances.tpl'));
}

?>