<?php /* Smarty version Smarty-3.0.7, created on 2011-07-17 16:46:23
         compiled from "application/views/gal_resources/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8390774034e2303cfcb71d9-63245577%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5119ed527b0d293b812f7bdd3c34de16681e87d8' => 
    array (
      0 => 'application/views/gal_resources/index.tpl',
      1 => 1310917582,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8390774034e2303cfcb71d9-63245577',
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
      <th colspan="3">&nbsp;</th>
      <th colspan="4">Home Gals</th>
      <th colspan="4">Free Gals</th>
    </tr>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Resource Name</th>
      <th>Min Stored</th>
      <th>Max Stored</th>
      <th>Min Abundance</th>
      <th>Max Abundance</th>
      <th>Min Stored</th>
      <th>Max Stored</th>
      <th>Min Abundance</th>
      <th>Max Abundance</th>
    </tr>
  </thead>
  <tbody>

    <tr>
      <td colspan="11"><a href="/setup/gal_resources/add">Add</a></td>
    </tr>

    <?php if ($_smarty_tpl->getVariable('res')->value){?>
      <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('res')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
?>
        <tr>
          <td><a href="/setup/gal_resources/edit/<?php echo $_smarty_tpl->tpl_vars['r']->value['resource_id'];?>
">Edit</a></td>
          <td><a href="/setup/gal_resources/delete/<?php echo $_smarty_tpl->tpl_vars['r']->value['resource_id'];?>
">Delete</a></td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['name'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['home_min_stored'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['home_max_stored'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['home_min_abundance'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['home_max_abundance'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['free_min_stored'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['free_max_stored'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['free_min_abundance'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['free_max_abundance'];?>
</td>
        </tr>
      <?php }} ?>
    <?php }?>
  </tbody>
</table>
