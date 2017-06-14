<?php /* Smarty version 3.1.27, created on 2017-06-14 11:33:09
         compiled from "/var/www/digital-logsheets-res/templates/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:88708156359411ef5adfac3_81072447%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c81a9909e4ba9365bc565a8e839597004079dd2e' => 
    array (
      0 => '/var/www/digital-logsheets-res/templates/index.tpl',
      1 => 1497404295,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '88708156359411ef5adfac3_81072447',
  'variables' => 
  array (
    'programs' => 0,
    'episodes' => 0,
    'program_id' => 0,
    'episode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_59411ef5cb5504_28536472',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_59411ef5cb5504_28536472')) {
function content_59411ef5cb5504_28536472 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '88708156359411ef5adfac3_81072447';
?>
<!DOCTYPE html>
<html>
<head>
    <title>
        Logsheets Retrieval
    </title>
    <?php echo $_smarty_tpl->getSubTemplate ('./header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

    <?php echo $_smarty_tpl->getSubTemplate ('./datetime-picker.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

    <?php echo $_smarty_tpl->getSubTemplate ('./select2.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>



    <?php echo '<script'; ?>
 src="js/filterLogsheetList.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript">

        function init() {
            var data = <?php echo $_smarty_tpl->tpl_vars['programs']->value;?>
;
            var $programSelect = $(".program");

            $programSelect.select2({
                data: data
            });

            $programSelect.on("change", function (e) {
                updateFilteredLogsheetList();
            } );
        }

        function updateFilteredLogsheetList() {
            var programNameFilterList = $(".program").select2('data').map(function (index, element) {
                console.log(index.text);
                return index.text;
            });

            var startDateFilter = $( "#startDateFilter" ).val();
            var endDateFilter = $( "#endDateFilter" ).val();

            var episodes = <?php echo json_encode($_smarty_tpl->tpl_vars['episodes']->value);?>
;

            filterLogsheetList(episodes, programNameFilterList, startDateFilter, endDateFilter);
        }

    <?php echo '</script'; ?>
>
</head>
<body onload="init()">
<div class='container-fluid'>
    <?php if ($_smarty_tpl->tpl_vars['program_id']->value != null) {?>

        <div class="row">
            <div class="col-sm-2">
                <a href="new-logsheet.php?program_id=<?php echo $_smarty_tpl->tpl_vars['program_id']->value;?>
">New Logsheet</a>
            </div>
        </div>

    <?php } else { ?>
        <div class="row">
            <div class="col-sm-2">
                <a href="new-logsheet.php">New Logsheet</a>
            </div>
        </div>

    <?php }?>

    <div class="form-group">
        <div class="col-sm-2 col-sm-offset-2">
        </div>
    </div>

    <br/>
    <br/>
    <div class="row">
        <div class="form-group">
            <?php if ($_smarty_tpl->tpl_vars['program_id']->value != null) {?>
                <div class="col-sm-4 " style="display: none">
                    <label for="program" class="control-label">Program:</label>
                    <select class="form-control program" name="program" id="program" multiple="multiple"></select>
                </div>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['program_id']->value == null) {?>
                <div class="col-sm-4">
                    <label for="program" class="control-label">Program:</label>
                    <select class="form-control program" name="program" id="program" multiple="multiple"></select>
                </div>
            <?php }?>

            <div class="col-sm-4">
                <label for="startDateFilter" class="control-label">Start:</label>
                <input type="date" id="startDateFilter" onchange="updateFilteredLogsheetList()">
            </div>
            <div class="col-sm-4">
                <label for="endDateFilter" class="control-label">End:</label>
                <input type="date" id="endDateFilter" onchange="updateFilteredLogsheetList()">
            </div>
        </div>
    </div>

    <div class="logsheets">
        <br/>
        <?php
$_from = $_smarty_tpl->tpl_vars['episodes']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['episode'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['episode']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['episode']->value) {
$_smarty_tpl->tpl_vars['episode']->_loop = true;
$foreach_episode_Sav = $_smarty_tpl->tpl_vars['episode'];
?>
            <a href="view-episode-logsheet.php?episode_id=<?php echo $_smarty_tpl->tpl_vars['episode']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['episode']->value['program'];?>
 - <?php echo $_smarty_tpl->tpl_vars['episode']->value['startDate'];?>
</a> <br />
        <?php
$_smarty_tpl->tpl_vars['episode'] = $foreach_episode_Sav;
}
?>
    </div>
</div>

</body>
</html>
    <?php }
}
?>