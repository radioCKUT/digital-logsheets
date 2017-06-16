<?php /* Smarty version 3.1.27, created on 2017-06-15 16:21:31
         compiled from "/var/www/digital-logsheets-res/templates/view-episode-logsheet.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:6019712855942b40b62b812_52962388%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0e0de60d911beb15bae7f08d48eee80ed0b3996b' => 
    array (
      0 => '/var/www/digital-logsheets-res/templates/view-episode-logsheet.tpl',
      1 => 1497404295,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6019712855942b40b62b812_52962388',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5942b40b6b0aa4_72919389',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5942b40b6b0aa4_72919389')) {
function content_5942b40b6b0aa4_72919389 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '6019712855942b40b62b812_52962388';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Episode</title>
    <?php echo $_smarty_tpl->getSubTemplate ('./header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

    
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