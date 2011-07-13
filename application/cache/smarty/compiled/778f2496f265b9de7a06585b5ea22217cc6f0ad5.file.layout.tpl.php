<?php /* Smarty version Smarty-3.0.7, created on 2011-07-12 16:17:24
         compiled from "application/views/layout.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8009621304e1c6584e548a0-82196317%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '778f2496f265b9de7a06585b5ea22217cc6f0ad5' => 
    array (
      0 => 'application/views/layout.tpl',
      1 => 1310483839,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8009621304e1c6584e548a0-82196317',
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

<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 14px;
 color: #4F5155;
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 1px solid #D0D0D0;
 font-size: 16px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}

table{
  margin:20px 0;
}


td, th{
  padding:4px;
  font-size:13px;
}


</style>
</head>
<body>

<?php if ($_smarty_tpl->getVariable('content')->value){?>
  <?php echo $_smarty_tpl->getVariable('content')->value;?>

<?php }?>

<p><br />Page rendered in {elapsed_time} seconds</p>

</body>
</html>