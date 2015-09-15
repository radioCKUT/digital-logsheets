<?php /* Smarty version 3.1.22-dev/21, created on 2015-07-09 16:02:25
         compiled from "/home/ubuntu/workspace/submit_playlist.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:642348273559e9b11afef16_33959397%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4927d65f316f50c79cd87f10069e029d8372d509' => 
    array (
      0 => '/home/ubuntu/workspace/submit_playlist.tpl',
      1 => 1433916640,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '642348273559e9b11afef16_33959397',
  'variables' => 
  array (
    'segments' => 0,
    'segment' => 0,
    'categories' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.22-dev/21',
  'unifunc' => 'content_559e9b11ba4449_95632045',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_559e9b11ba4449_95632045')) {
function content_559e9b11ba4449_95632045 ($_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once '/home/ubuntu/workspace/smarty/libs/plugins/function.html_options.php';
?>
<?php
$_smarty_tpl->properties['nocache_hash'] = '642348273559e9b11afef16_33959397';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Submit a playlist</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        
        <!-- Script for adding form fields -->
        <?php echo '<script'; ?>
 src="js/dynamic_form.js"><?php echo '</script'; ?>
>
    </head>
    
    <body>
        <div class="container">
            <h2>Current segments</h2>
            <p>The existing segments in the database</p>    
            
            <table class="table table-condensed">
                
                <!--Table headers-->
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Artist</th>
                    </tr>
                </thead>
                
                <!--Table body-->
                <tbody>
                    <!--Fill in variables for each row from database-->
                    <?php
$_from = $_smarty_tpl->tpl_vars['segments']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['segment'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['segment']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['segment']->value) {
$_smarty_tpl->tpl_vars['segment']->_loop = true;
$foreachItemSav = $_smarty_tpl->tpl_vars['segment'];
?>
                    <tr><td><?php echo $_smarty_tpl->tpl_vars['segment']->value['id'];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['segment']->value['name'];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['segment']->value['author'];?>
</td></tr>
                    <?php
$_smarty_tpl->tpl_vars['segment'] = $foreachItemSav;
}
?>
                </tbody>
                
            </table>
        
            <!--This needs to be dynamic-->
            <form id="logsheet" role="form" action="savePlaylist.php" method="POST">
                
                <div class="row form-inline">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Segment Title" name="name[]">
                    </div>
                    
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Artist/Author" name="author[]">
                    </div>
                    
                    <div class="form-group category-select">
                        <?php echo smarty_function_html_options(array('class'=>"form-control",'name'=>"category[]",'options'=>$_smarty_tpl->tpl_vars['categories']->value),$_smarty_tpl);?>

                    </div>
            
                    <button type="button" class="btn btn-default" onclick="cloneRow()" style="white-space: normal">
                         <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </div>
                
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
            
        </div><!--end bootstrap container-->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"><?php echo '</script'; ?>
>
    </body>
</html><?php }
}
?>