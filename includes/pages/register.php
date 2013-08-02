<?

$Ruler->smarty = $smarty;

$form = new Form();

$form->Email('email', false);
$form->Email('email2', false);
$form->Match('email', 'email2', 'email');

$form->Password('password', false, 6);
$form->Password('password2', false, 6);
$form->Match('password', 'password2', 'password');

if ($_POST){

  if (!$Ruler->CheckEmail($form->formData['email'])){
    $form->AddError('email', 'Email address in use');
  }

  if ($form->hasErrors){
    $smarty->assign('errors', $form->errHelp);
    $smarty->assign('formdata', $form->formData);
  }else{

    $arr = array(
      'email' => $form->formData['email'],
      'password' => $Ruler->CreatePassword($form->formData['email'], $form->formData['password'])
    );

    if ($ruler = $Ruler->CreateRuler($arr)){
      $smarty->assign('content', $smarty->fetch('register_complete.tpl'));
      $smarty->display('layout_login.tpl');
      exit;
    }
  }
}

$smarty->assign('content', $smarty->fetch('register.tpl'));
$smarty->display('layout_login.tpl');
exit;
?>