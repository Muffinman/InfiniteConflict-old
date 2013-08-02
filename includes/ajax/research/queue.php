<?

$db->cacheQueries = false;

$data = array();

switch($request[3]){

  case 'add':
      if ($id = $Research->QueueResearch($_SESSION['ruler']['id'], $_POST['research'])){
        $data['response'] = 'success';
        $data['id'] = $id;
      }else{
        $data['response'] = 'failure';
        $data['id'] = $db->err_str;
      }
    break;


  case 'remove':
      $Research->QueueResearchRemove($_SESSION['ruler']['id'], $request[4]);
      $db->SortRank('ruler_research_queue', 'rank', 'id', "WHERE ruler_id='" . $db->esc($_SESSION['ruler']['id']) . "' AND started IS NULL");
    break;

  /*
  case 'reorder':
      $IC->Research->QueueResearchReorder($_SESSION['ruler']['id'], $_POST['hash']);
    break;
  */
}


if ($queue = $Research->LoadResearchQueue($_SESSION['ruler']['id'])){
  $data['queue'] = $queue;
}
$data['available'] = $Research->LoadAvailableResearch($_SESSION['ruler']['id']);
$data['resources'] = $IC->LoadResources();

echo json_encode($data);
die;

?>
