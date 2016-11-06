<?php /* Smarty version 3.1.27, created on 2016-10-06 09:24:29
         compiled from "C:\xampp\digital-logsheets-res\templates\index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:3158457f5fc2d486df0_93711269%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '18adda4c16f1ab1afa1182fb0de678f05db01e02' => 
    array (
      0 => 'C:\\xampp\\digital-logsheets-res\\templates\\index.tpl',
      1 => 1475444873,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3158457f5fc2d486df0_93711269',
  'variables' => 
  array (
    'programs' => 0,
    'episodes' => 0,
    'episode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57f5fc2d69d0f0_55609677',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57f5fc2d69d0f0_55609677')) {
function content_57f5fc2d69d0f0_55609677 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '3158457f5fc2d486df0_93711269';
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
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
    <link href="css/select2-bootstrap.css" rel="stylesheet"/>

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

<div class="container-fluid">
    <a href="new-logsheet.php">New Logsheet</a>

    <br/>
    <br/>

    <div class="row">
        <div class="col-sm-4">
            <label for="program" class="control-label">Program:</label>
            <select class="form-control program" name="program" id="program" multiple="multiple"></select>
        </div>

        <div class="col-sm-4">
            <label for="startDateFilter" class="control-label">Start:</label>
            <input type="date" id="startDateFilter" onchange="updateFilteredLogsheetList()">
        </div>

        <div class="col-sm-4">
            <label for="endDateFilter" class="control-label">End:</label>
            <input type="date" id="endDateFilter" onchange="updateFilteredLogsheetList()">
        </div>



    </div>

    <div class="logsheets">
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