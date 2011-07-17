<?php

require_once 'includes/config.php';
require_once 'includes/functions.php';

# Detect URL components
$request = fetch_url_parts();
$smarty->assign('request', $request);

if (!$_SESSION['ruler'] && $request[0] != 'login' && $request[0] != 'register'){
  $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
  header('Location: /login');
  die;
}

# get default template contents (title, meta data etc.)
template_data();

$ruler = array(
  'id' => 1,
  'name' => 'Muffinman',
  'alliance_id' => false
);

$smarty->assign('ruler', $ruler);
$smarty->assign('config', $config);


switch ($request[0]) {
  case 'login':
		require_once 'includes/pages/login.php';
		break;
  case 'register':
		require_once 'includes/pages/reister.php';
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
