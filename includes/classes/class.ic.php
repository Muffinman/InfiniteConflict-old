<?

class IC {

  var $db;
  var $smarty;
	var $config;

  public function __construct(&$db){
    $this->db = &$db;
    $this->Research = new Research($db);
    $this->Planet = new Planet($db);
    $this->Ruler = new Ruler($db);
    
    $this->config = $this->LoadConfig();
  }

  public function LoadSession($id){
    $q = "SELECT * FROM session WHERE session_id='" . $this->db->esc($id) . "' LIMIT 1";
    if ($r = $this->db->Select($q)){
      return $r[0];
    }
    return false;
  }

	public function LoadConfig(){
		# Meta data
	  $q = "SELECT * FROM config";
	  if ($r = $this->db->Select($q)){
	    $config = array();
	    foreach ($r as $row){
	      $config[$row['key']] = $row['val'];
	    }
	  }	
	  return $config;
	}

  public function LoadResources(){
    $q = "SELECT * FROM resource";
    if ($r = $this->db->Select($q)){
      return $r;
    }
    return false;
  }

  public function LoadResource($id){
    return $this->db->QuickSelect('resource', $id);
  }
  
  public function ResourceIsGlobal($id){
  	$res = $this->LoadResource($id);
  	return $res['global'];
  }
  
  public function LoadResourceTaxes($resource_id){
  	$q = "SELECT * FROM resource_tax WHERE resource_id='" . $this->db->esc($resource_id) . "'";
  	return $this->db->Select($q);
  }

  public function LoadBuilding($id){
    return $this->db->QuickSelect('building', $id);
  }

  public function LoadRuler($id){
    return $this->db->QuickSelect('ruler', $id);
  }

  public function LoadPlanet($id){
    return $this->db->QuickSelect('planet', $id);
  }

  public function LoadGalaxy($id){
    return $this->db->QuickSelect('galaxy', $id);
  }

  public function LoadSystem($id){
    return $this->db->QuickSelect('system', $id);
  }

  public function LoadGalaxies($ruler_id, $alliance_id=false){
    $q = "SELECT * FROM galaxy";
    if ($r = $this->db->Select($q)){
      $gals = array();
      foreach ($r as $row){
        $row['status'] = 'neutral';
        
        $q = "SELECT * FROM planet
                WHERE galaxy_id = '" . $this->db->esc($row['id']) . "'
                AND ruler_id IS NOT NULL
                AND ruler_id <> '" . $this->db->esc($ruler_id) . "'"
                . ($alliance_id ? " AND alliance_id <>'" . $this->db->esc($alliance_id) . "'" : "");
        if ($this->db->Select($q)){
          $row['status'] = 'enemy'; 
        }
        
        if ($alliance_id){
          $q = "SELECT * FROM planet
                  WHERE galaxy_id = '" . $this->db->esc($row['id']) . "'
                  AND ruler_id IS NOT NULL
                  AND ruler_id <> '" . $this->db->esc($ruler_id) . "'
                  AND alliance_id = '" . $this->db->esc($alliance_id) . "'";
          if ($this->db->Select($q)){
            $row['status'] = 'allied'; 
          } 
        }
        
        $q = "SELECT * FROM planet
                WHERE galaxy_id = '" . $this->db->esc($row['id']) . "'
                AND ruler_id = '" . $this->db->esc($ruler_id) . "'";
        if ($this->db->Select($q)){
          $row['status'] = 'owned'; 
        }         
        
        $gals[] = $row;       
      }
      return $gals;
    }
    return false;
  }


