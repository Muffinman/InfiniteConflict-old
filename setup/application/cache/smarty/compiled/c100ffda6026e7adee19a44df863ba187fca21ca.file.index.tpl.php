<?php /* Smarty version Smarty-3.0.7, created on 2011-07-16 20:02:02
         compiled from "application/views/colo_resources/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8487081474e21e02aa954d4-88637806%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c100ffda6026e7adee19a44df863ba187fca21ca' => 
    array (
      0 => 'application/views/colo_resources/index.tpl',
      1 => 1310831339,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8487081474e21e02aa954d4-88637806',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Colonisation Resource Editor</h1>

<p><a href="/">Back to home</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Resource Name</th>
      <th>Stored</th>
      <th>Abundance</th>
    </tr>
  </thead>
  <tbody>

    <tr>
      <td colspan="11"><a href="/colo_resources/add">Add</a></td>
    </tr>

    <?php if ($_smarty_tpl->getVariable('res')->value){?>
      <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('res')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
?>
        <tr>
          <td><a href="/colo_resources/edit/<?php echo $_smarty_tpl->tpl_vars['r']->value['resource_id'];?>
">Edit</a></td>
          <td><a href="/colo_resources/delete/<?php echo $_smarty_tpl->tpl_vars['r']->value['resource_id'];?>
">Delete</a></td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['name'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['stored'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['abundance'];?>
</td>
        </tr>
      <?php }} ?>
    <?php }?>
  </tbody>
</table>
