<?
set_time_limit(0);

$q = "TRUNCATE TABLE ruler";
$db->Query($q);

$q = "TRUNCATE TABLE session";
$db->Query($q);

$q = "TRUNCATE TABLE galaxy";
$db->Query($q);

$q = "TRUNCATE TABLE system";
$db->Query($q);

$q = "TRUNCATE TABLE planet";
$db->Query($q);

$q = "TRUNCATE TABLE planet_has_resource";
$db->Query($q);

for ($i=1; $i<=$config['gals']; $i++){
  $gal = array();
  $gal['home'] = $i % 2 ? 1 : 0;

  if ($gal['home'] == 1){
    $gal['rows'] = $config['home_gal_rows'];
    $gal['cols'] = $config['home_gal_cols'];
  }else{
    $gal['rows'] = $config['free_gal_rows'];
    $gal['cols'] = $config['free_gal_cols'];
  }
  do{
    $gal['type'] = rand(1, $config['gal_types']);
  } while ($gal['type'] == $prev);
  $prev = $gal['type'];

  if ($gal['id'] = $db->QuickInsert('galaxy', $gal)){

    $planets = array();

    for ($j=1; $j<=$gal['rows']; $j++){
      for ($k=1; $k<=$gal['cols']; $k++){
        $sys = array();
        $sys['galaxy_id'] = $gal['id'];
        if ($gal['home'] == 1){
          $sys['rows'] = $config['home_sys_rows'];
          $sys['cols'] = $config['home_sys_cols'];
        }else{
          $sys['rows'] = $config['free_sys_rows'];
          $sys['cols'] = $config['free_sys_cols'];
        }

        do{
          $sys['type'] = rand(1, $config['sys_types']);
        } while ($sys['type'] == $prev2);
        $prev2 = $sys['type'];

        # Insert system
        if ($sys['id'] = $db->QuickInsert('system', $sys)){

          for ($l=1; $l<=$sys['rows']; $l++){
            for ($m=1; $m<=$sys['cols']; $m++){
              $planet = array();

              $planet['galaxy_id'] = $gal['id'];
              $planet['system_id'] = $sys['id'];
              if ($l <= $config['home_sys_hp_rows'] && $gal['home'] == 1){
                $planet['home'] = 1;
              }else{
                $planet['home'] = 0;
              }

              $planet['type'] = rand(1, $config['planet_types']);

              $planets[] = $planet;

            }
          }
        }
      }
    }

    $db->ExtendedInsert('planet', $planets);

  }
}


/* Set resources for home planets */
$q = "SELECT * FROM planet_starting_resource";
$starting = $db->Select($q);

$q = "SELECT * FROM planet WHERE home=1";
if ($r = $db->Select($q)){
  $resources = array();
  foreach($r as $row){
    foreach ($starting as $res){
      $resources[] = array(
        'planet_id' => $row['id'],
        'resource_id' => $res['resource_id'],
        'stored' => $res['stored'],
        'abundance' => $res['abundance']
      );
    }
  }
  $db->ExtendedInsert('planet_has_resource', $resources);
}
/* END Set resources for home planets */



$q = "SELECT * FROM galaxy_starting_resource";
$starting = $db->Select($q);

/* Set resources for home gal planets */
$q = "SELECT p.* FROM planet AS p
        LEFT JOIN galaxy AS g ON p.galaxy_id = g.id
        WHERE p.home=0 AND g.home=1";
if ($r = $db->Select($q)){
  $resources = array();
  foreach($r as $row){
    foreach ($starting as $res){
      $resources[] = array(
        'planet_id' => $row['id'],
        'resource_id' => $res['resource_id'],
        'stored' => rand($res['home_min_stored'], $res['home_max_stored']),
        'abundance' => random_float($res['home_min_abundance'], $res['home_max_abundance'])
      );
    }
  }
  $db->ExtendedInsert('planet_has_resource', $resources);
}
/* END Set resources for home gal planets */




/* Set resources for free gal planets */
$q = "SELECT p.* FROM planet AS p
        LEFT JOIN galaxy AS g ON p.galaxy_id = g.id
        WHERE p.home=0 AND g.home=0";
if ($r = $db->Select($q)){
  $resources = array();
  foreach($r as $row){
    foreach ($starting as $res){
      $resources[] = array(
        'planet_id' => $row['id'],
        'resource_id' => $res['resource_id'],
        'stored' => rand($res['free_min_stored'], $res['free_max_stored']),
        'abundance' => random_float($res['free_min_abundance'], $res['free_max_abundance'])
      );
    }
  }
  $db->ExtendedInsert('planet_has_resource', $resources);
}
/* END Set resources for free gal planets */








#$this->smarty->assign('content', $this->parser->parse('galaxies/index.tpl', array(), true));
#$this->parser->parse('layout.tpl', array());

?>