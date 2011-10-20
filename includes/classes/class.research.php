<?

class Research extends IC {

  var $db;

  function __construct($db){
    $this->db = $db;
  }
  
  
  
  function LoadResearch(){
    $q = "SELECT * FROM research";
    return $db->Select($q);
  }
  
  
  
  function LoadRulerResearch($ruler_id){
    $q = "SELECT r.* FROM ruler_has_research AS rr
            LEFT JOIN research AS r ON rr.research_id = r.id
            WHERE rr.ruler_id='" . $this->db->esc($ruler_id) . "'";
    return $this->db->Select($q);
  }
  
  
  
  function LoadAvailableResearch($ruler_id){
    $research = $this->LoadResearch();    
    $current = $this->LoadRulerResearch($ruler_id);
    $available = array();
    #
   # Work in progress!
  #
    foreach ($research as $r){
      $preReq = $this->LoadResearchPrereq($r['id']);
      
    }
  #
   #
    #
    return $available;
  }
  
  
  
  function LoadResearchPrereq($research_id){
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
  
  
  function LoadResearchQueue($ruler_id){
    $q = "SELECT * FROM ruler_research_queue WHERE ruler_id='" . $this->db->esc($ruler_id) . "'";
    return $this->db->Select($q);
  }
  
}

?>
