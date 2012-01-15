<?

class Fleet extends IC {

	function __construct(&$db){
		$this->db = $db;
		$this->Planet = new Planet($db);
	}
	
	public function RulerOwnsFleet($ruler_id, $fleet_id){
		$fleet = $this->LoadFleet($fleet_id);
		
		if($fleet['ruler_id'] == $ruler_id){
			return true;
		}
		return false;	
	}
	
	public function LoadFleet($fleet_id){	
		$q = "SELECT f.*, p.name AS planet_name , p.ruler_id AS planet_ruler, p.galaxy_id, p.system_id FROM fleet AS f
						LEFT JOIN planet AS p ON f.planet_id = p.id
						WHERE f.id='" . $this->db->esc($fleet_id) . "'";
		if ($r = $this->db->Select($q)){
			return $r[0];
		}
		return false;
	}
	
	public function CreateFleet($ruler_id, $planet_id, $fleet_name){
		if ($this->Planet->RulerOwnsPlanet($ruler_id, $planet_id)){
			$arr = array(
				'name' => $fleet_name,
				'ruler_id' => $ruler_id,
				'planet_id' => $planet_id
			);
			return $this->db->QuickInsert('fleet', $arr);
		}
		return false;
	}
	
	public function LoadRulerFleets($ruler_id){
		$q = "SELECT f.*, p.name AS planet_name , p.ruler_id AS planet_ruler, p.galaxy_id, p.system_id FROM fleet AS f 
						LEFT JOIN planet AS p ON f.planet_id = p.id
						WHERE f.ruler_id='" . $this->db->esc($ruler_id) . "'
						ORDER BY f.id ASC";
		if ($r = $this->db->Select($q)){
			$fleets = array();
			foreach ($r as $row){
				if ($resources = $this->LoadFleetResources($row['fleet_id'])){
					foreach ($resources as $res){
						$row['resources'][$res['id']] = $res;
					}
				}
				
				$queue = $this->LoadFleetQueue($row['fleet_id']);
				
				$fleets[] = $row;
			}
			return $fleets;
		}
		return false;
	}
	
	public function LoadPlanetFleets($planet_id){
		$q = "SELECT f.*, p.name AS planet_name , p.ruler_id AS planet_ruler, p.galaxy_id, p.system_id FROM fleet AS f 
						LEFT JOIN planet AS p ON f.planet_id = p.id
						WHERE f.planet_id='" . $this->db->esc($planet_id) . "'
						ORDER BY f.id ASC";
		if ($r = $this->db->Select($q)){
			$fleets = array();
			foreach ($r as $row){
				$fleets[] = $row;
			}
			return $fleets;
		}
		return false;
	}	
	
	public function LoadFleetResources($fleet_id){
		$q = "SELECT * FROM fleet_has_resource WHERE fleet_id='" . $this->db->esc($fleet_id) . "'";
		return $this->db->Select($q);		
	}

	public function LoadFleetQueue($fleet_id){
		$q = "SELECT * FROM fleet_queue WHERE fleet_id='" . $this->db->esc($fleet_id) . "' ORDER BY rank ASC";
		return $this->db->Select($q);
	}	

}

?>