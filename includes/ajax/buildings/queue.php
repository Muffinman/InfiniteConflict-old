<?

$db->cacheQueries = false;

$data = array();

switch($request[3]){

  case 'add':
      if ($id = $IC->Planet->QueueBuilding($_SESSION['ruler']['id'], $_POST['planet_id'], $_POST['building_id'])){
        $data['response'] = 'success';
        $data['id'] = $id;
      }else{
        $data['response'] = 'failure';
        $data['id'] = $db->err_str;
      }
    break;

  case 'remove':
      $IC->Planet->QueueBuildingRemove($_SESSION['ruler']['id'], $_POST['planet_id'], $request[4]);
      $db->SortRank('planet_building_queue', 'rank', 'id', "WHERE planet_id='" . $db->esc($_POST['planet_id']) . "' AND started IS NULL");
    break;

  case 'reorder':
      $IC->Planet->QueueBuildingReorder($_SESSION['ruler']['id'], $_POST['planet_id'], $_POST['hash']);
    break;

}


$data['queue'] = $IC->Planet->LoadBuildingsQueue($_SESSION['ruler']['id'], $_POST['planet_id']);
$data['available'] = $IC->Planet->LoadAvailableBuildings($_SESSION['ruler']['id'], $_POST['planet_id']);

echo json_encode($data);
die;

?>
