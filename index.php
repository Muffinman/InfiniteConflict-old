<?php

require_once 'includes/config.php';
require_once 'includes/functions.php';

$smarty->assign('title', 'Infinite Conflict - The Second Best Tick Based Strategy Game.');
$smarty->assign('keywords', 'Online game, strategy game, online strategy game');

$IC = IC::getInstance();
$Ruler = Ruler::getInstance();
$Research = Research::getInstance();
$Planet = Planet::getInstance();
$Ruler = Ruler::getInstance();
$Fleet = Fleet::getInstance();

$IC->smarty = $smarty;

# Detect URL components
$request = fetch_url_parts();
$smarty->assign('request', $request);

if (!$_SESSION['ruler']
    && $request[0] != 'login'
    && $request[0] != 'register'
    && $request[0] != 'confirm'
    && $request[0] != 'forgotten'
    && $request[0] != 'support'
    && $request[0] != 'styles.css'
    && $request[0] != 'scripts.js'){
  $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
  header('Location: /login');
  die;
}

# get default template contents (title, meta data etc.)
template_data();

$smarty->assign('ruler', $_SESSION['ruler']);
$smarty->assign('config', $IC->config);


if ($request[0] == 'ajax'){
  if (file_exists('includes/ajax/' . $request[1] . '/' . $request[2] . '.php')){
    require_once 'includes/ajax/' . $request[1] . '/' . $request[2] . '.php';
  }
}

else if ($request[0] == 'scripts.js'){
	$scripts = array();
	$scripts[] = SITE_ROOTPATH . 'js/jquery-1.6.2.min.js';
	$scripts[] = SITE_ROOTPATH . 'js/jquery-ui-1.8.14.custom.min.js';
	$scripts[] = SITE_ROOTPATH . 'js/modernizr-1.5.min.js';
	$scripts[] = SITE_ROOTPATH . 'js/main.js';
	$scripts[] = SITE_ROOTPATH . 'js/research.js';
	$scripts[] = SITE_ROOTPATH . 'js/planet.js';
	$scripts[] = SITE_ROOTPATH . 'js/fleet.js';
	$minify_method = 'js';
	require_once  'includes/minify/minify.php';
}

else if ($request[0] == 'styles.css'){
	$scripts = array();
	$scripts[] = SITE_ROOTPATH . 'css/reset.css';
	$scripts[] = SITE_ROOTPATH . 'css/template.css';
	$scripts[] = SITE_ROOTPATH . 'css/planet.css';
	$scripts[] = SITE_ROOTPATH . 'css/research.css';
	$scripts[] = SITE_ROOTPATH . 'css/navigation.css';
	$scripts[] = SITE_ROOTPATH . 'css/fleets.css';
	$scripts[] = SITE_ROOTPATH . 'css/alliances.css';
	$minify_method = 'css';
	require_once  'includes/minify/minify.php';
}

else if (file_exists('includes/pages/' . $request[0] . '.php')){
  require_once 'includes/pages/' . $request[0] . '.php';
}

else{
  require_once 'includes/pages/default.php';
}

//FB::log($db->allQueries, 'Database');

closedown($pagestart);
$smarty->display('layout_game.tpl');
