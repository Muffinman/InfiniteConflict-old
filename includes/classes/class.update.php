<?

class Update extends IC{
	var $config;
	var $resources = array();
	
	function __construct($db){
		$this->db = $db;
		$this->db->useCache = false;
		$this->config = $this->LoadConfig();
		
		$this->Ruler = new Ruler($db);
		$this->Research = new Research($db);
		$this->Planet = new Planet($db);
	}
	
	
	// Main method to process update	
	public function process(){
		$this->SetUpdate();
		$this->ResearchQueues();
		$this->BuildingQueues();
		$this->ProductionQueues();
		$this->ConversionQueues();
		$this->FleetQueues();
		$this->LocalInterest();
		$this->GlobalInterest();
		$this->LocalOutputs();
		$this->GlobalOutputs();	
		$this->EndUpdate();
		return true;
	}
	
	
	private function ResearchQueues(){
		
		// Queues about to start
		$q = "SELECT rq.id, rq.ruler_id, rq.research_id, r.turns FROM ruler_research_queue AS rq
						LEFT JOIN research AS r ON rq.research_id = r.id
						WHERE rq.started IS NULL
						AND rq.turns IS NULL
						AND rank=1";
		if ($r = $this->db->Select($q)){
			foreach ($r as $row){
				if ($this->Research->ResearchIsAvailable($row['ruler_id'], $row['research_id'], false)){
					$afford = true;
					if ($resources = $this->Research->LoadResearchResources($row['research_id'])){
						foreach ($resources as $res){
							if ($res['cost'] > $this->Ruler->LoadResource($row['ruler_id'], $res['resource_id'])){
								$afford = false;
							}
						}
					}
					
					if ($afford === true){
						foreach ($resources as $res){
							$this->Ruler->VaryResource($row['ruler_id'], $res['resource_id'], -$res['cost']);
							$newrow = array(
								'id' => $row['id'],
								'started' => 1,
								'turns' => $row['turns']
							);
							$this->db->QuickEdit('ruler_research_queue', $newrow);
						}
					}
				}
			}
		}		
		

		// Already Started Queues
		$q = "UPDATE ruler_research_queue SET turns = turns-1
						WHERE started=1
						AND turns IS NOT NULL";
		$this->db->Edit($q);
		

		// Queues about to finish
		$q = "SELECT * FROM ruler_research_queue
						WHERE started =1
						AND turns=0
						AND rank=1";
		if ($r = $this->db->Select($q)){
			foreach ($r as $row){
				$arr = array(
					'ruler_id' => $row['ruler_id'],
					'research_id' => $row['research_id']
				);
				$this->db->QuickInsert('ruler_has_research', $arr);
				$this->db->QuickDelete('ruler_research_queue', $row['id']);
				$this->db->SortRank('ruler_research_queue', 'rank', 'id', "WHERE ruler_id='" . $this->db->esc($row['ruler_id']) . "'");
			}
		}		

	}
	
	
	private function BuildingQueues(){

		// Queues about to start
		$q = "SELECT * FROM planet_building_queue
						WHERE started IS NULL
						AND rank=1";
		if ($r = $this->db->Select($q)){
		
			foreach ($r as $row){

				$afford = true;
				if ($resources = $this->Planet->LoadBuildingResources($row['building_id'])){
					$output = $this->Planet->CalcPlanetResources($row['planet_id']);
					foreach ($resources as $res){
						if ($res['cost'] > $this->Planet->LoadPlanetResourcesStored($row['planet_id'], $res['resource_id']) && !$row['demolish']){
							$afford = false;
						}
						
						if ($res['output'] != 0){
							foreach ($output as $o){
								if ($o['id'] == $res['resource_id']){
									if ($o['output'] + $res['output'] < 0 && !$row['demolish']){
										$afford = false;
									}
									if ($o['output'] - $res['output'] < 0 && $row['demolish']){
										$afford = false;
									}
								}
							}
						}

						
						if ($res['stores'] > 0 && $row['demolish']){
							foreach ($output as $o){
								if ($o['id'] == $res['resource_id'] && $o['req_storage']){
									if ($o['stored'] > $o['storage'] - $res['stores'] && $o['stored'] > 0){
										$afford = false;
									}
								}
							}
						}
					}
				}
				
				if ($afford === true){
					foreach ($resources as $res){
						if (!$res['refund'] && !$row['demolish']){
							$this->Planet->VaryResource($row['planet_id'], $res['resource_id'], -$res['cost']);
						}
					}
					
					$newrow = array(
						'id' => $row['id'],
						'started' => 1,
					 	'turns' => $row['turns']
					);
					$this->db->QuickEdit('planet_building_queue', $newrow);
					
				}
				
			}
		}		
		
				
		// Already Started Queues
		$q = "UPDATE planet_building_queue SET turns = turns-1
						WHERE started=1
						AND turns IS NOT NULL";
		$this->db->Edit($q);


		// Queues about to finish
		$q = "SELECT * FROM planet_building_queue
						WHERE started=1
						AND turns<=0
						AND rank=1";
		if ($r = $this->db->Select($q)){
			foreach ($r as $row){
				
				$q = "SELECT pb.*, p.ruler_id FROM planet_has_building AS pb
								LEFT JOIN planet AS p ON pb.planet_id = p.id
								LEFT JOIN ruler AS r ON r.id = p.ruler_id
								WHERE pb.planet_id='" . $this->db->esc($row['planet_id']) . "'
								AND pb.building_id='" . $this->db->esc($row['building_id']) . "'";
				if ($r2 = $this->db->Select($q)){
								
					if ($row['demolish'] == 0){
						$r2[0]['qty'] += 1;
					}else{
						$r2[0]['qty'] -= 1;
					}
					
					$out = $r2[0];
					unset($out['ruler_id']);
										
					$this->db->QuickEdit('planet_has_building', $out);
				}else{
					if ($row['demolish'] == 0){
						$arr = array(
							'planet_id' => $row['planet_id'],
							'building_id' => $row['building_id'],
							'qty' => 1
						);
						$this->db->QuickInsert('planet_has_building', $arr);	
					}			
				}
				
				if ($row['demolish'] == 1){
					$q = "DELETE FROM planet_has_building WHERE qty<=0";
					$this->db->Edit($q);
				}
				
				if ($resources = $this->Planet->LoadBuildingResources($row['building_id'])){
					foreach ($resources as $res){
						if ($res['single_output']){
							if ($this->ResourceIsGlobal($res['resource'])){
								if ($row['demolish'] == 1){
									$this->Ruler->VaryResource($row['ruler_id'], $res['resource_id'], -$res['single_output']);
								}else{
									$this->Ruler->VaryResource($row['ruler_id'], $res['resource_id'], $res['single_output']);
								}						
							}else{
								if ($row['demolish'] == 1){
									$this->Planet->VaryResource($row['planet_id'], $res['resource_id'], -$res['single_output']);
								}else{
									$this->Planet->VaryResource($row['planet_id'], $res['resource_id'], $res['single_output']);
								}
							}
						}
						
						if ($row['demolish'] && $res['cost']){
							if ($this->ResourceIsGlobal($res['resource'])){
								$this->Ruler->VaryResource($row['ruler_id'], $res['resource_id'], $res['cost']);
							}else{
								$this->Planet->VaryResource($row['planet_id'], $res['resource_id'], $res['cost']);
							}
						}
						
						
					}
				}

				$this->db->QuickDelete('planet_building_queue', $row['id']);
				$this->db->SortRank('planet_building_queue', 'rank', 'id', "WHERE planet_id='" . $this->db->esc($row['planet_id']) . "'");
			}
		}	
		
		
	}
	
	
	private function ProductionQueues(){
		
	}
	
	
	private function ConversionQueues(){
		
	}
	
	
	private function FleetQueues(){
		
	}
	

