<?
class Planet extends IC {

  var $db;
  
  function __construct($db){
    $this->db = $db;
  }

  function LoadPlanetResources($id){
    $q = "SELECT * FROM planet_has_resource WHERE planet_id='" . $this->db->esc($id) . "'";
    return $this->db->Select($q);
  }
  
  function CalcPlanetResources($id){
    $resources = $this->LoadResources();
    $planet = $this->LoadPlanetResources($id);
    
    $out = array();
    foreach ($resources as $r){
      foreach ($planet as $res){
        if ($r['id'] == $res['resource_id']){
          $out[$r['name']] = array(
            'stored' => $res['stored'],
            'output' => $this->CalcOutput($id, $r['id']),
            'abundance' => $this->CalcAbundance($id, $r['id'])
          );
          
          if ($r['refund']){
            $out[$r['name']]['busy'] = $this->CalcBusy($id, $r['id']);
          }
          
        }
      }
    }
    return $out;
  }
  
  function CalcOutput($planet_id, $resource_id){
    $buildings = $this->LoadPlanetBuildings($planet_id);
    $resources = $this->LoadPlanetResources($planet_id);
    
    foreach ($resources as $r){
      if ($r['resource_id'] == $resource_id){
        $res = $r;
        break;
      }
    }
    
    $remove = 0;
    
    foreach($buildings as $b){
      $build = $this->LoadBuildingResources($b['building_id']);
      foreach ($build as $build_resource){
        if ($resource_id == $build_resource['resource_id']){
          if ($build_resource['output'] > 0){
            $res['output'] += $build_resource['output'];
          }
          
          if ($build_resource['output'] < 0){
            $remove += $build_resource['output'];
          }
        }
      }
    }
    
    $output = $res['output'] * $this->CalcAbundance($planet_id, $resource_id);
    return $output - $remove;
  }
  
  function CalcBusy($planet_id, $resource_id){
    $buildings = $this->LoadPlanetBuildings($planet_id);
    return false;
  }
  
  function CalcAbundance($planet_id, $resource_id){
    $buildings = $this->LoadPlanetBuildings($planet_id);
    $resources = $this->LoadPlanetResources($planet_id);
    
    foreach ($resources as $r){
      if ($r['resource_id'] == $resource_id){
        $res = $r;
        break;
      }
    }

    foreach($buildings as $b){
      $build = $this->LoadBuildingResources($b['building_id']);
      foreach ($build as $build_resource){
        if ($resource_id == $build_resource['resource_id']){
          if ($build_resource['abundance'] > 0){
            $res['abundance'] += $build_resource['abundance'];
          }
        }
      }
    }
    
    return $res['abundance'];  
  }
  
  function LoadPlanetBuildings($id){
    $q = "SELECT * FROM planet_has_building WHERE planet_id='" . $this->db->esc($id) . "'";
    return $this->db->Select($q);
  }
  
  function LoadBuildingResources($id){
    $q = "SELECT * FROM building_has_resource WHERE building_id='" . $this->db->esc($id) . "'";
    return $this->db->Select($q);    
  }
}
?>
