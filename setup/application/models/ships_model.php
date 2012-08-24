<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ships_model extends CI_Model {

  function __construct(){
    parent::__construct();
  }

  public function read(){
    $q = "SELECT * FROM production ORDER BY id ASC";
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->result_array();
    }
    return false;
  }

  public function read_single($id){
    $q = "SELECT * FROM production WHERE id=" . $this->db->escape($id) . " LIMIT 1";
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->row_array();
    }
    return false;
  }


  public function building_list(){
    $q = "SELECT * FROM building ORDER BY id ASC";
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->result_array();
    }
    return false;
  }

  public function building_single($id){
    $q = "SELECT * FROM building WHERE id=" . $this->db->escape($id) . " LIMIT 1";
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->row_array();
    }
    return false;
  }


  public function create($data){
    $q = $this->db->insert_string('ship', $data);
    return $this->db->query($q);
  }

  public function update($id, $data){
    $q = $this->db->update_string('ship', $data, "id=".$this->db->escape($id));
    return $this->db->query($q);
  }

  public function delete($id){
    $q = "DELETE FROM production WHERE id=" . $this->db->escape($id);
    return $this->db->query($q);
  }

  public function resources_list(){
    $q = "SELECT * FROM resource ORDER BY id ASC";
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->result_array();
    }
    return false;
  }

  public function ship_resources_list($id){
    $q = "SELECT r.*, resource.name FROM production_has_resource AS r
            LEFT JOIN resource ON r.resource_id = resource.id
            WHERE production_id=" . $this->db->escape($id);
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->result_array();
    }
    return false;
  }

  public function ship_resources_single($id, $resource_id){
    $q = "SELECT r.*, resource.name FROM production_has_resource AS r
            LEFT JOIN resource ON r.resource_id = resource.id
            WHERE production_id=" . $this->db->escape($id) . '
            AND resource_id=' . $this->db->escape($resource_id); 
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->row_array();
    }
    return false;
  }

  public function resources_avail($id){
    $resources = $this->resources_list();
    $used = $this->ship_resources_list($id);

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
    $data['ship_id'] = $id;
    $q = $this->db->insert_string('production_has_resource', $data);
    return $this->db->query($q);
  }
  
  public function resources_update($id, $resource_id, $data){
    $q = $this->db->update_string('production_has_resource', $data, "production_id=" . $this->db->escape($id) . ' AND resource_id=' . $this->db->escape($resource_id));
    return $this->db->query($q);  
  }
  
  public function resources_delete($id, $resource_id){
    $q = "DELETE FROM production_has_resource WHERE production_id=" . $this->db->escape($id) . " AND resource_id=" . $this->db->escape($resource_id);
    return $this->db->query($q);
  }

  public function ships_preq_list($id){
    $q = "SELECT b.* FROM production_bld_prereq AS p
              LEFT JOIN building AS b ON p.building_id = b.id
              WHERE p.production_id=" . $this->db->escape($id);
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->result_array();
    }
    return false;
  }

  public function ships_preq_avail($id){
    $ships = $this->building_list();
    $used = $this->ships_preq_list($id);

    $avail = array();
    foreach ($ships as $b){
      if (!empty($used)){
        foreach ($used as $b2){
          if ($b2['building_id'] == $b['id']){
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

  public function ships_preq_create($id, $data){
    $data['production_id'] = $id;
    $q = $this->db->insert_string('production_bld_prereq', $data);
    return $this->db->query($q);
  }

  public function ships_preq_delete($id, $prereq){
    $q = "DELETE FROM production_bld_prereq WHERE production_id=" . $this->db->escape($id) . " AND building_id=" . $this->db->escape($prereq);
    return $this->db->query($q);
  }


  public function research_list(){
    $q = "SELECT * FROM research ORDER BY id ASC";
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->result_array();
    }
    return false;
  }


  public function research_preq_list($id){
    $q = "SELECT r.* FROM production_res_prereq AS p
              LEFT JOIN research AS r ON p.research_id = r.id
              WHERE p.production_id=" . $this->db->escape($id);
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->result_array();
    }
    return false;
  }

  public function research_preq_avail($id){
    $researches = $this->research_list();
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
    $data['production_id'] = $id;
    $q = $this->db->insert_string('production_res_prereq', $data);
    return $this->db->query($q);
  }

  public function research_preq_delete($id, $prereq){
    $q = "DELETE FROM production_res_prereq WHERE production_id=" . $this->db->escape($id) . " AND research_id=" . $this->db->escape($prereq);
    return $this->db->query($q);
  }

}

?>
