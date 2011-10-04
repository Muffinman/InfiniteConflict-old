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
  
}

?>
