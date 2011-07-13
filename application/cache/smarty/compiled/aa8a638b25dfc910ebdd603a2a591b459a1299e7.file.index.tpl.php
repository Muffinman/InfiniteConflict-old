<?php /* Smarty version Smarty-3.0.7, created on 2011-07-13 21:58:04
         compiled from "application/views/buildings/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18352771954e1e06dc972ce7-65102019%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa8a638b25dfc910ebdd603a2a591b459a1299e7' => 
    array (
      0 => 'application/views/buildings/index.tpl',
      1 => 1310590683,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18352771954e1e06dc972ce7-65102019',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Building Editor</h1>

<p><a href="/">Back to home</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Building Name</th>
      <th>Max Qty</th>
      <th>Creation Time</th>
      <th>Demolish</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="7"><a href="/buildings/add">Add</a></td>
    </tr>
    <?php if ($_smarty_tpl->getVariable('buildings')->value){?>
      <?php  $_smarty_tpl->tpl_vars['b'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('buildings')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['b']->key => $_smarty_tpl->tpl_vars['b']->value){
?>
        <tr>
          <td><a href="/buildings/edit/<?php echo $_smarty_tpl->tpl_vars['b']->value['id'];?>
">Edit</a></td>
          <td><a href="/buildings/delete/<?php echo $_smarty_tpl->tpl_vars['b']->value['id'];?>
">Delete</a></td>
          <td><a href="/buildings/resources/<?php echo $_smarty_tpl->tpl_vars['b']->value['id'];?>
">Resources</a></td>
          <td><?php echo $_smarty_tpl->tpl_vars['b']->value['name'];?>
</td>
          <td><?php if ($_smarty_tpl->tpl_vars['b']->value['max']){?><?php echo $_smarty_tpl->tpl_vars['b']->value['max'];?>
<?php }else{ ?>&#8734;<?php }?></td>
          <td><?php echo $_smarty_tpl->tpl_vars['b']->value['turns'];?>
</td>
          <td><?php if ($_smarty_tpl->tpl_vars['b']->value['demolish']){?>Yes: <?php echo $_smarty_tpl->tpl_vars['b']->value['demolish'];?>
<?php }else{ ?>No<?php }?></td>
        </tr>
      <?php }} ?>
    <?php }?>
  </tbody>
</table>
