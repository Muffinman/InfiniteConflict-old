<?

$galaxies = $IC->LoadGalaxies($_SESSION['ruler']['id'], $_SESSION['ruler']['alliance_id']);
$smarty->assign('galaxies', $galaxies);

if (!$request[1]){
  $smarty->assign('content', $smarty->fetch('nav_universe.tpl'));
}

if ($request[1]){
  if ($galaxy = $IC->LoadGalaxy($request[1])){
    if (!$request[2]){
      $systems = $IC->LoadSystems($galaxy['id'], $_SESSION['ruler']['id'], $_SESSION['ruler']['alliance_id']);
      $smarty->assign('systems', $systems);
    }

    $smarty->assign('galaxy', $galaxy);
    $smarty->assign('content', $smarty->fetch('nav_galaxy.tpl'));
  }else{
    $error = true;
  }
}

if ($request[2]){
  if ($system = $IC->LoadSystem($request[2])){
    $planets = $IC->LoadPlanets($galaxy['id'], $system['id'], $_SESSION['ruler']['id'], $_SESSION['ruler']['alliance_id']);
    $system['previous'] = $IC->LoadPreviousSystem($galaxy['id'], $system['id']);
    $system['next'] = $IC->LoadNextSystem($galaxy['id'], $system['id']);

    $smarty->assign('system', $system);
    $smarty->assign('planets', $planets);
    $smarty->assign('content', $smarty->fetch('nav_system.tpl'));
  }else{
    $error = true;
  }
}

if ($error){
  error_page(404);
}

?>
