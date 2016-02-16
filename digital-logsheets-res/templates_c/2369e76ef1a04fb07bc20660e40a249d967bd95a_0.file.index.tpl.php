<?php /* Smarty version 3.1.22-dev/21, created on 2015-09-16 20:21:46
         compiled from "/home/ubuntu/workspace/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:45962054255f9cf5a7b9ce8_75176101%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2369e76ef1a04fb07bc20660e40a249d967bd95a' => 
    array (
      0 => '/home/ubuntu/workspace/index.tpl',
      1 => 1442434900,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '45962054255f9cf5a7b9ce8_75176101',
  'variables' => 
  array (
    'episodes' => 0,
    'episode' => 0,
    'segment' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.22-dev/21',
  'unifunc' => 'content_55f9cf5a81a191_70679296',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55f9cf5a81a191_70679296')) {
function content_55f9cf5a81a191_70679296 ($_smarty_tpl) {
?>
<?php
$_smarty_tpl->properties['nocache_hash'] = '45962054255f9cf5a7b9ce8_75176101';
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
        <a href="new-logsheet.php">New logsheet</a>
        
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
            <h2><?php echo $_smarty_tpl->tpl_vars['episode']->value['program_name'];?>
</h2>
            <h3><?php echo $_smarty_tpl->tpl_vars['episode']->value['start_date'];?>
</h3>
            <table>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Album</th>
            </tr>
            <?php
$_from = $_smarty_tpl->tpl_vars['episode']->value['playlist'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['segment'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['segment']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['segment']->value) {
$_smarty_tpl->tpl_vars['segment']->_loop = true;
$foreachItemSav = $_smarty_tpl->tpl_vars['segment'];
?>
                <tr>
                    <th><?php echo $_smarty_tpl->tpl_vars['segment']->value['name'];?>
</th>
                    <th><?php echo $_smarty_tpl->tpl_vars['segment']->value['author'];?>
</th>
                    <th><?php echo $_smarty_tpl->tpl_vars['segment']->value['album'];?>
</th>
                </tr>
            <?php
$_smarty_tpl->tpl_vars['segment'] = $foreachItemSav;
}
?>
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