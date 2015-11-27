<?php /* Smarty version 3.1.22-dev/21, created on 2015-07-27 21:05:02
         compiled from "/home/ubuntu/workspace/new-playlist.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:43242121955b69cfece9cf8_62756141%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0e92a2231c9c0096b84085f84e192e6393a20d46' => 
    array (
      0 => '/home/ubuntu/workspace/new-playlist.tpl',
      1 => 1438031092,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '43242121955b69cfece9cf8_62756141',
  'variables' => 
  array (
    'categories' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.22-dev/21',
  'unifunc' => 'content_55b69cfecf9e77_09816480',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55b69cfecf9e77_09816480')) {
function content_55b69cfecf9e77_09816480 ($_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once '/home/ubuntu/workspace/smarty/libs/plugins/function.html_options.php';
?>
<?php
$_smarty_tpl->properties['nocache_hash'] = '43242121955b69cfece9cf8_62756141';
?>
<!DOCTYPE html>
<html>
    <head>
        <title> </title>
        
        <!-- Script for adding form fields -->
        <?php echo '<script'; ?>
 src="js/dynamic_form.js"><?php echo '</script'; ?>
>
    </head>
    <body>
        <form id="logsheet" action="savePlaylist.php" method="post" autocomplete="on">
            <div>
                Name: <input type="text" name="name[]">
                Author: <input type="text" name="author[]">
                Category: <?php echo smarty_function_html_options(array('name'=>"category[]",'options'=>$_smarty_tpl->tpl_vars['categories']->value),$_smarty_tpl);?>

                <a href="#" onClick="cloneRow(event)">add</a>
                <a href="#" onClick="removeRow(event)">remove</a>
                <br>
            </div>
            <input type="submit" value="submit"/>
        </form>
    </body>
</html><?php }
}
?>