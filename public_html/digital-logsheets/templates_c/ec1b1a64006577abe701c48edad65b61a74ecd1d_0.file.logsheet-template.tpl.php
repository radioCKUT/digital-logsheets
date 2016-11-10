<?php /* Smarty version 3.1.27, created on 2016-10-12 09:24:43
         compiled from "C:\xampp\digital-logsheets-res\templates\logsheet-template.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:158757fde53bc30fe9_65948472%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ec1b1a64006577abe701c48edad65b61a74ecd1d' => 
    array (
      0 => 'C:\\xampp\\digital-logsheets-res\\templates\\logsheet-template.tpl',
      1 => 1475444873,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '158757fde53bc30fe9_65948472',
  'variables' => 
  array (
    'episode' => 0,
    'segments' => 0,
    'segment' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57fde53bd60330_11768971',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57fde53bd60330_11768971')) {
function content_57fde53bd60330_11768971 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '158757fde53bc30fe9_65948472';
?>
Show Name: <?php echo $_smarty_tpl->tpl_vars['episode']->value['program'];?>
 <br/>
Programmer(s): <br/>
Day and Date: <?php echo $_smarty_tpl->tpl_vars['episode']->value['startDate'];?>
 <br/>
Time Started: <?php echo $_smarty_tpl->tpl_vars['episode']->value['startTime'];?>
  Time Ended: <?php echo $_smarty_tpl->tpl_vars['episode']->value['endTime'];?>
 <br/>
Pre-recorded? <?php echo $_smarty_tpl->tpl_vars['episode']->value['prerecorded'];?>
  Date? <?php echo $_smarty_tpl->tpl_vars['episode']->value['prerecordDate'];?>
 <br/> <br/>

<table class="table">
    <tr>
        <th>Time</th>
        <th>Duration</th>
        <th colspan="3">Description of music (artist, album, song); spoken word, or ads/promotion</th>
        <th>Category</th>
        <th>CC</th>
        <th>NR</th>
        <th>FR</th>
    </tr>

    <?php
$_from = $_smarty_tpl->tpl_vars['segments']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['segment'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['segment']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['segment']->value) {
$_smarty_tpl->tpl_vars['segment']->_loop = true;
$foreach_segment_Sav = $_smarty_tpl->tpl_vars['segment'];
?>
        <tr>
            <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['startTime'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['duration'];?>
</td>

            <?php ob_start();
echo $_smarty_tpl->tpl_vars['segment']->value['category'];
$_tmp1=ob_get_clean();
ob_start();
echo $_smarty_tpl->tpl_vars['segment']->value['category'];
$_tmp2=ob_get_clean();
if ($_tmp1 == 2 || $_tmp2 == 3) {?>}
                <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['name'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['album'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['author'];?>
</td>
            <?php ob_start();
echo $_smarty_tpl->tpl_vars['segment']->value['category'];

$_tmp3=ob_get_clean();

} elseif ($_tmp3 == 5) {?>
                <td colspan="3"><?php echo $_smarty_tpl->tpl_vars['segment']->value['adNumber'];?>
</td>
            <?php } else { ?>
                <td colspan="3"><?php echo $_smarty_tpl->tpl_vars['segment']->value['name'];?>
</td>
            <?php }?>

            <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['category'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['canCon'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['newRelease'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['frenchVocalMusic'];?>
</td>
        </tr>
    <?php
$_smarty_tpl->tpl_vars['segment'] = $foreach_segment_Sav;
}
?>
</table><?php }
}
?>