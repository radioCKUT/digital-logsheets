<?php /* Smarty version 3.1.27, created on 2017-06-08 17:02:18
         compiled from "/var/www/digital-logsheets-res/templates/add-segments.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:18488527995939831a09dd67_27704093%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '11a9d6931fb46bb0cbd6fe5afff818a8fcd5352c' => 
    array (
      0 => '/var/www/digital-logsheets-res/templates/add-segments.tpl',
      1 => 1496942793,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18488527995939831a09dd67_27704093',
  'variables' => 
  array (
    'episode' => 0,
    'programId' => 0,
    'formErrors' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5939831a1d9607_90113433',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5939831a1d9607_90113433')) {
function content_5939831a1d9607_90113433 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '18488527995939831a09dd67_27704093';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Logsheet</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="http://getbootstrap.com/dist/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <!-- jQuery -->
    <?php echo '<script'; ?>
 type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"><?php echo '</script'; ?>
>

    <!-- Boostrap JS -->
    <?php echo '<script'; ?>
 type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript">
        function getEpisodeStartTime() {
            return <?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['startTime']);?>
;
        }
    <?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
 type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"><?php echo '</script'; ?>
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
 type="text/javascript">

        function init() {
            getEpisodeSegments();
            setFormOnSubmitBehaviour();
            setFocusOutBehaviour();
            setConfirmModalBehaviour();
            $('[data-toggle="tooltip"]').tooltip();
        }


        function setFormOnSubmitBehaviour() {
            var episode = <?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value);?>
;

            $('#logsheet').on('submit', function(e) {
                e.preventDefault();
                createSegment();
            });

            var logsheetEdit = $('#logsheet_edit');

            logsheetEdit.on('submit', function(e) {
                e.preventDefault();
                editEpisodeSegment();
            });

            logsheetEdit.hide();

            $('#finalize')
                    .on('submit', function(e) {
                        if (!verifyPlaylistEpisodeAlignment()) {
                            e.preventDefault();

                        }

                        $('#added_segments').find('tbody').find('tr').each(function (i, segment) {
                            segment = $(segment);
                            var errors = segment.data("errors");

                            if (isSegmentErroneous(errors)) {
                                markErroneousSegmentsExist();
                                e.preventDefault();
                                return false;
                            }

                            markNoErroneousSegmentsExist();
                        });
                    });
        }

        function setFocusOutBehaviour() {
            var segmentTimeInput = $('.segment_time');

            segmentTimeInput
                    .focusout(function(e) {
                        var segmentTimeField = $(e.delegateTarget);
                        var timeGroup = segmentTimeField.parent().parent();

                        verifySegmentStartTime(timeGroup,
                                <?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value);?>
);
                    });
        }

        function setConfirmModalBehaviour() {
            $('#confirmDeleteModal')
                .on('show.bs.modal', function (e) {
                    var deleteSegmentLink = $(e.relatedTarget);
                    var deleteSegmentRow = deleteSegmentLink.closest("tr");

                    var segmentToDelete = deleteSegmentRow.data("segment");
                    var segmentIdToDelete = segmentToDelete.id;

                    var confirmDeleteButton = $("#confirmDeleteButton");

                    confirmDeleteButton.click(function (e) {
                        e.preventDefault();
                        deleteEpisodeSegment(segmentIdToDelete);
                        $('#confirmDeleteModal').modal('hide');
                    });
                });
        }
    <?php echo '</script'; ?>
>
</head>
<body onload="init()">
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

        <!--Program ID: <?php echo $_smarty_tpl->tpl_vars['programId']->value;?>
 <br/> <br/-->

        <?php echo $_smarty_tpl->getSubTemplate ('./segment-form.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('idSuffix'=>''), 0);
?>

        <?php echo $_smarty_tpl->getSubTemplate ('./segment-form.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('idSuffix'=>'_edit'), 0);
?>


        <br />

        <form id="finalize" class="forward_form" role="form" action="review-logsheet.php" method="post" onsubmit="">
            <input type="hidden" name="episode_id" value=<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
>
            <input type="submit" value="Final Review">
        </form>

        <form class="backward_form" action="new-logsheet.php" method="get">
            <input type="hidden" name="draftEpisodeId" value="<?php echo $_smarty_tpl->tpl_vars['episode']->value['id'];?>
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