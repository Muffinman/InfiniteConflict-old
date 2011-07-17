<?php /* Smarty version Smarty-3.0.7, created on 2011-07-16 20:09:19
         compiled from "application/views/resources/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15019869774e21e1df87d239-12966010%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '82d85804c453e97341bf796241cae70d315ffa19' => 
    array (
      0 => 'application/views/resources/index.tpl',
      1 => 1310684387,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15019869774e21e1df87d239-12966010',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Resource Editor</h1>

<p><a href="/">Back to home</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Resource Name</th>
      <th>Hit Points</th>
      <th>Attack Points</th>
      <th>Creatable</th>
      <th>Creation Time</th>
      <th>Interest Rate</th>
      <th>Requires Storage</th>
      <th>Global</th>
    </tr>
  </thead>
  <tbody>

    <tr>
      <td colspan="11"><a href="/resources/add">Add</a></td>
    </tr>

    <?php if ($_smarty_tpl->getVariable('res')->value){?>
      <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('res')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
?>
        <tr>
          <td><a href="/resources/edit/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
">Edit</a></td>
          <td><a href="/resources/delete/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
">Delete</a></td>
          <td><?php if ($_smarty_tpl->tpl_vars['r']->value['creatable']){?><a href="/resources/conversion/<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
">Conversion</a><?php }?></td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['name'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['hp'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['attack'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['creatable'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['turns'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['interest'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['req_storage'];?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['r']->value['global'];?>
</td>
        </tr>
      <?php }} ?>
    <?php }?>
  </tbody>
</table>
