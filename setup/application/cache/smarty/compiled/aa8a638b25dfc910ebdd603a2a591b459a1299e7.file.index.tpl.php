<?php /* Smarty version Smarty-3.0.7, created on 2011-07-16 20:00:29
         compiled from "application/views/buildings/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14546351294e21dfcd31ccc5-66642395%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa8a638b25dfc910ebdd603a2a591b459a1299e7' => 
    array (
      0 => 'application/views/buildings/index.tpl',
      1 => 1310684508,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14546351294e21dfcd31ccc5-66642395',
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
      <th>Building Name</th>
      <th>Resources</th>
      <th colspan="2">Prerequisites</th>
      <th>Max Qty</th>
      <th>Creation Time</th>
      <th>Demolish</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="9"><a href="/buildings/add">Add</a></td>
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
          <td><?php echo $_smarty_tpl->tpl_vars['b']->value['name'];?>
</td>
          <td><a href="/buildings/resources/<?php echo $_smarty_tpl->tpl_vars['b']->value['id'];?>
">Resources</a></td>
          <td><a href="/buildings/buildings_preq/<?php echo $_smarty_tpl->tpl_vars['b']->value['id'];?>
">Buildings</a></td>
          <td><a href="/buildings/research_preq/<?php echo $_smarty_tpl->tpl_vars['b']->value['id'];?>
">Research</a></td>
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
