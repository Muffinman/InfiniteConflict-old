<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Resources_model extends CI_Model {

  function __construct(){
    parent::__construct();
  }

  public function read(){
    $q = "SELECT * FROM resource ORDER BY id ASC";
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->result_array();
    }
    return false;
  }

  public function read_single($id){
    $q = "SELECT * FROM resource WHERE id=" . $this->db->escape($id) . " LIMIT 1";
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->row_array();
    }
    return false;
  }

  public function create($data){

  }

  public function update($id, $data){
    $q = $this->db->update_string('resource', $data, "id=".$this->db->escape($id));
    return $this->db->query($q);
  }

  public function delete($id){

  }

  public function conversion_list($id){
    $q = "SELECT c.*, resource.name FROM conversion_cost AS c
            LEFT JOIN resource ON c.cost_resource = resource.id
            WHERE resource_id=" . $this->db->escape($id);
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->result_array();
    }
    return false;            
  }

  public function conversion_single($conversion_id){
    $q = "SELECT c.*, resource.name FROM conversion_cost AS c
            LEFT JOIN resource ON c.cost_resource = resource.id
            WHERE c.id=" . $this->db->escape($conversion_id);
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->row_array();
    }
    return false;            
  }

  public function conversion_avail($id){
    $resources = $this->read();
    $used = $this->conversion_list($id);
    
    $avail = array();
    foreach ($resources as $r){
      if (!empty($used)){
        foreach ($used as $r2){
          if ($r2['cost_resource'] == $r['id']){
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

  public function conversion_create($id, $data){
    $data['resource_id'] = $id;
    $q = $this->db->insert_string('conversion_cost', $data);
    return $this->db->query($q);
  }
  
  public function conversion_update($id, $conversion_id, $data){
    $q = $this->db->update_string('conversion_cost', $data, "id=".$this->db->escape($conversion_id));
    return $this->db->query($q);  
  }
  
  public function conversion_delete($id, $conversion_id){
    $q = "DELETE FROM conversion_cost WHERE id=" . $this->db->escape($conversion_id);
    return $this->db->query($q);
  }

}

?>
