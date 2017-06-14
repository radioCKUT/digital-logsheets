<?php /* Smarty version 3.1.27, created on 2017-06-06 20:42:38
         compiled from "/var/www/digital-logsheets-res/templates/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1000624683593713be7eca09_97605991%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c81a9909e4ba9365bc565a8e839597004079dd2e' => 
    array (
      0 => '/var/www/digital-logsheets-res/templates/index.tpl',
      1 => 1496792361,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1000624683593713be7eca09_97605991',
  'variables' => 
  array (
    'programs' => 0,
    'episodes' => 0,
    'program_id' => 0,
    'episode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_593713be8f4be1_08526625',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_593713be8f4be1_08526625')) {
function content_593713be8f4be1_08526625 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1000624683593713be7eca09_97605991';
?>
<!DOCTYPE html>
<html>
<head>
    <title>
        Logsheets Retrieval
    </title>
    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="http://getbootstrap.com/dist/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" rel="stylesheet"/>

    <!-- jQuery -->
    <?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-1.11.3.min.js"><?php echo '</script'; ?>
>

    <!-- Boostrap JS -->
    <?php echo '<script'; ?>
 src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"><?php echo '</script'; ?>
>

    <!-- Select2 -->
    <?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"><?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
 src="js/filterLogsheetList.js"><?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"><?php echo '</script'; ?>
>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

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