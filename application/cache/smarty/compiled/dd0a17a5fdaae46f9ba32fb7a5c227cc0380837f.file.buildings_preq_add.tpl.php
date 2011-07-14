<?php /* Smarty version Smarty-3.0.7, created on 2011-07-14 21:12:57
         compiled from "application/views/buildings/buildings_preq_add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13538368704e1f4dc94d3c70-54258329%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dd0a17a5fdaae46f9ba32fb7a5c227cc0380837f' => 
    array (
      0 => 'application/views/buildings/buildings_preq_add.tpl',
      1 => 1310674346,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13538368704e1f4dc94d3c70-54258329',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Adding <?php echo $_smarty_tpl->getVariable('building')->value['name'];?>
 prerequisite</h1>

<p><a href="/buildings/buildings_preq/<?php echo $_smarty_tpl->getVariable('building')->value['id'];?>
">Back to building prerequisites</a></p>

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

