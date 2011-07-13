<?php /* Smarty version Smarty-3.0.7, created on 2011-07-12 20:47:40
         compiled from "application/views/resources/conversion_delete.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17840673844e1ca4dc95e6d8-37349286%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3b943820dcf713cd0addc34b221006bb9f931f1d' => 
    array (
      0 => 'application/views/resources/conversion_delete.tpl',
      1 => 1310500056,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17840673844e1ca4dc95e6d8-37349286',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Deleting <?php echo $_smarty_tpl->getVariable('resource')->value['name'];?>
 conversion cost</h1>

<?php if ($_smarty_tpl->getVariable('messages')->value){?>
  <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('messages')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
 $_smarty_tpl->tpl_vars['type']->value = $_smarty_tpl->tpl_vars['m']->key;
?>
    <div class="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
">
      <?php  $_smarty_tpl->tpl_vars['message'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['m']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['message']->key => $_smarty_tpl->tpl_vars['message']->value){
?>
        <p><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</p>
      <?php }} ?>
    </div>
  <?php }} ?>
<?php }?>

<p><a href="/resources/<?php echo $_smarty_tpl->getVariable('resource')->value['id'];?>
/conversion">Click here</a> to return to the conversion list.</p>
