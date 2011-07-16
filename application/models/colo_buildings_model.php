<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Colo_buildings_model extends CI_Model {

  function __construct(){
    parent::__construct();
  }

  public function read(){
    $q = "SELECT sb.*, b.name FROM planet_colo_building AS sb
            LEFT JOIN building AS b ON sb.building_id = b.id";
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->result_array();
    }
    return false;
  }

  public function read_single($id){
    $q = "SELECT sb.*, b.name FROM planet_colo_building AS sb
            LEFT JOIN building AS b ON sb.building_id = b.id
            WHERE sb.building_id=" . $this->db->escape($id) . " LIMIT 1";
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->row_array();
    }
    return false;
  }

  public function create($data){
    $q = $this->db->insert_string('planet_colo_building', $data);
    return $this->db->query($q);
  }

  public function update($id, $data){
    $q = $this->db->update_string('planet_colo_building', $data, "building_id=".$this->db->escape($id));
    return $this->db->query($q);
  }

  public function delete($id){
    $q = "DELETE FROM planet_colo_building WHERE building_id=" . $this->db->escape($id);
    return $this->db->query($q);
  }

  public function buildings_list(){
    $q = "SELECT * FROM building ORDER BY id ASC";
    $query = $this->db->query($q);
    if ($query->num_rows() > 0){
      return $query->result_array();
    }
    return false;
  }

  public function buildings_avail(){
    $resources = $this->buildings_list();
    $used = $this->read();

    $avail = array();
    foreach ($resources as $r){
      if (!empty($used)){
        foreach ($used as $r2){
          if ($r2['building_id'] == $r['id']){
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
