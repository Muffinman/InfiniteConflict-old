<?

if ($_SESSION['ruler']){
  header('Location: /');
  exit;
}

$form = new Form();

if ($_POST && !$form->hasErrors){

}

$smarty->assign('content', $smarty->fetch('forgotten.tpl'));
$smarty->display('layout_login.tpl');
exit;

?>