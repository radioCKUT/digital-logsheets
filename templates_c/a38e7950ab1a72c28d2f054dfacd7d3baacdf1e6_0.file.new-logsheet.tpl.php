<?php /* Smarty version 3.1.27, created on 2015-10-10 23:39:54
         compiled from "/home/ubuntu/workspace/new-logsheet.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:9860723485619a1cad19321_44179373%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a38e7950ab1a72c28d2f054dfacd7d3baacdf1e6' => 
    array (
      0 => '/home/ubuntu/workspace/new-logsheet.tpl',
      1 => 1444447126,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9860723485619a1cad19321_44179373',
  'variables' => 
  array (
    'programs' => 0,
    'categories' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5619a1cad9b579_41154324',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5619a1cad9b579_41154324')) {
function content_5619a1cad9b579_41154324 ($_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once '/home/ubuntu/workspace/smarty/libs/plugins/function.html_options.php';

$_smarty_tpl->properties['nocache_hash'] = '9860723485619a1cad19321_44179373';
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
        <form id="logsheet" action="save-logsheet.php" method="post">
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