<?php /* Smarty version 3.1.22-dev/21, created on 2015-09-14 22:49:23
         compiled from "/home/ubuntu/workspace/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:145902531555f74ef34d1c50_07853486%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2369e76ef1a04fb07bc20660e40a249d967bd95a' => 
    array (
      0 => '/home/ubuntu/workspace/index.tpl',
      1 => 1442270958,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '145902531555f74ef34d1c50_07853486',
  'variables' => 
  array (
    'episodes' => 0,
    'episode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.22-dev/21',
  'unifunc' => 'content_55f74ef34fb5a8_21280817',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55f74ef34fb5a8_21280817')) {
function content_55f74ef34fb5a8_21280817 ($_smarty_tpl) {
?>
<?php
$_smarty_tpl->properties['nocache_hash'] = '145902531555f74ef34d1c50_07853486';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Page Title
        </title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <?php
$_from = $_smarty_tpl->tpl_vars['episodes']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['episode'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['episode']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['episode']->value) {
$_smarty_tpl->tpl_vars['episode']->_loop = true;
$foreachItemSav = $_smarty_tpl->tpl_vars['episode'];
?>
            <h2><?php echo $_smarty_tpl->tpl_vars['episode']->value['start_time'];?>
</h2>
            <h3>[<?php echo $_smarty_tpl->tpl_vars['episode']->value['start_time'];?>
 - <?php echo $_smarty_tpl->tpl_vars['episode']->value['end_time'];?>
] <?php echo $_smarty_tpl->tpl_vars['episode']->value['id'];?>
</h3>
            <table>
                
            </table>
        <?php
$_smarty_tpl->tpl_vars['episode'] = $foreachItemSav;
}
?>
    </body>
</html>
    <?php }
}
?>