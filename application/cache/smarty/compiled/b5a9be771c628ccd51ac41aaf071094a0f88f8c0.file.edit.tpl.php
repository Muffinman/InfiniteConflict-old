<?php /* Smarty version Smarty-3.0.7, created on 2011-07-15 00:02:06
         compiled from "application/views/resources/edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18803094054e1f756e8ee0f8-10541495%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b5a9be771c628ccd51ac41aaf071094a0f88f8c0' => 
    array (
      0 => 'application/views/resources/edit.tpl',
      1 => 1310590805,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18803094054e1f756e8ee0f8-10541495',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Editing <?php echo $_smarty_tpl->getVariable('res')->value['name'];?>
</h1>

<p><a href="/resources">Back to resources</a></p>

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

