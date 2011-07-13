<?php /* Smarty version Smarty-3.0.7, created on 2011-07-13 21:56:06
         compiled from "application/views/buildings/resources_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1163508944e1e06669e8740-99599769%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '81264d5896ce2abf10da77a83946f6e45858e628' => 
    array (
      0 => 'application/views/buildings/resources_list.tpl',
      1 => 1310590565,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1163508944e1e06669e8740-99599769',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1><?php echo $_smarty_tpl->getVariable('building')->value['name'];?>
 resources</h1>

<p><a href="/buildings">Back to buildings</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Resource Name</th>
      <th>Construction Cost</th>
      <th>Output</th>
      <th>Stores</th>
      <th>Interest</th>
      <th>Abundance</th>
      <th>Refund</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="9"><a href="/buildings/resources/<?php echo $_smarty_tpl->getVariable('building')->value['id'];?>
/add">Add</a></td>
    </tr>
    <?php if ($_smarty_tpl->getVariable('resources')->value){?>
      <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('resources')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
?>
        <tr>
          <td><a href="/buildings/resources/<?php echo $_smarty_tpl->getVariable('building')->value['id'];?>
/edit/<?php echo $_smarty_tpl->tpl_vars['r']->value['resource_id'];?>
">Edit</a></td>
          <td><a href="/buildings/resources/<?php echo $_smarty_tpl->getVariable('building')->value['id'];?>
/delete/<?php echo $_smarty_tpl->tpl_vars['r']->value['resource_id'];?>
">Delete</a></td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['name'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['cost'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['output'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['stores'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['interest'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['abundance'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['refund'];?>
</td>
        </tr>
      <?php }} ?>
    <?php }?>
  </tbody>
</table>
