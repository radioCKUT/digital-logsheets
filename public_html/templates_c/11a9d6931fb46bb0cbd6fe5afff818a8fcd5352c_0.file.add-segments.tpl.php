<?php /* Smarty version 3.1.27, created on 2017-06-16 13:53:01
         compiled from "/var/www/digital-logsheets-res/templates/add-segments.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1101098075943e2bd0a7ec0_12426519%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '11a9d6931fb46bb0cbd6fe5afff818a8fcd5352c' => 
    array (
      0 => '/var/www/digital-logsheets-res/templates/add-segments.tpl',
      1 => 1497404295,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1101098075943e2bd0a7ec0_12426519',
  'variables' => 
  array (
    'episode' => 0,
    'programId' => 0,
    'formErrors' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5943e2bd227d54_79662779',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5943e2bd227d54_79662779')) {
function content_5943e2bd227d54_79662779 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1101098075943e2bd0a7ec0_12426519';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>New Logsheet</title>

    <?php echo $_smarty_tpl->getSubTemplate ('./header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

    <?php echo $_smarty_tpl->getSubTemplate ('./datetime-picker.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


    <?php echo '<script'; ?>
 type="text/javascript">
        function getEpisodeStartTime() {
            return <?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['startTime']);?>
;
        }
    <?php echo '</script'; ?>
>


    <?php echo '<script'; ?>
 type="text/javascript" src="js/validation/markErrors.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/validation/segmentValidation.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/validation/playlistValidation.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/deleteSegment.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/editSegment.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/ui/segmentOptionsMenu.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/saveReceiveSegments.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/ui/categoryButton.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/init/add-segments.js"><?php echo '</script'; ?>
>
</head>


<body onload="init('<?php echo $_smarty_tpl->tpl_vars['episode']->value['startDatetime'];?>
')">
    <div class="container-fluid">
        <div class="col-md-7">

            <h3>Add Segments</h3>

            <h5>Episode Information:</h5>
            Program:  <?php echo $_smarty_tpl->tpl_vars['episode']->value['program'];?>
 <br/>
            Start Date/Time: <?php echo $_smarty_tpl->tpl_vars['episode']->value['startDatetime'];?>
 <br/>
            End Date/Time: <?php echo $_smarty_tpl->tpl_vars['episode']->value['endDatetime'];?>
 <br/> <br/>

        Program ID: <?php echo $_smarty_tpl->tpl_vars['programId']->value;?>
 <br/> <br/>

            <?php echo $_smarty_tpl->getSubTemplate ('./segment-form.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('idSuffix'=>''), 0);
?>

            <?php echo $_smarty_tpl->getSubTemplate ('./segment-form.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('idSuffix'=>'_edit'), 0);
?>


            <br />

            <form id="finalize" class="forward_form" role="form" action="review-logsheet.php" method="get" onsubmit="">
                <input type="hidden" name="epId" value=<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
>
                <input type="submit" value="Final Review">
            </form>

            <form class="backward_form" action="new-logsheet.php" method="get">
                <input type="hidden" name="epId" value="<?php echo $_smarty_tpl->tpl_vars['episode']->value['id'];?>
"/>
                <input type="submit" value="Back to Episode Metadata"/>
            </form>
        </div>

        <br />
        <br />

        <div class="col-md-5">
            <span id="playlist_not_aligned_help_text" class="help-block<?php if (!isset($_smarty_tpl->tpl_vars['formErrors']->value['noAlignmentWithEpisodeStart'])) {?> hidden<?php }?>">
                The earliest segment must align with the episode start date/time.
            </span>

            <span id="segment_errors_exist_help_text" class="help-block<?php if (!isset($_smarty_tpl->tpl_vars['formErrors']->value['erroneousSegmentsExist'])) {?> hidden<?php }?>">
                Errors exist in the highlighted segments below. Please correct them before proceeding to the final review.
            </span>

            <div class="panel panel-default">
                <div class="panel-heading">Episode Segments</div>

                <table class="table table-hover" id="added_segments">
                    <colgroup>
                        <col id="start_time_column" />
                        <col span="3"/>
                        <col />
                    </colgroup>
                    <thead>
                    <tr>
                        <th>Time</th>
                        <th colspan="3">Description</th>
                        <th>Category</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="confirmDeleteModalLabel">Warning</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this segment?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="confirmDeleteButton" onClick="">Yes</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html><?php }
}
?>