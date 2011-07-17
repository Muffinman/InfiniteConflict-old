<?php /* Smarty version Smarty-3.0.7, created on 2011-07-17 15:21:03
         compiled from "application/views/start_resources/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10108793784e22efcf60ec19-45587008%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd2a3d9d434839b536ec0a928733fb8e37214ea06' => 
    array (
      0 => 'application/views/start_resources/index.tpl',
      1 => 1310891945,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10108793784e22efcf60ec19-45587008',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Starting Resource Editor</h1>

<p><a href="/setup/">Back to home</a></p>

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
      <td colspan="11"><a href="/setup/start_resources/add">Add</a></td>
    </tr>

    <?php if ($_smarty_tpl->getVariable('res')->value){?>
      <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('res')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
?>
        <tr>
          <td><a href="/setup/start_resources/edit/<?php echo $_smarty_tpl->tpl_vars['r']->value['resource_id'];?>
">Edit</a></td>
          <td><a href="/setup/start_resources/delete/<?php echo $_smarty_tpl->tpl_vars['r']->value['resource_id'];?>
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
