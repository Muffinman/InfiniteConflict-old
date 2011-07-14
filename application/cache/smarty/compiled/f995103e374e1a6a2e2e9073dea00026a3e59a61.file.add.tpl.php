<?php /* Smarty version Smarty-3.0.7, created on 2011-07-14 21:44:08
         compiled from "application/views/research/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20085459404e1f55189a3915-87091063%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f995103e374e1a6a2e2e9073dea00026a3e59a61' => 
    array (
      0 => 'application/views/research/add.tpl',
      1 => 1310675824,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20085459404e1f55189a3915-87091063',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Adding research</h1>

<p><a href="/research">Back to research</a></p>

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

