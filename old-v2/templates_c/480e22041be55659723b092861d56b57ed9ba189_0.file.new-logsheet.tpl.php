<?php /* Smarty version 3.1.22-dev/21, created on 2015-09-16 03:10:54
         compiled from "/home/ubuntu/workspace/old-v2/new-logsheet.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:58144126855f8ddbe591028_75989963%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '480e22041be55659723b092861d56b57ed9ba189' => 
    array (
      0 => '/home/ubuntu/workspace/old-v2/new-logsheet.tpl',
      1 => 1442373049,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '58144126855f8ddbe591028_75989963',
  'variables' => 
  array (
    'programs' => 0,
    'categories' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.22-dev/21',
  'unifunc' => 'content_55f8ddbe5a2302_83132852',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55f8ddbe5a2302_83132852')) {
function content_55f8ddbe5a2302_83132852 ($_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once '/home/ubuntu/workspace/smarty/libs/plugins/function.html_options.php';
?>
<?php
$_smarty_tpl->properties['nocache_hash'] = '58144126855f8ddbe591028_75989963';
?>
<!DOCTYPE html>
<html>
    <head>
        <title> </title>
        
        <!-- Script for adding form fields -->
        <?php echo '<script'; ?>
 src="../js/dynamic_form.js"><?php echo '</script'; ?>
>
    </head>
    <body>
        <form id="logsheet" action="test.php" method="post">
            <div>
                First Name: <input type="text" name="first_name"><br />
                Last Name: <input type="text" name="last_name"><br />
                Program: <?php echo smarty_function_html_options(array('name'=>"program",'options'=>$_smarty_tpl->tpl_vars['programs']->value),$_smarty_tpl);?>
<br />
                <input type="checkbox" name="prerecord" value="prerecord">Pre-recorded<br />
                Start Time: <input type="datetime-local" name="start_time"><br />
                End Time: <input type="datetime-local" name="end_time"><br />
                Comment: <input type="text" name="comment"><br />
            </div>
            
            <hr>
            
            <div>
                Name: <input type="text" name="name[]">
                Author: <input type="text" name="author[]">
                Category: <?php echo smarty_function_html_options(array('name'=>"category[]",'options'=>$_smarty_tpl->tpl_vars['categories']->value),$_smarty_tpl);?>

                <a href="#" onClick="cloneRow(event)">add</a>
                <a href="#" onClick="removeRow(event)">remove</a>
                <br>
            </div>
            
            <input type="submit" value="Continue">
        </form>
    </body>
</html><?php }
}
?>