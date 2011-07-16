<?php /* Smarty version Smarty-3.0.7, created on 2011-07-16 17:05:13
         compiled from "application/views/colo_buildings/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13234956234e21b6b97219d6-51242045%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd3e441ec1e850a3cedd0fe421ac1a4d4cd8fbb0d' => 
    array (
      0 => 'application/views/colo_buildings/index.tpl',
      1 => 1310831366,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13234956234e21b6b97219d6-51242045',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Colonisation Building Editor</h1>

<p><a href="/">Back to home</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Building Name</th>
      <th>Qty</th>
    </tr>
  </thead>
  <tbody>

    <tr>
      <td colspan="11"><a href="/colo_buildings/add">Add</a></td>
    </tr>

    <?php if ($_smarty_tpl->getVariable('buildings')->value){?>
      <?php  $_smarty_tpl->tpl_vars['b'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('buildings')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['b']->key => $_smarty_tpl->tpl_vars['b']->value){
?>
        <tr>
          <td><a href="/colo_buildings/edit/<?php echo $_smarty_tpl->tpl_vars['b']->value['building_id'];?>
">Edit</a></td>
          <td><a href="/colo_buildings/delete/<?php echo $_smarty_tpl->tpl_vars['b']->value['building_id'];?>
">Delete</a></td>
          <td><?php echo $_smarty_tpl->tpl_vars['b']->value['name'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['b']->value['qty'];?>
</td>
        </tr>
      <?php }} ?>
    <?php }?>
  </tbody>
</table>
