<?

class Ruler extends IC {

  var $db;

  function __construct($db){
    $this->db = $db;
    $this->Planet = new Planet($db);
  }

  function LoadRuler($id){
    $ruler = $this->db->QuickSelect('ruler', $id);
    return $ruler;
  }

  function LoadRulerPlanets($id){
    $q = "SELECT * FROM planet WHERE ruler_id='" . $this->db->esc($id) . "'
            ORDER BY id ASC";
    if ($r = $this->db->Select($q)){
      $planets = array();
      foreach ($r as $row){
        $planets[] = $this->LoadPlanet($row['id']);
      }
      return $planets;
    }
    return false;
  }

  function CheckConfirmCode($code){
    $q = "SELECT * FROM ruler WHERE hash='" . $this->db->esc($code) . "' LIMIT 1";
    if ($r = $this->db->Select($q)){
      return $r[0];
    }
    return false;
  }

  function CheckEmail($email){
    $q = "SELECT * FROM ruler WHERE email='" . $this->db->esc($email) . "' LIMIT 1";
    if ($r = $this->db->Select($q)){
      return false;
    }
    return true;
  }

  function CheckRulerName($name){
    $q = "SELECT * FROM ruler WHERE name='" . $this->db->esc($name) . "' LIMIT 1";
    if ($r = $this->db->Select($q)){
      return false;
    }
    return true;
  }

  function CreateRuler($arr){
    $arr['hash'] = md5(rand(1,42323) . $arr['email'] . time());
    $id = $this->db->QuickInsert('ruler', $arr);
    $this->SendRegEmail($id);
    return $id;
  }

  function SignupRuler($arr){
    if ($ruler = $this->CheckConfirmCode($arr['hash'])){
      $ruler['name'] = $arr['rulername'];
      $ruler['confirmed'] = 1;
      $ruler['hash'] = NULL;
      $this->db->QuickEdit('ruler', $ruler);

      $planet = $this->LoadNextHomeplanet();
      $planet['name'] = $arr['planetname'];
      $planet['ruler_id'] = $ruler['id'];

      $this->db->QuickEdit('planet', $planet);

      $this->SetHomePlanetBuildings($planet['id']);

      return $ruler;
    }
    return false;
  }

  function SetHomePlanetBuildings($id){
    $planet = $this->LoadPlanet($id);
    $buildings = $this->LoadStartingBuildings();
    $out = array();
    foreach ($buildings as $b){
      $b['planet_id'] = $id;
      $out[] = $b;
    }
    $this->db->MultiInsert('planet_has_building', $out);
  }

  function LoadStartingResources(){
    $q = "SELECT * FROM planet_starting_resource";
    return $this->db->Select($q);
  }

  function LoadStartingBuildings(){
    $q = "SELECT * FROM planet_starting_building";
    return $this->db->Select($q);
  }



  function CheckLogin($email, $password){
    $q = "SELECT * FROM ruler
            WHERE email='" . $this->db->esc($email) . "'
            AND `password`='" . $this->db->esc($this->CreatePassword($email, $password)) . "' LIMIT 1";
    if ($r = $this->db->Select($q)){
      return $r[0];
    }
    return false;
  }


  function Login($ruler){
    setcookie(COOKIE_NAME, session_id(), (time()+COOKIE_LIFETIME), '/');
    $arr = array(
      'ruler_id'  => $ruler,
      'session_id' => session_id(),
      'session_ip' => $_SERVER['REMOTE_ADDR']
    );

    $this->db->QuickInsert('session', $arr);
    return true;
  }

  function SendRegEmail($id){
    $ruler = $this->LoadRuler($id);
    $this->smarty->assign('ruler', $ruler);
    $subject = 'Your registration on InfiniteConflict.com';
    return $this->SendEmail($ruler['email'], $subject, 'register.tpl');
  }

  function CreatePassword($email, $pass){
    return md5(md5($email) . md5($pass));
  }

}
?>
