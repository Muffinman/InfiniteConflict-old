<?php /* Smarty version Smarty-3.0.7, created on 2011-07-15 23:39:49
         compiled from "application/views/ships/buildings_preq_delete.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16005043184e20c1b5af7eb4-02448232%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'adc24ca958224f69856b2de33a409e16b2c2c205' => 
    array (
      0 => 'application/views/ships/buildings_preq_delete.tpl',
      1 => 1310768877,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16005043184e20c1b5af7eb4-02448232',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Deleting <?php echo $_smarty_tpl->getVariable('ship')->value['name'];?>
 prerequisites</h1>

<p><a href="/ships/building_preq/<?php echo $_smarty_tpl->getVariable('ship')->value['id'];?>
">Back to ship</a></p>

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
