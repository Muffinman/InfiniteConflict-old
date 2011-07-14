<?php /* Smarty version Smarty-3.0.7, created on 2011-07-14 22:34:53
         compiled from "application/views/research/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7543514874e1f60fd825b13-91782731%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ff391bf236147e6db46ce0814cac021dc05562e4' => 
    array (
      0 => 'application/views/research/index.tpl',
      1 => 1310679292,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7543514874e1f60fd825b13-91782731',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Research Editor</h1>

<p><a href="/">Back to home</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Research Name</th>
      <th>Resources</th>
      <th>Prerequisites</th>
      <th>Creation Time</th>
      <th>Given</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="7"><a href="/research/add">Add</a></td>
    </tr>
    <?php if ($_smarty_tpl->getVariable('research')->value){?>
      <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('research')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
?>
        <tr>
          <td><a href="/research/edit/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
">Edit</a></td>
          <td><a href="/research/delete/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
">Delete</a></td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['name'];?>
</td>
          <td><a href="/research/resources/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
">Resources</a></td>
          <td><a href="/research/research_preq/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
">Prereq</a></td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['turns'];?>
</td>
          <td><?php if ($_smarty_tpl->tpl_vars['r']->value['given']){?>Yes<?php }else{ ?>No<?php }?></td>
        </tr>
      <?php }} ?>
    <?php }?>
  </tbody>
</table>
