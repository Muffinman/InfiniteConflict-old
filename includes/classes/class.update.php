<?

class Update extends IC{
	var $config;
	var $resources = array();
	
	function __construct($db){
		$this->db = $db;
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
		$this->TrainingQueues();
		$this->FleetQueues();
		$this->LocalOutputs();
		$this->GlobalOutputs();
		$this->LocalInterest();
		$this->GlobalInterest();
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
		
	}
	
	
	private function ProductionQueues(){
		
	}
	
	
	private function TrainingQueues(){
		
	}
	
	
	private function FleetQueues(){
		
	}
	
	
	private function LocalOutputs(){

	}

	
	private function GlobalOutputs(){
	
	}


	private function LocalInterest(){
	
	}

	
	private function GlobalInterest(){
		
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