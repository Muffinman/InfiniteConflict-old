<?php /* Smarty version Smarty-3.0.7, created on 2011-07-15 19:09:26
         compiled from "application/views/ships/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:440282134e208256ddad59-38328959%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fd9e8d11e7d1c310d115b215fc92036bcb1b529c' => 
    array (
      0 => 'application/views/ships/index.tpl',
      1 => 1310753199,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '440282134e208256ddad59-38328959',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Ship Editor</h1>

<p><a href="/">Back to home</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Ship Name</th>
      <th>Resources</th>
      <th colspan="2">Prerequisites</th>
      <th>Max Qty</th>
      <th>Creation Time</th>
      <th>Fleet Drive</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="9"><a href="/ships/add">Add</a></td>
    </tr>
    <?php if ($_smarty_tpl->getVariable('ships')->value){?>
      <?php  $_smarty_tpl->tpl_vars['s'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('ships')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['s']->key => $_smarty_tpl->tpl_vars['s']->value){
?>
        <tr>
          <td><a href="/ships/edit/<?php echo $_smarty_tpl->tpl_vars['s']->value['id'];?>
">Edit</a></td>
          <td><a href="/ships/delete/<?php echo $_smarty_tpl->tpl_vars['s']->value['id'];?>
">Delete</a></td>
          <td><?php echo $_smarty_tpl->tpl_vars['s']->value['name'];?>
</td>
          <td><a href="/ships/resources/<?php echo $_smarty_tpl->tpl_vars['s']->value['id'];?>
">Resources</a></td>
          <td><a href="/ships/research_preq/<?php echo $_smarty_tpl->tpl_vars['s']->value['id'];?>
">Research</a></td>
          <td><a href="/ships/building_preq/<?php echo $_smarty_tpl->tpl_vars['s']->value['id'];?>
">Buildings</a></td>
          <td><?php if ($_smarty_tpl->tpl_vars['s']->value['max']){?><?php echo $_smarty_tpl->tpl_vars['s']->value['max'];?>
<?php }else{ ?>&#8734;<?php }?></td>
          <td><?php echo $_smarty_tpl->tpl_vars['s']->value['turns'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['s']->value['drive'];?>
</td>
        </tr>
      <?php }} ?>
    <?php }?>
  </tbody>
</table>
