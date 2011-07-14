<?php /* Smarty version Smarty-3.0.7, created on 2011-07-14 21:57:53
         compiled from "application/views/research/resources_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7792905884e1f5851cb6a47-46501136%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b4bf128cc023c986044df876107a073005498b23' => 
    array (
      0 => 'application/views/research/resources_list.tpl',
      1 => 1310677064,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7792905884e1f5851cb6a47-46501136',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1><?php echo $_smarty_tpl->getVariable('research')->value['name'];?>
 resources</h1>

<p><a href="/research">Back to research</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Resource Name</th>
      <th>Resource Cost</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="9"><a href="/research/resources/<?php echo $_smarty_tpl->getVariable('research')->value['id'];?>
/add">Add</a></td>
    </tr>
    <?php if ($_smarty_tpl->getVariable('resources')->value){?>
      <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('resources')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
?>
        <tr>
          <td><a href="/research/resources/<?php echo $_smarty_tpl->getVariable('research')->value['id'];?>
/edit/<?php echo $_smarty_tpl->tpl_vars['r']->value['resource_id'];?>
">Edit</a></td>
          <td><a href="/research/resources/<?php echo $_smarty_tpl->getVariable('research')->value['id'];?>
/delete/<?php echo $_smarty_tpl->tpl_vars['r']->value['resource_id'];?>
">Delete</a></td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['name'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['cost'];?>
</td>
        </tr>
      <?php }} ?>
    <?php }?>
  </tbody>
</table>
