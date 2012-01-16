<?
$error = true;

$IC->Fleet = new Fleet($db);

$fleet = $IC->Fleet->LoadFleet($request[1]);

if ($_POST['transfer-dest']){
	$dest = explode("_", $_POST['transfer-dest']);
	$dest_type = $dest[0];
	$dest_id = $dest[1];
	
	if ($dest_type != 'planet' && $dest_type != 'fleet'){
		unset($dest_type);
		unset($dest_id);
	}
	
	if ($dest_type == 'planet'){
		if (!$IC->Planet->RulerOwnsPlanet($_SESSION['ruler']['id'], $dest_id)){
			unset($dest_type);
			unset($dest_id);
		}
		if (!$IC->Fleet->RulerOwnsFleet($_SESSION['ruler']['id'], $fleet['id'])){
			unset($dest_type);
			unset($dest_id);
		}
		if ($dest_id != $fleet['planet_id']){
			unset($dest_type);
			unset($dest_id);		
		}
	}

	if ($dest_type == 'fleet'){
		if (!$IC->Fleet->RulerOwnsFleet($_SESSION['ruler']['id'], $dest_id)){
			unset($dest_type);
			unset($dest_id);
		}
		if (!$IC->Fleet->RulerOwnsFleet($_SESSION['ruler']['id'], $fleet['id'])){
			unset($dest_type);
			unset($dest_id);
		}
	}	
}

// Transfer from planet to current fleet
if ($_POST['from-planet'] && $dest_type=='planet'){
	if ($_POST['resource']){
		foreach($_POST['resource'] as $k => $v){
			if ($v){
				$IC->Fleet->PlanetToFleetResource($dest_id, $fleet['id'], $k, $v);
			}
		}
	}
	if ($_POST['produced']){
		foreach($_POST['produced'] as $k => $v){
			if ($v){
				$IC->Fleet->PlanetToFleetProduction($dest_id, $fleet['id'], $k, $v);
			}
		}
	}
	header('Location: /fleet/' . $fleet['id']);
	die;
}

// Transfer from current fleet to planet
if ($_POST['from-current-fleet'] && $dest_type=='planet'){
	if ($_POST['resource']){
		foreach($_POST['resource'] as $k => $v){
			if ($v){
				$IC->Fleet->FleetToPlanetResource($fleet['id'], $dest_id, $k, $v);
			}
		}
	}
	if ($_POST['produced']){
		foreach($_POST['produced'] as $k => $v){
			if ($v){
				$IC->Fleet->FleetToPlanetProduction($fleet['id'], $dest_id, $k, $v);
			}
		}
	}
	//header('Location: /fleet/' . $fleet['id']);
	//die;
}

// Transfer from current fleet to other fleet
if ($_POST['from-current-fleet'] && $dest_type=='fleet'){
	if ($_POST['resource']){
		foreach($_POST['resource'] as $k => $v){
			if ($v){
				$IC->Fleet->FleetToFleetResource($fleet['id'], $dest_id, $k, $v);
			}
		}
	}
	if ($_POST['produced']){
		foreach($_POST['produced'] as $k => $v){
			if ($v){
				$IC->Fleet->FleetToFleetProduction($fleet['id'], $dest_id, $k, $v);
			}
		}
	}
	//header('Location: /fleet/' . $fleet['id']);
	//die;
}

// Transfer from other fleet to current fleet
if ($_POST['from-other-fleet'] && $dest_type=='fleet'){
	if ($_POST['resource']){
		foreach($_POST['resource'] as $k => $v){
			if ($v){
				$IC->Fleet->FleetToFleetResource($dest_id, $fleet['id'], $k, $v);
			}
		}
	}
	if ($_POST['produced']){
		foreach($_POST['produced'] as $k => $v){
			if ($v){
				$IC->Fleet->FleetToFleetProduction($dest_id, $fleet['id'], $k, $v);
			}
		}
	}
	//header('Location: /fleet/' . $fleet['id']);
	//die;
}



if ($fleet){
	if ($IC->Fleet->RulerOwnsFleet($_SESSION['ruler']['id'], $fleet['id'])){
			
		if ($IC->Planet->RulerOwnsPlanet($_SESSION['ruler']['id'], $fleet['planet_id'])){
			$planet = $IC->LoadPlanet($fleet['planet_id']);
			$planet['produced'] = $IC->Planet->LoadProduced($fleet['planet_id']);
			$planet['resources'] = $IC->Planet->LoadPlanetResources($_SESSION['ruler']['id'], $fleet['planet_id']);
			$smarty->assign('planet', $planet);
			
			if (!$dest_type || !$dest_id){
				$dest_type = 'planet';
				$dest_id = $planet['id'];
			}
			
		}
		
		if ($fleets = $IC->Fleet->LoadPlanetFleets($fleet['planet_id'], $_SESSION['ruler']['id'])){
			$out = array();
			foreach($fleets as $f){
				if ($f['id'] != $fleet['id']){
					$f['produced'] = $IC->Fleet->LoadProduced($f['id']);
					$f['resources'] = $IC->Fleet->LoadResources($f['id']);
					$out[] = $f;
				}
			}
			if (!empty($out)){
				$smarty->assign('fleets', $out);
			}
			
		}
	
		$error = false;
	}else{
		$error = true;
	}
}


if (!$error){

		
	$smarty->assign('dest_type', $dest_type);
	$smarty->assign('dest_id', $dest_id);

	$smarty->assign('fleet', $fleet);
	$smarty->assign('content', $smarty->fetch('fleet.tpl'));
}else{
  error_page(404);
}


?>