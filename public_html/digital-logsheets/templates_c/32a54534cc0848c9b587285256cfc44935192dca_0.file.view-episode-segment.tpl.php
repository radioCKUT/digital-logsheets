<?php /* Smarty version 3.1.27, created on 2016-10-13 07:23:11
         compiled from "C:\xampp\digital-logsheets-res\templates\view-episode-segment.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:2175157ff1a3f81f677_58704366%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '32a54534cc0848c9b587285256cfc44935192dca' => 
    array (
      0 => 'C:\\xampp\\digital-logsheets-res\\templates\\view-episode-segment.tpl',
      1 => 1476336131,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2175157ff1a3f81f677_58704366',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57ff1a3f871a50_77779860',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57ff1a3f871a50_77779860')) {
function content_57ff1a3f871a50_77779860 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '2175157ff1a3f81f677_58704366';
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
    <h1>View Episode</h1>

    <?php echo $_smarty_tpl->getSubTemplate ('../../digital-logsheets-res/templates/segment-template.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


</div>


</body><?php }
}
?>