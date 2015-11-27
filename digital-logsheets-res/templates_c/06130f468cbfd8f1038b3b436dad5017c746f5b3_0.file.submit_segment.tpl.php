<?php /* Smarty version 3.1.22-dev/21, created on 2015-05-04 06:18:46
         compiled from "/home/ubuntu/workspace/submit_segment.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:161678830555470f461a1277_30219648%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '06130f468cbfd8f1038b3b436dad5017c746f5b3' => 
    array (
      0 => '/home/ubuntu/workspace/submit_segment.tpl',
      1 => 1430719438,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '161678830555470f461a1277_30219648',
  'variables' => 
  array (
    'id' => 0,
    'categories' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.22-dev/21',
  'unifunc' => 'content_55470f461df114_14450491',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55470f461df114_14450491')) {
function content_55470f461df114_14450491 ($_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once '/home/ubuntu/workspace/smarty/libs/plugins/function.html_options.php';
?>
<?php
$_smarty_tpl->properties['nocache_hash'] = '161678830555470f461a1277_30219648';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Submit a new segment</title>
    </head>
    
    <body>
        <form action="createSegment.php" method="GET">
            Title: <input type="text" name="name"><br>
            Artist: <input type="text" name="author"><br>
            Album: <input type="text" name="album"><br>
            <select name="category">
                <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['id']->value,'output'=>$_smarty_tpl->tpl_vars['categories']->value),$_smarty_tpl);?>

            </select><br>
            <input type="checkbox" name="can_can"> CC
            <input type="submit">
        </form>
    </body>
</html><?php }
}
?>