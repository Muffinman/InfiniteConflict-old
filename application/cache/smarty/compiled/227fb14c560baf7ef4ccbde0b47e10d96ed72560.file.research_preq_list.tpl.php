<?php /* Smarty version Smarty-3.0.7, created on 2011-07-14 23:04:45
         compiled from "application/views/buildings/research_preq_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7503975504e1f67fd466ad1-35833797%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '227fb14c560baf7ef4ccbde0b47e10d96ed72560' => 
    array (
      0 => 'application/views/buildings/research_preq_list.tpl',
      1 => 1310681062,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7503975504e1f67fd466ad1-35833797',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1><?php echo $_smarty_tpl->getVariable('building')->value['name'];?>
 prerequisites</h1>

<p><a href="/buildings">Back to research</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>Prerequisite Name</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="2"><a href="/buildings/research_preq/<?php echo $_smarty_tpl->getVariable('building')->value['id'];?>
/add">Add</a></td>
    </tr>
    <?php if ($_smarty_tpl->getVariable('prereq')->value){?>
      <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('prereq')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
?>
        <tr>
          <td><a href="/buildings/research_preq/<?php echo $_smarty_tpl->getVariable('building')->value['id'];?>
/delete/<?php echo $_smarty_tpl->tpl_vars['p']->value['id'];?>
">Delete</a></td>
          <td><?php echo $_smarty_tpl->tpl_vars['p']->value['name'];?>
</td>
        </tr>
      <?php }} ?>
    <?php }?>
  </tbody>
</table>
