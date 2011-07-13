<?php /* Smarty version Smarty-3.0.7, created on 2011-07-13 21:59:41
         compiled from "application/views/resources/conversion_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5121141294e1e073dacb0e9-08722321%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '32769c680104e5fb21aa5b2f64f369aebade64f2' => 
    array (
      0 => 'application/views/resources/conversion_list.tpl',
      1 => 1310590780,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5121141294e1e073dacb0e9-08722321',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Cost of conversion for <?php echo $_smarty_tpl->getVariable('resource')->value['name'];?>
</h1>

<p><a href="/resources">Back to resources</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Resource Name</th>
      <th>Quantity</th>
      <th>Refund</th>
    </tr>
  </thead>
  <tbody>

    <tr>
      <td colspan="7"><a href="/resources/conversion/<?php echo $_smarty_tpl->getVariable('resource')->value['id'];?>
/add">Add</a></td>
    </tr>

    <?php if ($_smarty_tpl->getVariable('conversion')->value){?>
      <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('conversion')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
?>
        <tr>
          <td><a href="/resources/conversion/<?php echo $_smarty_tpl->getVariable('resource')->value['id'];?>
/edit/<?php echo $_smarty_tpl->tpl_vars['c']->value['id'];?>
">Edit</a></td>
          <td><a href="/resources/conversion/<?php echo $_smarty_tpl->getVariable('resource')->value['id'];?>
/delete/<?php echo $_smarty_tpl->tpl_vars['c']->value['id'];?>
">Delete</a></td>
          <td><?php echo $_smarty_tpl->tpl_vars['c']->value['name'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['c']->value['qty'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['c']->value['refund'];?>
</td>
        </tr>
      <?php }} ?>
    <?php }?>
  </tbody>
</table>
