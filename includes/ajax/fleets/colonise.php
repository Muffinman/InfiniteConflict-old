<?

$IC->Fleet = new Fleet($db);

if ($IC->Fleet->RulerOwnsFleet($_SESSION['ruler']['id'], $_POST['fleet_id'])){
	if ($fleet = $IC->Fleet->LoadFleet($_POST['fleet_id'])){
		if ($planet = $IC->Planet->LoadPlanet($fleet['planet_id'])){
			if ($IC->Fleet->CanColonise($fleet['id'], $planet['id'])){
				$IC->Planet->Colonise($_SESSION['ruler']['id'], $planet['id'], $_POST['planet_name'], $fleet['id']);
			}
		}
	}
}

echo json_encode($data);
die;

?>