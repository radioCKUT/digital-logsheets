<?php /* Smarty version 3.1.22-dev/21, created on 2015-06-07 18:09:12
         compiled from "/home/ubuntu/workspace/dff/dff.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1948455335557488c8bec860_63296255%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6db9443cc05e2e77eaf5ddadbc6b4fa8af56470f' => 
    array (
      0 => '/home/ubuntu/workspace/dff/dff.tpl',
      1 => 1433700552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1948455335557488c8bec860_63296255',
  'has_nocache_code' => false,
  'version' => '3.1.22-dev/21',
  'unifunc' => 'content_557488c8bf8a24_24549719',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_557488c8bf8a24_24549719')) {
function content_557488c8bf8a24_24549719 ($_smarty_tpl) {
?>
<?php
$_smarty_tpl->properties['nocache_hash'] = '1948455335557488c8bec860_63296255';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dynamic Form Fields Test</title>
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            th, td {
                padding: 5px;
                text-align: left;
            }
        </style>
        <?php echo '<script'; ?>
>
            function addRow() {
                var table = document.getElementById("tracks");
                
                var row = table.insertRow(0);
                
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                
                cell1.innerHTML = "New Artist";
                cell2.innerHTML = "Song";
                cell3.innerHTML = "Album";
            }
        <?php echo '</script'; ?>
>
    </head>
    <body>
        <table id="tracks">
            <tr>
                <th>Artist</th>
                <th>Song</th>
                <th>Album</th>
            </tr>
            <tr>
                <td>Deadbeat</td>
                <td>Horns of Jericho</td>
                <td>Eight</td>
            </tr>
            <tr>
                <td>Michael Jackson</td>
                <td>Thriller</td>
                <td>Thriller</td>
            </tr>
            <tr>
                <td>Tipper</td>
                <td>Seamless Unspeakable</td>
                <td>Surrounded</td>
            </tr>
        </table>
        <button onClick="addRow()">Add a Row</button>
    </body>
</html><?php }
}
?>