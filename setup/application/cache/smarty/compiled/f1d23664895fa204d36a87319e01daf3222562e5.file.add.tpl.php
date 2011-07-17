<?php /* Smarty version Smarty-3.0.7, created on 2011-07-17 16:40:39
         compiled from "application/views/gal_resources/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2035274904e230277ec4be8-28053724%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f1d23664895fa204d36a87319e01daf3222562e5' => 
    array (
      0 => 'application/views/gal_resources/add.tpl',
      1 => 1310917024,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2035274904e230277ec4be8-28053724',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Adding starting resource</h1>

<p><a href="/setup/gal_resources">Back to resources</a></p>

<?php if ($_smarty_tpl->getVariable('messages')->value){?>
  <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('messages')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
 $_smarty_tpl->tpl_vars['type']->value = $_smarty_tpl->tpl_vars['m']->key;
?>
    <div class="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
">
      <?php  $_smarty_tpl->tpl_vars['message'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['m']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['message']->key => $_smarty_tpl->tpl_vars['message']->value){
?>
        <p><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</p>
      <?php }} ?>
    </div>
  <?php }} ?>
<?php }?>


<?php if ($_smarty_tpl->getVariable('errors')->value){?>
  <?php echo $_smarty_tpl->getVariable('errors')->value;?>

<?php }?>
<?php echo $_smarty_tpl->getVariable('form')->value;?>

