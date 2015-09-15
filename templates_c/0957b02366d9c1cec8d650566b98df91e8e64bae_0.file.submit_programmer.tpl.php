<?php /* Smarty version 3.1.22-dev/21, created on 2015-07-27 23:20:34
         compiled from "/home/ubuntu/workspace/submit_programmer.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:26772400755b6bcc2c69e08_95016289%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0957b02366d9c1cec8d650566b98df91e8e64bae' => 
    array (
      0 => '/home/ubuntu/workspace/submit_programmer.tpl',
      1 => 1438039228,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26772400755b6bcc2c69e08_95016289',
  'has_nocache_code' => false,
  'version' => '3.1.22-dev/21',
  'unifunc' => 'content_55b6bcc2c71d03_41185860',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55b6bcc2c71d03_41185860')) {
function content_55b6bcc2c71d03_41185860 ($_smarty_tpl) {
?>
<?php
$_smarty_tpl->properties['nocache_hash'] = '26772400755b6bcc2c69e08_95016289';
?>
<!DOCTYPE html>
<html>
    <head>
        <title> </title>
    </head>
    <body>
        <form id="logsheet" action="saveProgrammer.php" method="post">
            <div>
                First Name: <input type="text" name="first_name"><br>
                Last Name: <input type="text" name="last_name"><br>
            </div>
            <input type="submit" value="Submit">
        </form>
    </body>
</html><?php }
}
?>