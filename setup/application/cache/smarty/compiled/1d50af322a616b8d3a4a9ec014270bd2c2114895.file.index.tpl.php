<?php /* Smarty version Smarty-3.0.7, created on 2011-07-16 20:02:07
         compiled from "application/views/start_buildings/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6600512944e21e02fdf0b82-08877957%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1d50af322a616b8d3a4a9ec014270bd2c2114895' => 
    array (
      0 => 'application/views/start_buildings/index.tpl',
      1 => 1310831146,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6600512944e21e02fdf0b82-08877957',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Starting Building Editor</h1>

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
      <td colspan="11"><a href="/start_buildings/add">Add</a></td>
    </tr>

    <?php if ($_smarty_tpl->getVariable('buildings')->value){?>
      <?php  $_smarty_tpl->tpl_vars['b'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('buildings')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['b']->key => $_smarty_tpl->tpl_vars['b']->value){
?>
        <tr>
          <td><a href="/start_resources/edit/<?php echo $_smarty_tpl->tpl_vars['b']->value['building_id'];?>
">Edit</a></td>
          <td><a href="/start_resources/delete/<?php echo $_smarty_tpl->tpl_vars['b']->value['building_id'];?>
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
