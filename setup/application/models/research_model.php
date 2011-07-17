<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Research_model extends CI_Model {

  function __construct(){
    parent::__construct();
  }

  public function read(){
    $q = "SELECT * FROM research ORDER BY id ASC";
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->result_array();
    }
    return false;
  }

  public function read_single($id){
    $q = "SELECT * FROM research WHERE id=" . $this->db->escape($id) . " LIMIT 1";
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->row_array();
    }
    return false;
  }

  public function create($data){
    $q = $this->db->insert_string('research', $data);
    return $this->db->query($q);
  }

  public function update($id, $data){
    $q = $this->db->update_string('research', $data, "id=".$this->db->escape($id));
    return $this->db->query($q);
  }

  public function delete($id){
    $q = "DELETE FROM research WHERE id=" . $this->db->escape($id);
    return $this->db->query($q);
  }

  public function resources_list(){
    $q = "SELECT * FROM resource WHERE global=1 ORDER BY id ASC";
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->result_array();
    }
    return false;
  }

  public function research_resources_list($id){
    $q = "SELECT r.*, resource.name FROM research_has_resource AS r
            LEFT JOIN resource ON r.resource_id = resource.id
            WHERE research_id=" . $this->db->escape($id);
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->result_array();
    }
    return false;
  }

  public function research_resources_single($id, $resource_id){
    $q = "SELECT r.*, resource.name FROM research_has_resource AS r
            LEFT JOIN resource ON r.resource_id = resource.id
            WHERE research_id=" . $this->db->escape($id) . '
            AND resource_id=' . $this->db->escape($resource_id);
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->row_array();
    }
    return false;
  }

  public function resources_avail($id){
    $resources = $this->resources_list();
    $used = $this->research_resources_list($id);

    $avail = array();
    foreach ($resources as $r){
      if (!empty($used)){
        foreach ($used as $r2){
          if ($r2['resource_id'] == $r['id']){
            continue 2;
          }
        }
      }
      $avail[] = $r;
    }
    if (!empty($avail)){
      return $avail;
    }
    return false;
  }

  public function resources_create($id, $data){
    $data['research_id'] = $id;
    $q = $this->db->insert_string('research_has_resource', $data);
    return $this->db->query($q);
  }
  
  public function resources_update($id, $resource_id, $data){
    $q = $this->db->update_string('research_has_resource', $data, "research_id=" . $this->db->escape($id) . ' AND resource_id=' . $this->db->escape($resource_id));
    return $this->db->query($q);  
  }
  
  public function resources_delete($id, $resource_id){
    $q = "DELETE FROM research_has_resource WHERE research_id=" . $this->db->escape($id) . " AND resource_id=" . $this->db->escape($resource_id);
    return $this->db->query($q);
  }

  public function research_preq_list($id){
    $q = "SELECT b.* FROM research_prereq AS p
              LEFT JOIN research AS b ON p.prereq = b.id
              WHERE p.research_id=" . $this->db->escape($id);
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->result_array();
    }
    return false;
  }

  public function research_preq_avail($id){
    $researches = $this->read();
    $used = $this->research_preq_list($id);

    $avail = array();
    foreach ($researches as $b){
      if (!empty($used)){
        foreach ($used as $b2){
          if ($b2['id'] == $b['id']){
            continue 2;
          }
        }
      }
      $avail[] = $b;
    }
    if (!empty($avail)){
      return $avail;
    }
    return false;
  }

  public function research_preq_create($id, $data){
    $data['research_id'] = $id;
    $q = $this->db->insert_string('research_prereq', $data);
    return $this->db->query($q);
  }

  public function research_preq_delete($id, $prereq){
    $q = "DELETE FROM research_prereq WHERE research_id=" . $this->db->escape($id) . " AND prereq=" . $this->db->escape($prereq);
    return $this->db->query($q);
  }

}

?>
