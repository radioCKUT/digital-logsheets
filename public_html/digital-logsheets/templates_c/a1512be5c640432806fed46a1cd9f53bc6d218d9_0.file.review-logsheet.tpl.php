<?php /* Smarty version 3.1.27, created on 2016-10-12 09:24:43
         compiled from "C:\xampp\digital-logsheets-res\templates\review-logsheet.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:2704257fde53b955f88_56698452%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a1512be5c640432806fed46a1cd9f53bc6d218d9' => 
    array (
      0 => 'C:\\xampp\\digital-logsheets-res\\templates\\review-logsheet.tpl',
      1 => 1475444873,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2704257fde53b955f88_56698452',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57fde53bb88c30_68022132',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57fde53bb88c30_68022132')) {
function content_57fde53bb88c30_68022132 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '2704257fde53b955f88_56698452';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Logsheet</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="http://getbootstrap.com/dist/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <?php echo '<script'; ?>
 src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"><?php echo '</script'; ?>
>
    <![endif]-->

    <!-- jQuery -->
    <?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-1.11.3.min.js"><?php echo '</script'; ?>
>

    <!-- Boostrap JS -->
    <?php echo '<script'; ?>
 src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"><?php echo '</script'; ?>
>

</head>
<body>

<div class="container-fluid">
    <h1>Review Submission</h1>

    <?php echo $_smarty_tpl->getSubTemplate ('../../digital-logsheets-res/templates/logsheet-template.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


    <form action="save-submission.php">
        <input type="submit"/>
    </form>

</div>


</body><?php }
}
?>