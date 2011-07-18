<?php

require_once 'includes/config.php';
require_once 'includes/functions.php';

$IC = new IC($db);

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


switch ($request[0]) {
  case 'login':
		require_once 'includes/pages/login.php';
		break;
  case 'register':
		require_once 'includes/pages/register.php';
		break;
  case 'confirm':
		require_once 'includes/pages/confirm.php';
		break;

  case 'generateUniverse':
		require_once 'includes/pages/generate_universe.php';
		break;

	default:
		require_once 'includes/pages/default.php';
		break;
}

closedown($pagestart);
$smarty->display('layout_game.tpl');