	private function LocalInterest(){
		$res = $this->LoadResources();
		foreach ($res as $r){
			if ($r['interest'] != 0 && $r['global'] == 0){
				$q = "UPDATE planet_has_resource SET stored = stored * (1+" . $this->db->esc($r['interest']) . ") WHERE resource_id='" . $this->db->esc($r['id']) . "'";
				$this->db->Edit($q);
			}
		}
	}

	
	private function GlobalInterest(){
		$res = $this->LoadResources();
		foreach ($res as $r){
			if ($r['interest'] != 0 && $r['global'] == 1){
				$q = "UPDATE ruler_has_resource SET qty = qty * (1+" . $this->db->esc($r['interest']) . ") WHERE resource_id='" . $this->db->esc($r['id']) . "'";
				$this->db->Edit($q);
			}
		}		
	}


	private function LocalOutputs(){
		$q = "SELECT * FROM planet WHERE ruler_id IS NOT NULL";
		if ($r = $this->db->Select($q)){
			foreach ($r as $row){
				if ($output = $this->Planet->CalcPlanetResources($row['id'])){
					foreach ($output as $res){
						if (!$this->ResourceIsGlobal($res['id'])){
							if ($res['output'] != 0){
								$this->Planet->VaryResource($row['id'], $res['id'], $res['output']);
							}

							if ($res['stored'] + $res['output'] > $res['storage'] && $res['req_storage'] == 1){
								$this->Planet->SetResource($row['id'], $res['id'], $res['storage']);
							}
							if ($res['stored'] < 0){
								$this->Planet->SetResource($row['id'], $res['id'], 0);
							}
						}
					}
				}
			}
		}
	}

	
	private function GlobalOutputs(){
		$q = "SELECT * FROM planet WHERE ruler_id IS NOT NULL";
		if ($r = $this->db->Select($q)){
			foreach ($r as $row){
				if ($output = $this->Planet->CalcPlanetResources($row['id'])){
					foreach ($output as $res){
						if ($res['global']){
							$this->Ruler->VaryResource($row['ruler_id'], $res['id'], $res['output']);
						}	
						if ($res['stored']){
							if ($taxes = $this->LoadResourceTaxes($res['id'])){						
								foreach ($taxes as $tax){
									if ($this->ResourceIsGlobal($tax['output_resource'])){
										$this->Ruler->VaryResource($row['ruler_id'], $tax['output_resource'], $res['stored'] * $tax['rate']);
									}
								}							
							}
						}
					}
				}
			}
		}
		
		if ($rulers = $this->Ruler->LoadRulers()){
			foreach($rulers as $ruler){
				if ($resources = $this->Ruler->LoadRulerResources($ruler['id'])){
					foreach($resources as $res){
						if ($res['global']){
							if ($taxes = $this->LoadResourceTaxes($res['id'])){
								foreach ($taxes as $tax){
									if ($this->ResourceIsGlobal($tax['output_resource'])){
										$this->Ruler->VaryResource($ruler['id'], $tax['output_resource'], $res['stored'] * $tax['rate']);
									}
								}
							}
						}
					}
				}
			}
		}
	}	
	
	private function FixLocalStorage(){
		$q = "SELECT * FROM planet WHERE ruler_id IS NOT NULL";
		if ($r = $this->db->Select($q)){
			foreach ($r as $row){
				if ($output = $this->Planet->CalcPlanetResources($row['id'])){
					foreach ($output as $res){
						if ($res['stored'] > $res['storage'] && $res['req_storage'] == 1){
							$this->Planet->SetResource($row['id'], $res['id'], $res['storage']);
						}
						if ($res['stored'] < 0){
							$this->Planet->SetResource($row['id'], $res['id'], 0);
						}
					}
				}
			}
		}	
	}
	
	private function SetUpdate(){
		$this->config['update'] = 1;
		$q = "UPDATE config SET `val`=1 WHERE `key`='update'";
		$this->db->Edit($q);
	}

	
	private function EndUpdate(){
		$this->config['turn'] += 1;
		$this->config['update'] = 0;

		$q = "UPDATE config SET `val`='" . $this->db->esc($this->config['turn']) . "' WHERE `key`='turn'";
		$this->db->Edit($q);
		
		$q = "UPDATE config SET `val`=0 WHERE `key`='update'";
		$this->db->Edit($q);	
	}
	
	
	
	
}

?>