<?php /* Smarty version Smarty-3.0.7, created on 2011-07-15 23:17:56
         compiled from "application/views/ships/resources_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7722557674e20bc940e9c61-66889212%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c12567064b94484a9ebfe032fd26103ee60b1bc8' => 
    array (
      0 => 'application/views/ships/resources_list.tpl',
      1 => 1310768186,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7722557674e20bc940e9c61-66889212',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1><?php echo $_smarty_tpl->getVariable('ship')->value['name'];?>
 resources</h1>

<p><a href="/ships">Back to ships</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Resource Name</th>
      <th>Construction Cost</th>
      <th>Storage</th>
      <th>Refund</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="9"><a href="/ships/resources/<?php echo $_smarty_tpl->getVariable('ship')->value['id'];?>
/add">Add</a></td>
    </tr>
    <?php if ($_smarty_tpl->getVariable('resources')->value){?>
      <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('resources')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
?>
        <tr>
          <td><a href="/ships/resources/<?php echo $_smarty_tpl->getVariable('ship')->value['id'];?>
/edit/<?php echo $_smarty_tpl->tpl_vars['r']->value['resource_id'];?>
">Edit</a></td>
          <td><a href="/ships/resources/<?php echo $_smarty_tpl->getVariable('ship')->value['id'];?>
/delete/<?php echo $_smarty_tpl->tpl_vars['r']->value['resource_id'];?>
">Delete</a></td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['name'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['cost'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['storage'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['refund'];?>
</td>
        </tr>
      <?php }} ?>
    <?php }?>
  </tbody>
</table>
