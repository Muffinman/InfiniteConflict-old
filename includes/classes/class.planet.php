<?

/*
 *  This class controls all planet related methods
 *
 */
class Planet extends IC {

  var $db;



  function __construct($db){
    $this->db = $db;
    $this->Research = new Research($db);
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



	function RulerOwnsPlanet($ruler_id, $planet_id){
		$planet = $this->LoadPlanet($planet_id);
		
		if($planet['ruler_id'] == $ruler_id){
			return true;
		}
		return false;
	}


  function CalcBuildingResources($planet_id){
    $resources = $this->LoadResources();
    $buildings = $this->LoadPlanetBuildings($planet_id);

    $out = array();

		if ($buildings){
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
	
	
	              if ($bld['resources'][$r['id']]['output'] > 0){
	                $bld['resources'][$r['id']]['total_output'] = $bld['resources'][$r['id']]['output'] * $b['qty'] * $abundance;
	              }
	
	              # Buildings with negative output dont take into account abundance
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
    }

    return $out;
  }



  function CalcPlanetResources($id){
    $resources = $this->LoadResources();
    $planet = $this->LoadPlanetResources($id);

    $out = array();
    foreach ($resources as $r){
      //if (!$r['global']){
        $out[$r['name']] = array(
          'id' => $r['id'],
          'interest' => $r['interest'],
          'req_storage' => $r['req_storage'],
          'stored' => 0,
          'stored_str' => 0,
          'global' => $r['global']
        );

        foreach ($planet as $res){
          if ($r['id'] == $res['resource_id']){
          	$out[$r['name']]['id'] 						= $r['id'];
            $out[$r['name']]['stored']        = $res['stored'];
            $out[$r['name']]['stored_str']    = number_format($out[$r['name']]['stored'], 0);
            $out[$r['name']]['output']        = $this->CalcOutput($id, $r['id']);
            $out[$r['name']]['output_str']    = ($out[$r['name']]['output'] < 0 ? '' : '+') . number_format($out[$r['name']]['output'], 0);
            $out[$r['name']]['net_output']    = $this->CalcOutput($id, $r['id'], false);
            $out[$r['name']]['net_output_str']= ($out[$r['name']]['net_output'] < 0 ? '' : '+') . number_format($out[$r['name']]['net_output'], 0);
            $out[$r['name']]['storage']       = $this->CalcStorage($id, $r['id']);
            $out[$r['name']]['storage_str']   = number_format($out[$r['name']]['storage'], 0);
            $out[$r['name']]['abundance']     = $this->CalcAbundance($id, $r['id']);
            $out[$r['name']]['abundance_str'] = $out[$r['name']]['abundance'] * 100;
            $out[$r['name']]['busy']          = $this->CalcBusy($id, $r['id']);
            $out[$r['name']]['busy_str']      = number_format($out[$r['name']]['busy'], 0);           
          }
        }
      //}
    }
    return $out;
  }



  function CalcOutput($planet_id, $resource_id, $gross=true){
    $buildings = $this->LoadPlanetBuildings($planet_id);
    $resources = $this->LoadPlanetResources($planet_id);
    $taxes = $this->LoadResourceTaxOutput($resource_id);

    if ($resources){
      foreach ($resources as $r){
        if ($r['resource_id'] == $resource_id){
          $res = $r;
          break;
        }
      }
    }

    $extra = 0;

    if ($buildings){
      foreach($buildings as $b){
        $build = $this->LoadBuildingResources($b['building_id']);
        foreach ($build as $build_resource){
          if ($resource_id == $build_resource['resource_id']){
            if ($build_resource['output'] > 0){
              $res['output'] += $build_resource['output'] * $b['qty'];
            }

						if ($gross){
	            if ($build_resource['output'] < 0){
	              $extra += $build_resource['output'] * $b['qty'];
	            }
            }
          }
        }
      }
    }

		
		if ($gross){
	    if ($taxes){
	      foreach ($taxes as $t){
	        $stored = $this->LoadPlanetResourcesStored($planet_id, $t['resource_id']);
	        $extra += $stored * $t['rate'];
	      }
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
    
    if ($buildings){
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
    }

    return $storage;
  }


  
  function CalcBusy($planet_id, $resource_id){
    $bldQueue = $this->LoadBuildingsQueue(NULL, $planet_id);
    $shipQueue = $this->LoadProductionQueue(NULL, $planet_id);
    $conversionQueue = $this->LoadConversionQueue(NULL, $planet_id);

    $busy = 0;

    if ($bldQueue){
      foreach ($bldQueue as $b){
        if ($b['started'] == 1){
          if ($res = $this->LoadBuildingResources($b['building_id'])){
	          foreach ($res as $r){
	            if ($r['resource_id'] == $resource_id && $r['refund'] == 1){
	              $busy += $r['cost'];
	            }
	          }
          }
        }
      }
    }

    if ($shipQueue){
      foreach ($shipQueue as $s){
        if ($s['started'] == 1){
          if ($res = $this->LoadShipResources($s['ship_id'])){
	          foreach ($res as $r){
	            if ($r['resource_id'] == $resource_id && $r['refund'] == 1){
	              $busy += $r['cost'];
	            }
	          }
          }
        }
      }
    }

    if ($conversionQueue){
      foreach ($conversionQueue as $c){
        if ($c['started'] == 1){
          if ($res = $this->LoadConversionCost($c['resource_id'])){
	          foreach ($res as $r){
	            if ($r['cost_resource'] == $resource_id && $r['refund'] == 1){
	              $busy += $r['qty'];
	            }
	          }
          }
        }
      }
    }

    return $busy;
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

    if ($buildings){
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
    $q = "SELECT * FROM building_has_resource WHERE building_id='" . $this->db->esc($id) . "' ORDER BY resource_id ASC";
    return $this->db->Select($q);
  }



  function LoadBuildingResource($id, $resource_id){
    $q = "SELECT * FROM building_has_resource
            WHERE building_id='" . $this->db->esc($id) . "'
            AND resource_id='" . $this->db->esc($resource_id) . "'";
    return $this->db->Select($q);
  }

  
  
  function LoadConversionResources($resource_id){
    $q = "SELECT * FROM conversion_cost WHERE resource_id='" . $this->db->esc($resource_id) . "'";
    return $this->db->Select($q);  
  }
  

  
  function LoadBuildingsQueue($ruler_id, $planet_id){
    $q = "SELECT planet_building_queue.*, building.name, MD5(CONCAT(planet_building_queue.id, '" . $ruler_id . "', '" . $planet_id . "')) AS hash FROM planet_building_queue
          LEFT JOIN building ON planet_building_queue.building_id = building.id
          WHERE planet_id='" . $this->db->esc($planet_id) . "'
          ORDER BY rank ASC";
    if ($r = $this->db->Select($q)){
      return $r;
    }
    return false;
  }

  
  function LoadProductionQueue($ruler_id, $planet_id){
    $q = "SELECT planet_ship_queue.*, ship.name, MD5(CONCAT(planet_ship_queue.id, '" . $ruler_id . "', '" . $planet_id . "')) AS hash FROM planet_ship_queue
          LEFT JOIN ship ON planet_ship_queue.ship_id = ship.id
          WHERE planet_id='" . $this->db->esc($planet_id) . "'
          ORDER BY rank ASC";
    if ($r = $this->db->Select($q)){
      return $r;
    }
    return false;
  }

  
  
  function LoadConversionQueue($ruler_id, $planet_id){
    $q = "SELECT planet_conversion_queue.*, resource.name, MD5(CONCAT(planet_conversion_queue.id, '" . $ruler_id . "', '" . $planet_id . "')) AS hash FROM planet_conversion_queue
          LEFT JOIN resource ON planet_conversion_queue.resource_id = resource.id
          WHERE planet_id='" . $this->db->esc($planet_id) . "'
          ORDER BY rank ASC";
    if ($r = $this->db->Select($q)){
      return $r;
    }
    return false;
  } 
  

  
  function LoadAvailableBuildings($ruler_id, $planet_id){
    $buildings = $this->LoadBuildings();
    $research = $this->Research->LoadRulerResearch($ruler_id);
    $current = $this->LoadPlanetBuildings($planet_id);
    $queue = $this->LoadBuildingsQueue($ruler_id, $planet_id);
       
    $canBuild = array();
    
    # First check for building prereq
    foreach($buildings as $b){
      $theCurrent = $b;
    
    
      # Load the current building from $b first in case it doesn't exist on planet
      $cur2 = array();
      if ($current){
		    foreach($current as $cur){
		      $cur2[$cur['building_id']] = $cur;
		    }
      }
      $theCurrent['qty'] = $cur2[$b['id']]['qty'];
      $theCurrent['building_id'] = $theCurrent['id'];
      
      $prereq = $this->LoadBuildingPrereq($b['id']);

      if ($prereq['building']){
        foreach($prereq['building'] as $id){
          $found = false;
          if ($current){
          	foreach($current as $cur){
            	if ($cur['building_id'] == $id){
             	 	$found = true;
            	}
          	}
          }
          if ($found === false){
            continue 2;
          }
        }
      }
      
      
      if ($prereq['research']){
        foreach($prereq['research'] as $id){
          $found = false;
          foreach($research as $r){
            if ($r['id'] == $id){
              $found = true;
            }
          }
          if ($found === false){
            continue 2;
          }
        }
      }     
      
      # If we have one in the queue, effectively add one to the quantity to stop people queueing too many
      if ($queue){
        foreach ($queue as $q){
          if ($q['building_id'] == $theCurrent['building_id']){
            $theCurrent['qty'] += 1;
          }
        }
      }
      
      if ($theCurrent['qty'] < $b['max'] || !$b['max']){
        $resources = $this->LoadBuildingResources($b['id']);
        foreach ($resources as $r){
          $r['output_str'] = ($r['output'] > 0 ? '+' : '') . number_format($r['output'], 0);
          $r['cost_str'] = number_format($r['cost'], 0);        
          $b['resources'][$r['resource_id']] = $r;
        }
        $canBuild[] = $b;
      }
    }
    
    return $canBuild;
  }
  
  
  
  function LoadBuildingPrereq($building_id){
    $prereq = array();
    
    $q = "SELECT * FROM building_prereq WHERE building_id='" . $this->db->esc($building_id) . "'";
    if ($r = $this->db->Select($q)){
      foreach ($r as $row){
        $prereq['building'][] = $row['prereq'];
      }
    }

    $q = "SELECT * FROM building_res_prereq WHERE building_id='" . $this->db->esc($building_id) . "'";
    if ($r = $this->db->Select($q)){
      foreach ($r as $row){
        $prereq['research'][] = $row['research_id'];
      }
    }
    
    if (empty($prereq)){
      return false;
    }
    
    return $prereq;
  }
  
  
  
  function QueueBuilding($ruler_id, $planet_id, $building_id, $demolish=false){
    $queue = false;

  	if ($q = $this->LoadBuildingsQueue($ruler_id, $planet_id)){
  		if (!$this->Ruler){
  			$this->Ruler = new Ruler($this->db);
  		}
  		$QL = $this->Ruler->LoadRulerQL($ruler_id);
  		if (sizeof($q) >= $QL){
  			return false;
  		}
  	}

    if ($building = $this->LoadBuilding($building_id)){
    	if ($demolish){
				if ($avail = $this->LoadPlanetBuildings($planet_id)){
	        foreach ($avail as $bld){
	          if ($bld['building_id'] == $building['id']){
	            $queue = true;
	            $details = $bld;
	            break;
	          }
	        } 
	      }				    	
    	}
    	
    	else{
	      if ($avail = $this->LoadAvailableBuildings($ruler_id, $planet_id)){
	        foreach ($avail as $bld){
	          if ($bld['id'] == $building['id']){
	            $queue = true;
	            $details = $bld;
	            break;
	          }
	        } 
	      }
      }
      
      if ($demolish === true && $building['demolish'] < 1){
      	$queue = false;
      }
    }
    
    if ($queue === true){
      
      $arr = array(
        'planet_id' => $planet_id,
        'building_id' => $building['id'],
        'turns' => $building['turns'],
        'rank' => $this->db->NextRank('planet_building_queue', 'rank', "WHERE planet_id='" . $this->db->esc($planet_id) . "'")
      );
      
      if ($demolish === true){
      	$arr['demolish'] = 1;
      	$arr['turns'] = $building['demolish'];
      }
      
      return $this->db->QuickInsert('planet_building_queue', $arr);
    }
    
    return false;
  }



  function QueueBuildingRemove($ruler_id, $planet_id, $hash){
    $q = "DELETE FROM planet_building_queue
            WHERE MD5(CONCAT(id, '" . $ruler_id . "', '" . $planet_id . "')) = '" . $this->db->esc($hash) . "' AND started IS NULL LIMIT 1";
    $this->db->Edit($q);
    
    $this->db->SortRank('planet_building_queue', 'rank', 'id', "WHERE planet_id='" . $this->db->esc($planet_id) . "'");
  }



  function QueueBuildingReorder($ruler_id, $planet_id, $hashes){
    $currentQueue = $this->LoadBuildingsQueue($ruler_id, $planet_id);
    $i=1;
    
    if ($currentQueue[0]['started']){
    	$i=2;
    }
    
    foreach ($hashes as $hash){
      foreach ($currentQueue as $queue){
        if ($hash == $queue['hash']){
          $queue['rank'] = $i;
          $q = "UPDATE planet_building_queue SET rank='" . $this->db->esc($queue['rank']) . "' WHERE id='" . $queue['id'] . "' LIMIT 1";
          $this->db->Edit($q);
          $i++;
          continue 2;
        }
      }

    }
  }




	function LoadAvailableConversions($ruler_id, $planet_id){
    $resources = $this->LoadResources();
    $buildings = $this->LoadPlanetBuildings($planet_id);
    $research = $this->Research->LoadRulerResearch($ruler_id);
    $queue = $this->LoadConversionQueue($ruler_id, $planet_id);
       
    $canBuild = array();
    
    # First check for building prereq
    foreach($resources as $res){
      $theCurrent = $r;
      
      $prereq = $this->LoadConversionPrereq($res['id']);

      if ($prereq['building']){
				$found = false;
        foreach($prereq['building'] as $id){
          foreach($buildings as $r){
            if ($r['building_id'] == $id){
              $found = true;
            }
          }
          if ($found === false){
            continue 2;
          }
        }
      }
      
      
      if ($prereq['research']){
				$found = false;
        foreach($prereq['research'] as $id){
          $found = false;
          foreach($research as $r){
            if ($r['id'] == $id){
              $found = true;
            }
          }
          if ($found === false){
            continue 2;
          }
        }
      }     
      
      

      if ($resources = $this->LoadConversionResources($res['id'])){
	      foreach ($resources as $r){
	        $r['cost_str'] = number_format($r['cost'], 0);        
	        $res['resources'][$r['cost_resource']] = $r;
	      }
	      $canBuild[] = $res;
      }
      
    }
    
    return $canBuild;
  }



	function LoadConversionPrereq($resource_id){
    $prereq = array();
    
    $q = "SELECT * FROM conversion_bld_prereq WHERE resource_id='" . $this->db->esc($resource_id) . "'";
    if ($r = $this->db->Select($q)){
      foreach ($r as $row){
        $prereq['building'][] = $row['building_id'];
      }
    }

    $q = "SELECT * FROM conversion_res_prereq WHERE resource_id='" . $this->db->esc($resource_id) . "'";
    if ($r = $this->db->Select($q)){
      foreach ($r as $row){
        $prereq['research'][] = $row['research_id'];
      }
    }
    
    if (empty($prereq)){
      return false;
    }
    
    return $prereq;
  }


	function QueueConversion($ruler_id, $planet_id, $resource_id, $qty){

		if ((int)$qty < 1){
			return false;
		}
	

  	if ($q = $this->LoadConversionQueue($ruler_id, $planet_id)){
  		if (!$this->Ruler){
  			$this->Ruler = new Ruler($this->db);
  		}
  		$QL = $this->Ruler->LoadRulerQL($ruler_id);
  		if (sizeof($q) >= $QL){
  			return false;
  		}
  	}

		$queue = false;

    if ($avail = $this->LoadAvailableConversions($ruler_id, $planet_id)){
      foreach ($avail as $res){
        if ($res['id'] == $resource_id){
          $queue = true;
          break;
        }
      } 
    }

    
    if ($queue === true){
      
      $arr = array(
        'planet_id' => $planet_id,
        'resource_id' => $res['id'],
        'qty' => $qty,
        'turns' => $res['turns'],
        'rank' => $this->db->NextRank('planet_conversion_queue', 'rank', "WHERE planet_id='" . $this->db->esc($planet_id) . "'")
      );
            
      return $this->db->QuickInsert('planet_conversion_queue', $arr);
		}

		return true;
	}


  function QueueConversionRemove($ruler_id, $planet_id, $hash){
    $q = "DELETE FROM planet_conversion_queue
            WHERE MD5(CONCAT(id, '" . $ruler_id . "', '" . $planet_id . "')) = '" . $this->db->esc($hash) . "' AND started IS NULL LIMIT 1";
    $this->db->Edit($q);
    
    $this->db->SortRank('planet_conversion_queue', 'rank', 'id', "WHERE planet_id='" . $this->db->esc($planet_id) . "'");
  }



  function QueueConversionReorder($ruler_id, $planet_id, $hashes){
    $currentQueue = $this->LoadConversionQueue($ruler_id, $planet_id);
    $i=1;
    
    if ($currentQueue[0]['started']){
    	$i=2;
    }
    
    foreach ($hashes as $hash){
      foreach ($currentQueue as $queue){
        if ($hash == $queue['hash']){
          $queue['rank'] = $i;
          $q = "UPDATE planet_conversion_queue SET rank='" . $this->db->esc($queue['rank']) . "' WHERE id='" . $queue['id'] . "' LIMIT 1";
          $this->db->Edit($q);
          $i++;
          continue 2;
        }
      }

    }
  }


  function VaryResource($planet_id, $resource_id, $qty){
    $q = "UPDATE planet_has_resource SET stored = stored + '" . $this->db->esc($qty) . "'
            WHERE planet_id = '" . $this->db->esc($planet_id) . "'
            AND resource_id = '" . $this->db->esc($resource_id) . "'";
    return $this->db->Edit($q);
  }

  
  function SetResource($planet_id, $resource_id, $qty){
    $q = "UPDATE planet_has_resource SET stored = '" . $this->db->esc($qty) . "'
            WHERE planet_id = '" . $this->db->esc($planet_id) . "'
            AND resource_id = '" . $this->db->esc($resource_id) . "'";
    return $this->db->Edit($q);
  }
  
  
  

  
  

  
  
  
  
}
?>
