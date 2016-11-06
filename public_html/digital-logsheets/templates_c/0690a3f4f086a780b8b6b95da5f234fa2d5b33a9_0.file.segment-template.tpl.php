<?php /* Smarty version 3.1.27, created on 2016-10-21 02:47:51
         compiled from "C:\xampp\digital-logsheets-res\templates\segment-template.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:24969580965b7b70307_27438721%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0690a3f4f086a780b8b6b95da5f234fa2d5b33a9' => 
    array (
      0 => 'C:\\xampp\\digital-logsheets-res\\templates\\segment-template.tpl',
      1 => 1477010869,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '24969580965b7b70307_27438721',
  'variables' => 
  array (
    'segments' => 0,
    'segment' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_580965b7d233d5_68063107',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_580965b7d233d5_68063107')) {
function content_580965b7d233d5_68063107 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '24969580965b7b70307_27438721';
?>
<table class="table">
    <tr>
        <th>Start Time</th>
        <th colspan="3">Description of music (name, album, artist); spoken word</th>
    </tr>

    <?php
$_from = $_smarty_tpl->tpl_vars['segments']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['segment'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['segment']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['segment']->value) {
$_smarty_tpl->tpl_vars['segment']->_loop = true;
$foreach_segment_Sav = $_smarty_tpl->tpl_vars['segment'];
?>
        <tr>
            <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['startTime'];?>
</td>

            <?php ob_start();
echo $_smarty_tpl->tpl_vars['segment']->value['category'];
$_tmp1=ob_get_clean();
ob_start();
echo $_smarty_tpl->tpl_vars['segment']->value['category'];
$_tmp2=ob_get_clean();
if ($_tmp1 == 2 || $_tmp2 == 3) {?>
                <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['name'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['album'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['author'];?>
</td>
            <?php } else { ?>
                <td colspan="3"><?php echo $_smarty_tpl->tpl_vars['segment']->value['name'];?>
</td>
            <?php }?>
        </tr>
    <?php
$_smarty_tpl->tpl_vars['segment'] = $foreach_segment_Sav;
}
?>
</table><?php }
}
?>