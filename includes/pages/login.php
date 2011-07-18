<?

$R = new Ruler($db);
$R->smarty = $smarty;

if ($ruler = $R->CheckLogin($_POST['email'], $_POST['password'])){
  $R->Login($ruler['id']);
  header('Location: /');
  exit;
}

$smarty->assign('content', $smarty->fetch('login.tpl'));
$smarty->display('layout_login.tpl');
exit;
?>