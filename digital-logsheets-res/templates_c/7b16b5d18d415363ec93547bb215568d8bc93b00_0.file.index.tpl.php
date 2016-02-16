<?php /* Smarty version 3.1.27, created on 2015-11-15 23:26:23
         compiled from "/Applications/MAMP/htdocs/templates/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:13923666415649068f262cb7_70665063%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b16b5d18d415363ec93547bb215568d8bc93b00' => 
    array (
      0 => '/Applications/MAMP/htdocs/templates/index.tpl',
      1 => 1447626380,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13923666415649068f262cb7_70665063',
  'variables' => 
  array (
    'episodes' => 0,
    'episode' => 0,
    'segment' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5649068f2e0ff1_60021034',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5649068f2e0ff1_60021034')) {
function content_5649068f2e0ff1_60021034 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '13923666415649068f262cb7_70665063';
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
        <a href="../public_html/digital-logsheets/new-logsheet.php">New logsheet</a>
        
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