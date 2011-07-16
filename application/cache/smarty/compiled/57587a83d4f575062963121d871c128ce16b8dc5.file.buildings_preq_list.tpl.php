<?php /* Smarty version Smarty-3.0.7, created on 2011-07-15 19:11:17
         compiled from "application/views/ships/buildings_preq_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9168543914e2082c5329b36-18039675%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '57587a83d4f575062963121d871c128ce16b8dc5' => 
    array (
      0 => 'application/views/ships/buildings_preq_list.tpl',
      1 => 1310753460,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9168543914e2082c5329b36-18039675',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1><?php echo $_smarty_tpl->getVariable('ship')->value['name'];?>
 prerequisites</h1>

<p><a href="/ships">Back to ships</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>Prerequisite Name</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="2"><a href="/ships/building_preq/<?php echo $_smarty_tpl->getVariable('ship')->value['id'];?>
/add">Add</a></td>
    </tr>
    <?php if ($_smarty_tpl->getVariable('prereq')->value){?>
      <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('prereq')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
?>
        <tr>
          <td><a href="/ships/building_preq/<?php echo $_smarty_tpl->getVariable('ship')->value['id'];?>
/delete/<?php echo $_smarty_tpl->tpl_vars['p']->value['id'];?>
">Delete</a></td>
          <td><?php echo $_smarty_tpl->tpl_vars['p']->value['name'];?>
</td>
        </tr>
      <?php }} ?>
    <?php }?>
  </tbody>
</table>
