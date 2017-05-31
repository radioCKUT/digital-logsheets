<?php /* Smarty version 3.1.27, created on 2017-05-24 14:40:14
         compiled from "/var/www/digital-logsheets-res/templates/view-episode-logsheet.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:34277615559259b4ea7b5c0_63227560%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0e0de60d911beb15bae7f08d48eee80ed0b3996b' => 
    array (
      0 => '/var/www/digital-logsheets-res/templates/view-episode-logsheet.tpl',
      1 => 1495323600,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '34277615559259b4ea7b5c0_63227560',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_59259b4eb17289_73474368',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_59259b4eb17289_73474368')) {
function content_59259b4eb17289_73474368 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '34277615559259b4ea7b5c0_63227560';
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

    <?php echo $_smarty_tpl->getSubTemplate ('./logsheet-template.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


</div>


</body><?php }
}
?>