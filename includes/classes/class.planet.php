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

  function LoadBuildings(){
    $q = "SELECT * FROM building";
    return $this->db->Select($q);
  }

  function LoadBuilding($id){
    return $this->db->QuickSelect('building', $id);
  }

  function CalcBuildingResources($planet_id){
    $resources = $this->LoadResources();
    $buildings = $this->LoadPlanetBuildings($planet_id);

    $out = array();
    foreach ($buildings as $b){

      $bld = $this->LoadBuilding($b['building_id']);
      $bld['qty'] = $b['qty'];

      $buildingRes = $this->LoadBuildingResources($b['building_id']);

      foreach ($resources as $r){
        $abundance = $this->CalcAbundance($planet_id, $r['id']);

        foreach ($buildingRes as $res){
          if (!$r['global']){
            if ($r['id'] == $res['resource_id']){
              $bld['resources'][$r['id']] = $res;
              $bld['resources'][$r['id']]['name'] = $r['name'];

              # Buildings with negative output dont take into account abundance
              if ($bld['resources'][$r['id']]['output'] > 0){
                $bld['resources'][$r['id']]['total_output'] = $bld['resources'][$r['id']]['output'] * $b['qty'] * $abundance;
              }

              if ($bld['resources'][$r['id']]['output'] < 0){
                $bld['resources'][$r['id']]['total_output'] = $bld['resources'][$r['id']]['output'] * $b['qty'];
              }

              $bld['resources'][$r['id']]['total_stores'] = $bld['resources'][$r['id']]['stores'] * $b['qty'];
              $bld['resources'][$r['id']]['total_cost'] = $bld['resources'][$r['id']]['cost'] * $b['qty'];

              $bld['resources'][$r['id']]['total_output_str'] = ($bld['resources'][$r['id']]['total_output'] > 0 ? '+' : '') . number_format($bld['resources'][$r['id']]['total_output'], 0);
              $bld['resources'][$r['id']]['total_stores_str'] = ($bld['resources'][$r['id']]['total_stores'] > 0 ? '+' : '') . number_format($bld['resources'][$r['id']]['total_stores'], 0);
            }
          }
        }
      }
      $out[] = $bld;
    }

    return $out;
  }



  function CalcPlanetResources($id){
    $resources = $this->LoadResources();
    $planet = $this->LoadPlanetResources($id);

    $out = array();
    foreach ($resources as $r){
      if (!$r['global']){
        $out[$r['name']] = array(
          'id' => $r['id'],
          'interest' => $r['interest'],
          'req_storage' => $r['req_storage'],
          'stored' => 0,
          'stored_str' => 0
        );

        foreach ($planet as $res){
          if ($r['id'] == $res['resource_id']){
            $out[$r['name']]['stored']        = $res['stored'];
            $out[$r['name']]['stored_str']    = number_format($out[$r['name']]['stored'], 0);
            $out[$r['name']]['output']        = $this->CalcOutput($id, $r['id']);
            $out[$r['name']]['output_str']    = ($out[$r['name']]['output'] > 0 ? '+' : '') . number_format($out[$r['name']]['output'], 0);
            $out[$r['name']]['storage']       = $this->CalcStorage($id, $r['id']);
            $out[$r['name']]['storage_str']   = number_format($out[$r['name']]['storage'], 0);
            $out[$r['name']]['abundance']     = $this->CalcAbundance($id, $r['id']);
            $out[$r['name']]['abundance_str'] = $out[$r['name']]['abundance'] * 100;
            $out[$r['name']]['busy']          = $this->CalcBusy($id, $r['id']);
            $out[$r['name']]['busy_str']      = number_format($out[$r['name']]['busy'], 0);
          }
        }
      }
    }
    return $out;
  }

  function CalcOutput($planet_id, $resource_id){
    $buildings = $this->LoadPlanetBuildings($planet_id);
    $resources = $this->LoadPlanetResources($planet_id);
    $taxes = $this->LoadResourceTaxOutput($resource_id);

    foreach ($resources as $r){
      if ($r['resource_id'] == $resource_id){
        $res = $r;
        break;
      }
    }

    $extra = 0;

    foreach($buildings as $b){
      $build = $this->LoadBuildingResources($b['building_id']);
      foreach ($build as $build_resource){
        if ($resource_id == $build_resource['resource_id']){
          if ($build_resource['output'] > 0){
            $res['output'] += $build_resource['output'] * $b['qty'];
          }

          if ($build_resource['output'] < 0){
            $extra += $build_resource['output'] * $b['qty'];
          }
        }
      }
    }


    if ($taxes){
      foreach ($taxes as $t){
        $stored = $this->LoadPlanetResourcesStored($planet_id, $t['resource_id']);
        $extra += $stored * $t['rate'];
      }
    }

    $output = $res['output'] * $this->CalcAbundance($planet_id, $resource_id);
    return $output + $extra;
  }


  function CalcStorage($planet_id, $resource_id){
    $buildings = $this->LoadPlanetBuildings($planet_id);
    $resources = $this->LoadPlanetResources($planet_id);

    foreach ($resources as $r){
      if ($r['resource_id'] == $resource_id){
        $res = $r;
        break;
      }
    }

    $storage=0;

    foreach($buildings as $b){
      $build = $this->LoadBuildingResources($b['building_id']);
      foreach ($build as $build_resource){
        if ($resource_id == $build_resource['resource_id']){
          if ($build_resource['stores'] > 0){
            $storage += $build_resource['stores'];
          }
        }
      }
    }

    return $storage;
  }


  function CalcBusy($planet_id, $resource_id){
    $buildings = $this->LoadPlanetBuildings($planet_id);
    return 0;
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

  function LoadPlanetResourcesStored($planet_id, $resource_id){
    $res = $this->LoadPlanetResources($planet_id);
    foreach ($res as $r){
      if ($r['resource_id'] == $resource_id){
        return $r['stored'];
      }
    }
    return false;
  }

  function LoadResourceTax($resource_id){
    $q = "SELECT * FROM resource_tax WHERE resource_id='" . $this->db->esc($resource_id) . "'";
    return $this->db->Select($q);
  }

  function LoadResourceTaxOutput($resource_id){
    $q = "SELECT * FROM resource_tax WHERE output_resource='" . $this->db->esc($resource_id) . "'";
    return $this->db->Select($q);
  }

  function LoadPlanetBuildings($id){
    $q = "SELECT * FROM planet_has_building WHERE planet_id='" . $this->db->esc($id) . "' ORDER BY id ASC";
    return $this->db->Select($q);
  }

  function LoadBuildingResources($id){
    $q = "SELECT * FROM building_has_resource WHERE building_id='" . $this->db->esc($id) . "'";
    return $this->db->Select($q);
  }

  function LoadBuildingResource($id, $resource_id){
    $q = "SELECT * FROM building_has_resource
            WHERE building_id='" . $this->db->esc($id) . "'
            AND resource_id='" . $this->db->esc($resource_id) . "'";
    return $this->db->Select($q);
  }
}
?>