  public function LoadSystems($gal_id, $ruler_id, $alliance_id=false){
  
    $galaxy = $this->LoadGalaxy($gal_id);
    if ($galaxy['home']){
      $maxCols = $this->config['home_gal_cols'];
    }else{
      $maxCols = $this->config['free_gal_cols'];
    }
  
    $q = "SELECT * FROM system WHERE galaxy_id='" . $this->db->esc($gal_id) . "'";
    if ($r = $this->db->Select($q)){
      $col=1;
      $systems = array();
      foreach ($r as $row){
        $row['status'] = 'neutral';
        
        $q = "SELECT * FROM planet
                WHERE system_id = '" . $this->db->esc($row['id']) . "'
                AND ruler_id IS NOT NULL
                AND ruler_id <> '" . $this->db->esc($ruler_id) . "'"
                . ($alliance_id ? " AND alliance_id <>'" . $this->db->esc($alliance_id) . "'" : "");
        if ($this->db->Select($q)){
          $row['status'] = 'enemy'; 
        }
        
        if ($alliance_id){
          $q = "SELECT * FROM planet
                  WHERE system_id = '" . $this->db->esc($row['id']) . "'
                  AND ruler_id IS NOT NULL
                  AND ruler_id <> '" . $this->db->esc($ruler_id) . "'
                  AND alliance_id = '" . $this->db->esc($alliance_id) . "'";
          if ($this->db->Select($q)){
            $row['status'] = 'allied'; 
          } 
        }
        
        $q = "SELECT * FROM planet
                WHERE system_id = '" . $this->db->esc($row['id']) . "'
                AND ruler_id = '" . $this->db->esc($ruler_id) . "'";
        if ($this->db->Select($q)){
          $row['status'] = 'owned'; 
        }         
        
        $row['col'] = $col;
        $col = ($col == $maxCols ? 1 : $col+1);
        
        $systems[] = $row;       
      }
      return $systems;
    }
    return false;
  }



  public function LoadPlanets($gal_id, $sys_id, $ruler_id, $alliance_id=false){
    global $config;

    $galaxy = $this->LoadGalaxy($gal_id);
    $system = $this->LoadSystem($sys_id);
    if ($galaxy['home']){
      $maxCols = $config['home_sys_cols'];
    }else{
      $maxCols = $config['free_sys_cols'];
    }
  
    $q = "SELECT p.*, r.name AS ruler FROM planet AS p
            LEFT JOIN ruler AS r ON p.ruler_id = r.id
            WHERE p.system_id='" . $this->db->esc($sys_id) . "'";
    if ($r = $this->db->Select($q)){
      $col=1;
      $planets = array();
      foreach ($r as $row){
        $row['status'] = 'neutral';

        if ($row['ruler_id'] && $row['ruler_id']!= $ruler_id){
          $row['status'] = 'enemy';
        }

        if ($row['alliance_id'] && $row['alliance_id'] == $alliance_id){
          $row['status'] = 'allied';
        }

        if ($row['ruler_id'] == $ruler_id){
          $row['status'] = 'owned';
        }

        $row['col'] = $col;
        $col = ($col == $maxCols ? 1 : $col+1);
        
        $planets[] = $row;       
      }
      return $planets;
    }
    return false;
  }


  public function SendEmail($to, $subject, $template){

    $email_body = $this->smarty->fetch('email/' . $template);
    $this->smarty->assign('email_body', $email_body);
    $body = $this->smarty->fetch('email/layout.tpl');

    $mail = new PHPMailerLite();
    $mail->IsHTML(true);

    $mail->Body = $body;

    $mail->Subject = $subject;
    $mail->From = 'noreply@infiniteconflict.com';
    $mail->FromName = 'Infinite Conflict';

    if (is_array($to)){
      foreach ($to as $address){
        $mail->AddAddress($address);
      }
    }else{
      $mail->AddAddress($to);
    }
    $mail->AddBCC('admin@infiniteconflict.com', 'IC Admin');

    if ($mail->Send()){
      return true;
    }
    return false;
  }

  function LoadNextHomeplanet(){
    $q = "SELECT * FROM planet WHERE ruler_id IS NULL AND home=1 ORDER BY id ASC LIMIT 1";
    if ($r = $this->db->Select($q)){
      return $r[0];
    }
  }

}

?>
