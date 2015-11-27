<?php /* Smarty version 3.1.22-dev/21, created on 2015-07-09 18:55:52
         compiled from "/home/ubuntu/workspace/submit_genre.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1138206320559ec3b8d69715_12732793%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '56c67c930d1724ee7af612978f255d4945b61b52' => 
    array (
      0 => '/home/ubuntu/workspace/submit_genre.tpl',
      1 => 1436468112,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1138206320559ec3b8d69715_12732793',
  'variables' => 
  array (
    'genres' => 0,
    'genre' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.22-dev/21',
  'unifunc' => 'content_559ec3b8e32ee6_36202288',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_559ec3b8e32ee6_36202288')) {
function content_559ec3b8e32ee6_36202288 ($_smarty_tpl) {
?>
<?php
$_smarty_tpl->properties['nocache_hash'] = '1138206320559ec3b8d69715_12732793';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Edit Genres</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        
        <!-- datetimepicker -->
        <link rel="stylesheet" href="/public_html/digital-logsheets/css/bootstrap-datetimepicker.css">
    </head>
    
    <body>
        <div class="container">
            <div class="row">
                <h1>
                    Current genres:
                </h1>
            </div>
            <div class="row">
                <ul>
                    <!--Fill in variables for each row from database-->
                    <?php
$_from = $_smarty_tpl->tpl_vars['genres']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['genre'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['genre']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['genre']->value) {
$_smarty_tpl->tpl_vars['genre']->_loop = true;
$foreachItemSav = $_smarty_tpl->tpl_vars['genre'];
?>
                    <li><?php echo $_smarty_tpl->tpl_vars['genre']->value['name'];?>
</li>
                    <?php
$_smarty_tpl->tpl_vars['genre'] = $foreachItemSav;
}
?>
                </ul>
            </div>
        </div>
        <div class="container">
            <form id="new-genre" role="form" action="saveGenre.php" method="post">
                <div class="row">
                    <div class="form-group">
                      <label for="genre">Name of New Genre:</label>
                      <input type="text" class="form-control" id="genre" name="genre">
                    </div>
                </div>
                <div class="row">
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
            </form>
        </div>

        <!-- jQuery -->
        <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"><?php echo '</script'; ?>
>
        
        <!-- Bootstrap -->
        <?php echo '<script'; ?>
 src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"><?php echo '</script'; ?>
>
        <?php echo '</script'; ?>
>
        
    </body>
</html><?php }
}
?>