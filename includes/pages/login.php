<?

if ($_SESSION['ruler']){
  header('Location: /');
  exit;
}

$form = new Form();

if ($_POST && !$form->hasErrors){
  if ($ruler = $Ruler->CheckLogin($_POST['email'], $_POST['password'])){    
    if ($planets = $Ruler->LoadRulerPlanets($ruler['id'])){
	    $Ruler->Login($ruler['id']);
	    header('Location: /');
	    die($planets);
    }else{
      $ruler['hash'] = md5(rand(0, 19289182) * rand(0, 98239283));
      $ruler['confirmed'] = 0;
      $db->QuickEdit('ruler', $ruler);
      header('Location: /confirm/' . $ruler['hash']);
      die($db->errStr);
    }
  }
}

$smarty->assign('content', $smarty->fetch('login.tpl'));
$smarty->display('layout_login.tpl');
exit;
?>
