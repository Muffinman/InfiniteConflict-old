<?php

require_once 'includes/config.php';
require_once 'includes/functions.php';

$IC = new IC($db);
$IC->smarty = $smarty;

# Detect URL components
$request = fetch_url_parts();
$smarty->assign('request', $request);

if (!$_SESSION['ruler']
    && $request[0] != 'login'
    && $request[0] != 'register'
    && $request[0] != 'confirm'
    && $request[0] != 'forgotten'
    && $request[0] != 'support'){
  $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
  header('Location: /login');
  die;
}

# get default template contents (title, meta data etc.)
template_data();

$smarty->assign('ruler', $_SESSION['ruler']);
$smarty->assign('config', $config);


if (file_exists('includes/pages/' . $request[0] . '.php')){
  require_once 'includes/pages/' . $request[0] . '.php';
}else{
  require_once 'includes/pages/default.php';
}

closedown($pagestart);
$smarty->display('layout_game.tpl');
