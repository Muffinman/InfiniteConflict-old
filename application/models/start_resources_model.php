<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Start_resources_model extends CI_Model {

  function __construct(){
    parent::__construct();
  }

  public function read(){
    $q = "SELECT sr.*, r.name FROM planet_starting_resource AS sr
            LEFT JOIN resource AS r ON sr.resource_id = r.id
            ORDER BY sr.resource_id ASC";
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->result_array();
    }
    return false;
  }

  public function read_single($id){
    $q = "SELECT sr.*, r.name FROM planet_starting_resource AS sr
            LEFT JOIN resource AS r ON sr.resource_id = r.id
            WHERE sr.resource_id=" . $this->db->escape($id) . " LIMIT 1";
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->row_array();
    }
    return false;
  }

  public function create($data){
    $q = $this->db->insert_string('planet_starting_resource', $data);
    return $this->db->query($q);
  }

  public function update($id, $data){
    $q = $this->db->update_string('planet_starting_resource', $data, "resource_id=".$this->db->escape($id));
    return $this->db->query($q);
  }

  public function delete($id){
    $q = "DELETE FROM planet_starting_resource WHERE resource_id=" . $this->db->escape($id);
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

  public function resources_avail(){
    $resources = $this->resources_list();
    $used = $this->read();

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

}

?>
