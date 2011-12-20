<?

$db->cacheQueries = false;

$data = array();

switch($request[3]){

  case 'add':
      if ($id = $IC->Planet->QueueTraining($_SESSION['ruler']['id'], $_POST['planet_id'], $_POST['training_id'])){
        $data['response'] = 'success';
        $data['id'] = $id;
      }else{
        $data['response'] = 'failure';
        $data['id'] = $db->err_str;
      }
    break;

  case 'remove':
      $IC->Planet->QueueTrainingRemove($_SESSION['ruler']['id'], $_POST['planet_id'], $request[4]);
      $db->SortRank('planet_training_queue', 'rank', 'id', "WHERE planet_id='" . $db->esc($_POST['planet_id']) . "' AND started IS NULL");
    break;

  case 'reorder':
      $IC->Planet->QueueTrainingReorder($_SESSION['ruler']['id'], $_POST['planet_id'], $_POST['hash']);
    break;

}


if ($queue = $IC->Planet->LoadTrainingQueue($_SESSION['ruler']['id'], $_POST['planet_id'])){
  $data['queue'] = $queue;
}
$data['available'] = $IC->Planet->LoadAvailableTraining($_SESSION['ruler']['id'], $_POST['planet_id']);
$data['resources'] = $IC->LoadResources();

echo json_encode($data);
die;

?>
