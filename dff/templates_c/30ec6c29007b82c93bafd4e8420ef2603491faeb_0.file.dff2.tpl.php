<?php /* Smarty version 3.1.22-dev/21, created on 2015-06-07 19:23:59
         compiled from "/home/ubuntu/workspace/dff/dff2.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:93100324455749a4f46f6b1_70973338%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '30ec6c29007b82c93bafd4e8420ef2603491faeb' => 
    array (
      0 => '/home/ubuntu/workspace/dff/dff2.tpl',
      1 => 1433705035,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '93100324455749a4f46f6b1_70973338',
  'has_nocache_code' => false,
  'version' => '3.1.22-dev/21',
  'unifunc' => 'content_55749a4f47ca47_06340936',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55749a4f47ca47_06340936')) {
function content_55749a4f47ca47_06340936 ($_smarty_tpl) {
?>
<?php
$_smarty_tpl->properties['nocache_hash'] = '93100324455749a4f46f6b1_70973338';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dynamic Form Fields Test</title>
       
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <?php echo '<script'; ?>
 src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
>
            function addRow() {
                //get the form to add the elements
                var form = document.getElementById("tracks");
                
                //add a space between the element
                var br = document.createElement("br");
                form.appendChild(br);
                
                //create elements to add
                var formgroup = document.createElement("div");
                formgroup.className = "form-group";
                
                var input1 = document.createElement("input");
                input1.className="form-control";
                input1.type = "text";
                input1.name = "artist[]";
                
                var input2 = document.createElement("input");
                input2.className="form-control";
                input2.type = "text";
                input2.name = "song[]";
                
                form.appendChild(formgroup);
                formgroup.appendChild(input1);
                form.appendChild(formgroup);
                formgroup.appendChild(input2);
            }
        <?php echo '</script'; ?>
>
    </head>
    <body>
        <div class="container">
            <form class="form-inline" role="form" id="tracks" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>
">
                <div class="form-group">
                    <input class="form-control" type="text" name="artist[]">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="song[]">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
                <button onClick="addRow()"><span class="glyphicon glyphicon-plus"></span></button>
                <br />
        </div>
    </body>
</html><?php }
}
?>