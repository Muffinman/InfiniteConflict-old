<?php /* Smarty version Smarty-3.0.7, created on 2011-07-14 21:21:13
         compiled from "application/views/buildings/buildings_preq_delete.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15834682834e1f4fb9abd627-83838889%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bca89c0966868d2062459dc0c6893a1804f4b0c0' => 
    array (
      0 => 'application/views/buildings/buildings_preq_delete.tpl',
      1 => 1310674866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15834682834e1f4fb9abd627-83838889',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Deleting <?php echo $_smarty_tpl->getVariable('building')->value['name'];?>
 prerequisites</h1>

<p><a href="/buildings/buildings_preq/<?php echo $_smarty_tpl->getVariable('building')->value['id'];?>
">Back to building</a></p>

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
