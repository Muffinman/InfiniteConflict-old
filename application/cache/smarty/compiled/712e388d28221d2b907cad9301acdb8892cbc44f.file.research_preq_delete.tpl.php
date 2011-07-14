<?php /* Smarty version Smarty-3.0.7, created on 2011-07-14 23:09:19
         compiled from "application/views/buildings/research_preq_delete.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3916671304e1f690fa90523-92580700%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '712e388d28221d2b907cad9301acdb8892cbc44f' => 
    array (
      0 => 'application/views/buildings/research_preq_delete.tpl',
      1 => 1310681071,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3916671304e1f690fa90523-92580700',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Deleting <?php echo $_smarty_tpl->getVariable('building')->value['name'];?>
 prerequisites</h1>

<p><a href="/buildings/research_preq/<?php echo $_smarty_tpl->getVariable('building')->value['id'];?>
">Back to buildings</a></p>

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
