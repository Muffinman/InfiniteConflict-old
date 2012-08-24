<?

if (!$IC->Ruler->CheckConfirmCode($request[1])){
  $smarty->assign('content', $smarty->fetch('confirm_error.tpl'));
  $smarty->display('layout_login.tpl');
  exit;
}

$form = new Form();
$form->Text('rulername', false, 3, 45);
$form->Text('planetname', false, 3, 45);

if ($_POST){

  if (!$IC->Ruler->CheckRulerName($form->formData['rulername'])){
    $form->AddError('rulername', 'Name already in use');
  }

  if ($form->hasErrors){
    $smarty->assign('errors', $form->errHelp);
    $smarty->assign('formdata', $form->formData);
  }else{

    $arr = array(
      'rulername' => $form->formData['rulername'],
      'planetname' => $form->formData['planetname'],
      'hash' => $request[1]
    );

    if ($ruler = $IC->Ruler->SignupRuler($arr)){
      $IC->Ruler->Login($ruler['id']);
    	header('Location: /');
    	exit;
    }
  }
}

$smarty->assign('content', $smarty->fetch('confirm.tpl'));
$smarty->display('layout_login.tpl');
exit;
?>