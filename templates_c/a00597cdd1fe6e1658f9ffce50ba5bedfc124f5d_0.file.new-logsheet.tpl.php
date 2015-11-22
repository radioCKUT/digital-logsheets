<?php /* Smarty version 3.1.27, created on 2015-11-22 15:17:16
         compiled from "/Applications/MAMP/htdocs/templates/new-logsheet.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:7553127955651ce6cb27d64_14796879%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a00597cdd1fe6e1658f9ffce50ba5bedfc124f5d' => 
    array (
      0 => '/Applications/MAMP/htdocs/templates/new-logsheet.tpl',
      1 => 1448201827,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7553127955651ce6cb27d64_14796879',
  'variables' => 
  array (
    'programs' => 0,
    'categories' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5651ce6cb90dc9_68552194',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5651ce6cb90dc9_68552194')) {
function content_5651ce6cb90dc9_68552194 ($_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once '/Applications/MAMP/htdocs/smarty/libs/plugins/function.html_options.php';

$_smarty_tpl->properties['nocache_hash'] = '7553127955651ce6cb27d64_14796879';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>New Logsheet</title>

        <!-- Bootstrap core CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap theme -->
        <link href="http://getbootstrap.com/dist/css/bootstrap-theme.min.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <?php echo '<script'; ?>
 src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"><?php echo '</script'; ?>
>
        <![endif]-->

        <!-- Script for adding form fields -->
        <?php echo '<script'; ?>
 src="js/dynamic_form.js"><?php echo '</script'; ?>
>
    </head>
    <body>
        <form id="logsheet" role="form" action="../save-logsheet.php" method="post">
            <div>
                First Name: <input type="text" name="first_name"><br />
                Last Name: <input type="text" name="last_name"><br />
                Program: <?php echo smarty_function_html_options(array('name'=>"program",'options'=>$_smarty_tpl->tpl_vars['programs']->value),$_smarty_tpl);?>
<br />
                <input type="checkbox" name="prerecord" value="prerecord">Pre-recorded &nbsp; Pre-recorded Date: <input type="date" name="prerecord_date"><br />
                Start Time: <input type="datetime-local" name="start_time"><br />
                End Time: <input type="datetime-local" name="end_time"><br />
                Comment: <input type="text" name="comment"><br />
            </div>
            
            <hr>
            
            <div>
                Time: <input type="datetime-local" name="segment_time[]">
                Duration: <input type="time" name="segment_duration[]">
                Name: <input type="text" name="name[]">
                Author: <input type="text" name="author[]">
                Category: <?php echo smarty_function_html_options(array('name'=>"category[]",'options'=>$_smarty_tpl->tpl_vars['categories']->value),$_smarty_tpl);?>

                CanCon: <input type="checkbox" name="can_con[]" value="can_con">
                New Release: <input type="checkbox" name="new_release[]" value="new_release">
                French Vocal Music: <input type="checkbox" name="french_vocal_music[]" value="french_vocal_music">
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