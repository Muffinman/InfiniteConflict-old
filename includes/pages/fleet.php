<?
$error = true;

//$IC->Fleet = new Fleet($db);

$fleet = $Fleet->LoadFleet($request[1]);
$fleet['queue'] = $Fleet->LoadQueue($fleet['id']);
$fleet['name'] = htmlspecialchars($fleet['name']);
$fleet['planet_name'] = htmlspecialchars($fleet['planet_name']);

if ($rulerPlanets = $Ruler->LoadRulerPlanets($_SESSION['ruler']['id'])){
	$planets = array();
	foreach($rulerPlanets as $p){
		$p['name'] = htmlspecialchars($p['name']);
		$planets[] = $p;
	}
}

$resources = $IC->LoadResources();
$production = $Planet->LoadProduction();

if ($fleet['planet_id']){
	$colonise = $Fleet->CanColonise($_SESSION['ruler']['id'], $fleet['id'], $fleet['planet_id']);
	$smarty->assign('colonise', $colonise);
}

if ($fleet){

	if ($Fleet->RulerOwnsFleet($_SESSION['ruler']['id'], $fleet['id'])){		
		
		if ($_POST['transfer-dest'] && $request[2] == 'transfer'){
			$dest = explode("_", $_POST['transfer-dest']);
			$dest_type = $dest[0];
			$dest_id = $dest[1];
			
			if ($dest_type != 'planet' && $dest_type != 'fleet'){
				unset($dest_type);
				unset($dest_id);
			}
			
			if ($dest_type == 'planet'){
				if (!$Planet->RulerOwnsPlanet($_SESSION['ruler']['id'], $dest_id)){
					unset($dest_type);
					unset($dest_id);
				}
				if (!$Fleet->RulerOwnsFleet($_SESSION['ruler']['id'], $fleet['id'])){
					unset($dest_type);
					unset($dest_id);
				}
				if ($dest_id != $fleet['planet_id']){
					unset($dest_type);
					unset($dest_id);		
				}
			}
		
			if ($dest_type == 'fleet'){
				if (!$Fleet->RulerOwnsFleet($_SESSION['ruler']['id'], $dest_id)){
					unset($dest_type);
					unset($dest_id);
				}
				if (!$Fleet->RulerOwnsFleet($_SESSION['ruler']['id'], $fleet['id'])){
					unset($dest_type);
					unset($dest_id);
				}
			}	
		}
		
		// Transfer from planet to current fleet
		if ($_POST['from-planet'] && $dest_type=='planet' && $request[2] == 'transfer'){
			if ($_POST['resource']){
				foreach($_POST['resource'] as $k => $v){
					if ($v){
						$Fleet->PlanetToFleetResource($dest_id, $fleet['id'], $k, $v);
					}
				}
			}
			if ($_POST['produced']){
				foreach($_POST['produced'] as $k => $v){
					if ($v){
						$Fleet->PlanetToFleetProduction($dest_id, $fleet['id'], $k, $v);
					}
				}
			}
			header('Location: /fleet/' . $fleet['id']);
			die;
		}
		
		// Transfer from current fleet to planet
		if ($_POST['from-current-fleet'] && $dest_type=='planet' && $request[2] == 'transfer'){
			if ($_POST['resource']){
				foreach($_POST['resource'] as $k => $v){
					if ($v){
						$Fleet->FleetToPlanetResource($fleet['id'], $dest_id, $k, $v);
					}
				}
			}
			if ($_POST['produced']){
				foreach($_POST['produced'] as $k => $v){
					if ($v){
						$Fleet->FleetToPlanetProduction($fleet['id'], $dest_id, $k, $v);
					}
				}
			}
			header('Location: /fleet/' . $fleet['id']);
			die;
		}
		
		// Transfer from current fleet to other fleet
		if ($_POST['from-current-fleet'] && $dest_type=='fleet' && $request[2] == 'transfer'){
			if ($_POST['resource']){
				foreach($_POST['resource'] as $k => $v){
					if ($v){
						$Fleet->FleetToFleetResource($fleet['id'], $dest_id, $k, $v);
					}
				}
			}
			if ($_POST['produced']){
				foreach($_POST['produced'] as $k => $v){
					if ($v){
						$Fleet->FleetToFleetProduction($fleet['id'], $dest_id, $k, $v);
					}
				}
			}
			//header('Location: /fleet/' . $fleet['id']);
			//die;
		}
		
		// Transfer from other fleet to current fleet
		if ($_POST['from-other-fleet'] && $dest_type=='fleet' && $request[2] == 'transfer'){
			if ($_POST['resource']){
				foreach($_POST['resource'] as $k => $v){
					if ($v){
						$Fleet->FleetToFleetResource($dest_id, $fleet['id'], $k, $v);
					}
				}
			}
			if ($_POST['produced']){
				foreach($_POST['produced'] as $k => $v){
					if ($v){
						$Fleet->FleetToFleetProduction($dest_id, $fleet['id'], $k, $v);
					}
				}
			}
			//header('Location: /fleet/' . $fleet['id']);
			//die;
		}
		


		

		
		if ($_POST['planet_id'] > 0){
			$Fleet->AddToQueue($fleet['id'], 'move', 'planet_id', $_POST['planet_id'], false, $_POST['repeat']);
			header('Location: /fleet/' . $fleet['id']);
			die;
		}
		
		if ($_POST['wait'] > 0){
			$Fleet->AddToQueue($fleet['id'], 'wait', 'turns', $_POST['wait'], $_POST['wait'], $_POST['repeat']);
			header('Location: /fleet/' . $fleet['id']);
			die;
		}
		
		if ($_POST['unloadall']){
			$Fleet->AddToQueue($fleet['id'], 'unloadall', false, false, false, $_POST['repeat']);
			header('Location: /fleet/' . $fleet['id']);
			die;
		}
		
		if ($_POST['addtoqueue'] == 'Load'){
			foreach($_POST['production'] as $k => $v){
				if ($v > 0){
					$Fleet->AddToQueue($fleet['id'], 'load', 'production_id', $k, $v, $_POST['repeat']);
				}
			}
			foreach($_POST['resource'] as $k => $v){
				if ($v > 0){
					$Fleet->AddToQueue($fleet['id'], 'load', 'resource_id', $k, $v, $_POST['repeat']);
				}
			}
			header('Location: /fleet/' . $fleet['id']);
			die;
		}
		
		if ($_POST['addtoqueue'] == 'Unload'){
			foreach($_POST['production'] as $k => $v){
				if ($v > 0){
					$Fleet->AddToQueue($fleet['id'], 'unload', 'production_id', $k, $v, $_POST['repeat']);
				}
			}
			foreach($_POST['resource'] as $k => $v){
				if ($v > 0){
					$Fleet->AddToQueue($fleet['id'], 'unload', 'resource_id', $k, $v, $_POST['repeat']);
				}
			}
			header('Location: /fleet/' . $fleet['id']);
			die;
		}
		



	
			
		if ($Planet->RulerOwnsPlanet($_SESSION['ruler']['id'], $fleet['planet_id'])){
			$planet = $IC->LoadPlanet($fleet['planet_id']);
			$planet['produced'] = $Planet->LoadProduced($fleet['planet_id']);
			$planet['resources'] = $Planet->LoadPlanetResources($fleet['planet_id']);
			$planet['name'] = htmlspecialchars($planet['name']);
			$smarty->assign('planet', $planet);
			
			if (!$dest_type || !$dest_id){
				$dest_type = 'planet';
				$dest_id = $planet['id'];
			}
		}
		
		if ($fleets = $Fleet->LoadPlanetFleets($fleet['planet_id'], $_SESSION['ruler']['id'])){
			$out = array();
			foreach($fleets as $f){
				if ($f['id'] != $fleet['id']){
					$f['produced'] = $Fleet->LoadProduced($f['id']);
					$f['resources'] = $Fleet->LoadFleetResources($f['id']);
					$f['name'] = htmlspecialchars($f['name']);
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

	$smarty->assign('production', $production);
	$smarty->assign('resources', $resources);
	$smarty->assign('planets', $planets);
	$smarty->assign('fleet', $fleet);
	$smarty->assign('content', $smarty->fetch('fleet.tpl'));
}else{
  error_page(404);
}


?>