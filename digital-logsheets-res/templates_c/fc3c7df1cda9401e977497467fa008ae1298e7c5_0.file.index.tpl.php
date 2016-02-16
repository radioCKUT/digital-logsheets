<?php /* Smarty version 3.1.27, created on 2015-10-10 23:35:49
         compiled from "/home/ubuntu/workspace/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:10192749525619a0d5743fd8_91911854%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fc3c7df1cda9401e977497467fa008ae1298e7c5' => 
    array (
      0 => '/home/ubuntu/workspace/index.tpl',
      1 => 1444447126,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10192749525619a0d5743fd8_91911854',
  'variables' => 
  array (
    'episodes' => 0,
    'episode' => 0,
    'segment' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5619a0d5858280_71280065',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5619a0d5858280_71280065')) {
function content_5619a0d5858280_71280065 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '10192749525619a0d5743fd8_91911854';
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
$foreach_episode_Sav = $_smarty_tpl->tpl_vars['episode'];
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
$foreach_segment_Sav = $_smarty_tpl->tpl_vars['segment'];
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
$_smarty_tpl->tpl_vars['segment'] = $foreach_segment_Sav;
}
?>
            </table>
        <?php
$_smarty_tpl->tpl_vars['episode'] = $foreach_episode_Sav;
}
?>
    </body>
</html>
    <?php }
}
?>