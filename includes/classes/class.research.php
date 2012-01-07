<?

class Research extends IC {

  var $db;

  public function __construct($db){
    $this->db = $db;
  }


  public function LoadResearch(){
    $q = "SELECT * FROM research";
    return $this->db->Select($q);
  }


  public function LoadRulerResearch($ruler_id){
    $q = "SELECT r.* FROM ruler_has_research AS rr
            LEFT JOIN research AS r ON rr.research_id = r.id
            WHERE rr.ruler_id='" . $this->db->esc($ruler_id) . "'";
    return $this->db->Select($q);
  }


  public function LoadResearchResources($research_id){
    $q = "SELECT * FROM research_has_resource
            WHERE research_id='" . $this->db->esc($research_id) . "'";
    if ($r = $this->db->Select($q)){
      $res = array();
      foreach($r as $row){
        $res[$row['resource_id']] = $row;
      }
      return $res;
    }
    return false;
  }
  
  
  public function LoadAvailableResearch($ruler_id){
    $research = $this->LoadResearch();    
    $current = $this->LoadRulerResearch($ruler_id);
    $queue = $this->LoadResearchQueue($ruler_id);
    $available = array();

    $currentIDs = array();
    if ($current){
      foreach ($current as $c){
        $currentIDs[] = $c['id'];
      }
    }
    if ($queue){
      foreach ($queue as $q){
        $currentIDs[] = $q['id'];
      }
    }
  
    if ($research){
      foreach ($research as $r){
        if (!in_array($r['id'], $currentIDs)){
          $preReq = $this->LoadResearchPrereq($r['id']);

          if ($preReq){
            if (!array_diff($preReq, $currentIDs)){
              $r['resources'] = $this->LoadResearchResources($r['id']);
              $available[] = $r;
            }   
          }else{
            $r['resources'] = $this->LoadResearchResources($r['id']);
            $available[] = $r;
          } 
        } 

      }
    }

    return $available;
  }


  public function LoadResearchPrereq($research_id){
    $q = "SELECT * FROM research_prereq WHERE research_id='" . $this->db->esc($research_id) . "'";
    if ($r = $this->db->Select($q)){
      $preReq = array();
      foreach ($r as $row){
        $preReq[] = $row['prereq'];
      }
      return $preReq;
    }
    return array();
  }
  

  public function LoadResearchPostreq($research_id){
    $q = "SELECT * FROM research_prereq WHERE prereq='" . $this->db->esc($research_id) . "'";
    if ($r = $this->db->Select($q)){
      $postReq = array();
      foreach ($r as $row){
        $postReq[] = $row['research_id'];
      }
      return $postReq;
    }
    return array();
  }
  
  public function LoadResearchQueue($ruler_id){
    $q = "SELECT r.*, rq.id AS queue_id, rq.turns AS turns_left, MD5(CONCAT(rq.id, '" . $ruler_id . "', rq.research_id)) AS hash FROM ruler_research_queue AS rq
            LEFT JOIN research AS r ON rq.research_id = r.id
            WHERE rq.ruler_id='" . $this->db->esc($ruler_id) . "'";
    return $this->db->Select($q);
  }


  public function ResearchIsAvailable($ruler_id, $research_id){
    if ($available = $this->LoadAvailableResearch($ruler_id)){
      foreach ($available as $a){
        if ($a['id'] == $research_id){
          return true;
        }
      }
    }
    return false;
  }


  public function QueueResearch($ruler_id, $research_id){
    if ($this->ResearchIsAvailable($ruler_id, $research_id)){
      $arr = array(
        'research_id' => $research_id,
        'ruler_id' => $ruler_id
      );
      return $this->db->QuickInsert('ruler_research_queue', $arr);
    }
    return false;
  }


  public function QueueResearchRemove($ruler_id, $hash=false, $research_id=false){
  	if ($hash){
	    $q = "SELECT * FROM ruler_research_queue WHERE MD5(CONCAT(id, '" . $ruler_id . "', research_id)) = '" . $this->db->esc($hash) . "' LIMIT 1";
	    if ($r = $this->db->Select($q)){
	    	if ($prereq = $this->LoadResearchPostreq($r[0]['research_id'])){
	    		foreach($prereq as $res){
	    			$this->QueueResearchRemove($ruler_id, false, $res);
	    		}
	    	}
	      return $this->db->QuickDelete('ruler_research_queue', $r[0]['id']);
	    }
    }
    
    if ($research_id){
	    $q = "SELECT * FROM ruler_research_queue WHERE ruler_id='" . $ruler_id . "' AND research_id='" . $this->db->esc($research_id) . "' LIMIT 1";
	    if ($r = $this->db->Select($q)){
	    	if ($prereq = $this->LoadResearchPostreq($r[0]['research_id'])){
	    		foreach($prereq as $res){
	    			$this->QueueResearchRemove($ruler_id, false, $res);
	    		}
	    	}
	      return $this->db->QuickDelete('ruler_research_queue', $r[0]['id']);
	    }    	
    }
    
    return false;
  }

  
}

?>
