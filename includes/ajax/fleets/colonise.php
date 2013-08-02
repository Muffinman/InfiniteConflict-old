<?

$IC->Fleet = new Fleet($db);

if ($_POST['planet_name']){
	if ($Fleet->RulerOwnsFleet($_SESSION['ruler']['id'], $_POST['fleet_id'])){
		if ($fleet = $Fleet->LoadFleet($_POST['fleet_id'])){
			if ($planet = $IC->LoadPlanet($fleet['planet_id'])){
				if ($Fleet->CanColonise($_SESSION['ruler']['id'], $fleet['id'], $planet['id'])){
					$data['planet'] = $Planet->Colonise($_SESSION['ruler']['id'], $planet['id'], $_POST['planet_name'], $fleet['id']);
				}
			}
		}
	}
}

echo json_encode($data);
die;

?>