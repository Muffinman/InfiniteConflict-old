<?

if ($_SESSION['ruler']){
  header('Location: /');
  exit;
}

$form = new Form();

if ($_POST && !$form->hasErrors){
  if ($ruler = $IC->Ruler->CheckLogin($_POST['email'], $_POST['password'])){
    $IC->Ruler->Login($ruler['id']);
    header('Location: /');
    exit;
  }
}

$smarty->assign('content', $smarty->fetch('login.tpl'));
$smarty->display('layout_login.tpl');
exit;
?>
