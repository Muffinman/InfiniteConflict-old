<?php /* Smarty version Smarty-3.0.7, created on 2011-07-14 21:02:51
         compiled from "application/views/buildings/buildings_preq_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7403023904e1f4b6ba026b8-16367131%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '83b1c5966a08c36cbdbe7ce5436435bd89a31259' => 
    array (
      0 => 'application/views/buildings/buildings_preq_list.tpl',
      1 => 1310673634,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7403023904e1f4b6ba026b8-16367131',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1><?php echo $_smarty_tpl->getVariable('building')->value['name'];?>
 prerequisites</h1>

<p><a href="/buildings">Back to buildings</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>Prerequisite Name</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="2"><a href="/buildings/buildings_preq/<?php echo $_smarty_tpl->getVariable('building')->value['id'];?>
/add">Add</a></td>
    </tr>
    <?php if ($_smarty_tpl->getVariable('prereq')->value){?>
      <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('prereq')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
?>
        <tr>
          <td><a href="/buildings/buildings_preq/<?php echo $_smarty_tpl->getVariable('building')->value['id'];?>
/delete/<?php echo $_smarty_tpl->tpl_vars['p']->value['id'];?>
">Delete</a></td>
          <td><?php echo $_smarty_tpl->tpl_vars['p']->value['name'];?>
</td>
        </tr>
      <?php }} ?>
    <?php }?>
  </tbody>
</table>
