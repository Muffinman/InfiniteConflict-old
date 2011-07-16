<?php /* Smarty version Smarty-3.0.7, created on 2011-07-15 17:39:11
         compiled from "application/views/layout.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11656111714e206d2f14af50-32347501%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '778f2496f265b9de7a06585b5ea22217cc6f0ad5' => 
    array (
      0 => 'application/views/layout.tpl',
      1 => 1310747946,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11656111714e206d2f14af50-32347501',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $_smarty_tpl->getVariable('meta_title')->value;?>
</title>
  <link rel="stylesheet" type="text/css" href="/css/main.css">
</head>
<body>

<div id="background">
  <div id="container">

    <ul id="menu">
      <li class="home"><a href="/">Home</a></li>
      <li class="planets"><a href="">Planets</a></li>
      <li class="fleets"><a href="">Fleets</a></li>
      <li class="navigation"><a href="">Navigation</a></li>
      <li class="research"><a href="">Research</a></li>
      <li class="alliances"><a href="">Alliances</a></li>
    </ul>
    <div class="content headbar menu">
      <p>Welcome to the Infinite Conflict Game Editor</p>
    </div>

    <div class="content">
      <?php if ($_smarty_tpl->getVariable('content')->value){?>
        <?php echo $_smarty_tpl->getVariable('content')->value;?>

      <?php }?>
    </div>

    <div class="content headbar">
      <p>Page rendered in {elapsed_time} seconds</p>
    </div>
  </div>
  </div>

</body>
</html>
