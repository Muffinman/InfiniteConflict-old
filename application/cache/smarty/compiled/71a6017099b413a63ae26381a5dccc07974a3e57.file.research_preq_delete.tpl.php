<?php /* Smarty version Smarty-3.0.7, created on 2011-07-14 22:43:26
         compiled from "application/views/research/research_preq_delete.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19058692914e1f62fe8396a9-77824274%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '71a6017099b413a63ae26381a5dccc07974a3e57' => 
    array (
      0 => 'application/views/research/research_preq_delete.tpl',
      1 => 1310675966,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19058692914e1f62fe8396a9-77824274',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Deleting <?php echo $_smarty_tpl->getVariable('research')->value['name'];?>
 prerequisites</h1>

<p><a href="/research/research_preq/<?php echo $_smarty_tpl->getVariable('research')->value['id'];?>
">Back to research</a></p>

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
