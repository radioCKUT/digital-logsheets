<?php /* Smarty version 3.1.27, created on 2017-06-02 23:06:02
         compiled from "/var/www/digital-logsheets-res/templates/new-logsheet.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:4734895955931ef5acbcfe6_31351203%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '939a7091ea2fd37e67c3c05d74d0e498f8b4a221' => 
    array (
      0 => '/var/www/digital-logsheets-res/templates/new-logsheet.tpl',
      1 => 1496444761,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4734895955931ef5acbcfe6_31351203',
  'variables' => 
  array (
    'episodeStartEarlyLimit' => 0,
    'episodeStartLateLimit' => 0,
    'prerecordDateEarlyDaysLimit' => 0,
    'prerecordDateLateDaysLimit' => 0,
    'minDuration' => 0,
    'maxDuration' => 0,
    'programs' => 0,
    'program_id' => 0,
    'existingEpisode' => 0,
    'formErrors' => 0,
    'programmerError' => 0,
    'formSubmission' => 0,
    'programId' => 0,
    'programName' => 0,
    'programError' => 0,
    'startDatetimeError' => 0,
    'endDateTimeError' => 0,
    'prerecordError' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5931ef5b066893_87160317',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5931ef5b066893_87160317')) {
function content_5931ef5b066893_87160317 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '4734895955931ef5acbcfe6_31351203';
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

    <!-- jQuery -->
    <?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-1.11.3.min.js"><?php echo '</script'; ?>
>

    <!-- Boostrap JS -->
    <?php echo '<script'; ?>
 src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"><?php echo '</script'; ?>
>

    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" rel="stylesheet"/>
    <?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.js"><?php echo '</script'; ?>
>


    <link href="css/custom.css" rel="stylesheet"/>
    <?php echo '<script'; ?>
 type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="js/validation/markErrors.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="js/validation/episodeValidation.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="js/ui/prerecord.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="js/ui/categoryButton.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript">
        function init() {
            setupEpisodeValidation({
                episodeStartEarlyLimit: <?php echo json_encode($_smarty_tpl->tpl_vars['episodeStartEarlyLimit']->value);?>
,
                episodeStartLateLimit: <?php echo json_encode($_smarty_tpl->tpl_vars['episodeStartLateLimit']->value);?>
,
                prerecordDateEarlyDaysLimit: <?php echo $_smarty_tpl->tpl_vars['prerecordDateEarlyDaysLimit']->value;?>
,
                prerecordDateLateDaysLimit:  <?php echo $_smarty_tpl->tpl_vars['prerecordDateLateDaysLimit']->value;?>
,
                minDuration: <?php echo $_smarty_tpl->tpl_vars['minDuration']->value;?>
,
                maxDuration: <?php echo $_smarty_tpl->tpl_vars['maxDuration']->value;?>

            });

            $('#programmer').focusout(function() {
                verifyProgrammer();
            });

            $('#program').focusout(function() {
                verifyProgram();
            });

            $('#start_datetime').change(function() {
                adjustPrerecordDateBounds(<?php echo json_encode($_smarty_tpl->tpl_vars['prerecordDateEarlyDaysLimit']->value);?>
,
                        <?php echo json_encode($_smarty_tpl->tpl_vars['prerecordDateLateDaysLimit']->value);?>
);
                adjustEndDatetimeBounds(<?php echo $_smarty_tpl->tpl_vars['minDuration']->value;?>
, <?php echo $_smarty_tpl->tpl_vars['maxDuration']->value;?>
);

            }).focusout(function() {
                verifyEpisodeStartDatetime();
            });

            $('#end_datetime').focusout(function() {
                verifyEpisodeEndDatetime();
            });

            $('#prerecord_date').focusout(function() {
                verifyPrerecordDate();
            });

            $('#logsheet').submit(function (e) {
                if (!verifyProgrammer() ||
                    !verifyProgram() ||
                    !verifyEpisodeStartDatetime() ||
                    !verifyEpisodeEndDatetime() ||
                    !verifyPrerecordDate()) {

                    e.preventDefault();
                }
            });

            var data = <?php echo $_smarty_tpl->tpl_vars['programs']->value;?>
;

            $(".program").select2({
                data: data
            });
        }
    <?php echo '</script'; ?>
>
</head>
<body onload="init()">
<div class="container-fluid">
    <h3>New Logsheet</h3>

    <!--Show program id: <?php echo $_smarty_tpl->tpl_vars['program_id']->value;?>
 <br/-->

    <form id="logsheet" role="form" action="save-episode.php" method="post">
        <h4>Episode Metadata</h4>

        <?php if ($_smarty_tpl->tpl_vars['existingEpisode']->value) {?>
            <input type="hidden" name="existingEpisode" value="<?php echo $_smarty_tpl->tpl_vars['existingEpisode']->value;?>
"/>
        <?php }?>

            <?php if ($_smarty_tpl->tpl_vars['formErrors']->value['missingProgrammer']) {?>
                <?php $_smarty_tpl->tpl_vars["programmerError"] = new Smarty_Variable(true, null, 0);?>
            <?php } else { ?>
                <?php $_smarty_tpl->tpl_vars["programmerError"] = new Smarty_Variable(false, null, 0);?>
            <?php }?>



            <div id="programmer_group" class="form-group programmer_group row<?php if ($_smarty_tpl->tpl_vars['programmerError']->value) {?> has-error<?php }?>" >
                <div class="col-md-6 col-sm-8">
                    <label for="programmer" class="control-label">Programmer(s):</label>
                    <input class="form-control" type="text"
                           name="programmer" id="programmer"
                           value="<?php echo $_smarty_tpl->tpl_vars['formSubmission']->value['programmer'];?>
" required>
                    <span id="programmer_help_block" class="help-block<?php if (!$_smarty_tpl->tpl_vars['programmerError']->value) {?> hidden<?php }?>">
                        Please enter a programmer name.
                    </span>
                </div>
            </div>

            <?php if ($_smarty_tpl->tpl_vars['formErrors']->value['missingProgram']) {?>
                <?php $_smarty_tpl->tpl_vars["programError"] = new Smarty_Variable(true, null, 0);?>
            <?php } else { ?>
                <?php $_smarty_tpl->tpl_vars["programError"] = new Smarty_Variable(false, null, 0);?>
            <?php }?>

        Show program id: <?php echo $_smarty_tpl->tpl_vars['programId']->value;?>
 <br/>
        Show program name : <?php echo $_smarty_tpl->tpl_vars['programName']->value;?>
 <br/>
        <?php if ($_smarty_tpl->tpl_vars['programId']->value == null) {?>
        <div id="program_group" class="form-group row<?php if ($_smarty_tpl->tpl_vars['programError']->value) {?> has-error<?php }?>">
            <div class="col-md-4 col-sm-6">
                <label for="program" class="control-label">Program:</label>

                <select class="form-control program" name="program" id="program">
                    <?php if (isset($_smarty_tpl->tpl_vars['formSubmission']->value['programName'])) {?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['formSubmission']->value['programId'];?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['formSubmission']->value['programName'];?>
</option>
                    <?php }?>
                </select>
                <span id="program_help_block" class="help-block<?php if (!$_smarty_tpl->tpl_vars['programError']->value) {?> hidden<?php }?>">
                        Please enter a program.
                </span>
            </div>
        </div>
        <?php } else { ?>
        <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['programId']->value;?>
" name="program">
        <?php }?>


            <?php if ($_smarty_tpl->tpl_vars['formErrors']->value['missingStartTime'] || $_smarty_tpl->tpl_vars['formErrors']->value['airDateTooFarInPast'] || $_smarty_tpl->tpl_vars['formErrors']->value['airDateTooFarInFuture']) {?>
                <?php $_smarty_tpl->tpl_vars["startDatetimeError"] = new Smarty_Variable(true, null, 0);?>
            <?php } else { ?>
                <?php $_smarty_tpl->tpl_vars["startDatetimeError"] = new Smarty_Variable(false, null, 0);?>
            <?php }?>

            <div id="start_datetime_group" class="form-group row<?php if ($_smarty_tpl->tpl_vars['startDatetimeError']->value) {?> has-error<?php }?>">
                <div class="col-md-3 col-sm-5">
                    <label for="start_datetime" class="control-label">Start Date/Time:</label>
                    <input class="form-control" type="datetime-local"
                           name="start_datetime" id="start_datetime" step="60"
                           value="<?php echo $_smarty_tpl->tpl_vars['formSubmission']->value['startDatetime'];?>
" required>
                    <span id="start_datetime_help_block" class="help-block<?php if (!$_smarty_tpl->tpl_vars['startDatetimeError']->value) {?> hidden<?php }?>">
                        <span id="missing_start_time_message" class="<?php if (!$_smarty_tpl->tpl_vars['formErrors']->value['missingStartTime']) {?>hidden<?php }?>">
                            Please enter a valid start date/time.
                        </span>
                        <span id="air_date_too_far_in_past_message" class="<?php if (!$_smarty_tpl->tpl_vars['formErrors']->value['airDateTooFarInPast']) {?>hidden<?php }?>">
                            Start date/time must be after <?php echo $_smarty_tpl->tpl_vars['episodeStartEarlyLimit']->value;?>
.
                        </span>
                        <span id="air_date_too_far_in_future_message" class="<?php if (!$_smarty_tpl->tpl_vars['formErrors']->value['airDateTooFarInFuture']) {?>hidden<?php }?>">
                            Start date/time must be before <?php echo $_smarty_tpl->tpl_vars['episodeStartLateLimit']->value;?>
.
                        </span>
                    </span>
                </div>
            </div>




            <?php if ($_smarty_tpl->tpl_vars['formErrors']->value['missingEndTime'] || $_smarty_tpl->tpl_vars['formErrors']->value['tooShort'] || $_smarty_tpl->tpl_vars['formErrors']->value['tooLong']) {?>
                <?php $_smarty_tpl->tpl_vars["endDateTimeError"] = new Smarty_Variable(true, null, 0);?>
            <?php } else { ?>
                <?php $_smarty_tpl->tpl_vars["endDateTimeError"] = new Smarty_Variable(false, null, 0);?>
            <?php }?>

            <div id="end_datetime_group" class="form-group row<?php if ($_smarty_tpl->tpl_vars['endDateTimeError']->value) {?> has-error<?php }?>">
                <div class="col-md-3 col-sm-5">
                    <label for="end_datetime" class="control-label">End Date/Time:</label>
                    <input class="form-control" type="datetime-local"
                           name="end_datetime" id="end_datetime" step="60"
                           value="<?php echo $_smarty_tpl->tpl_vars['formSubmission']->value['endDatetime'];?>
" required>
                    <span id="end_datetime_help_block" class="help-block<?php if (!$_smarty_tpl->tpl_vars['endDateTimeError']->value) {?> hidden<?php }?>">
                            <span id="missing_end_datetime_message" class="<?php if (!$_smarty_tpl->tpl_vars['formErrors']->value['missingEndTime']) {?>hidden<?php }?>">
                                Please enter a valid end date/time.
                            </span>
                            <span id="too_short_message" class="<?php if (!$_smarty_tpl->tpl_vars['formErrors']->value['tooShort']) {?>hidden<?php }?>">
                                Episodes must be at least <?php echo $_smarty_tpl->tpl_vars['minDuration']->value;?>
 hours long.
                            </span>
                            <span id="too_long_message" class="<?php if (!$_smarty_tpl->tpl_vars['formErrors']->value['tooLong']) {?>hidden<?php }?>">
                                Episodes must be less than <?php echo $_smarty_tpl->tpl_vars['maxDuration']->value;?>
 hours long.
                            </span>
                        </span>
                </div>
            </div>




            <?php if ($_smarty_tpl->tpl_vars['formErrors']->value['missingPrerecordDate'] || $_smarty_tpl->tpl_vars['formErrors']->value['prerecordDateInPast'] || $_smarty_tpl->tpl_vars['formErrors']->value['prerecordDateInFuture']) {?>
                <?php $_smarty_tpl->tpl_vars["prerecordError"] = new Smarty_Variable(true, null, 0);?>
            <?php } else { ?>
                <?php $_smarty_tpl->tpl_vars["prerecordError"] = new Smarty_Variable(false, null, 0);?>
            <?php }?>

            <div id="prerecord_group" class="form-group row<?php if ($_smarty_tpl->tpl_vars['prerecordError']->value) {?> has-error<?php }?>">
                <div class="col-md-2 col-sm-4">
                    <label for="prerecord_date" id="prerecord_date_label" class="control-label">Prerecord Date:</label>
                    <div class="input-group">
                    <span class="input-group-addon">
                        <input type="checkbox" id="prerecord" title="Was episode prerecorded?" name="prerecord"
                               aria-label="Was episode prerecorded?"<?php if ($_smarty_tpl->tpl_vars['formSubmission']->value['prerecord']) {?> checked<?php }?>>
                    </span>
                        <input class="form-control" type="date"
                               name="prerecord_date" id="prerecord_date"
                               aria-label="Prerecord date"
                               value="<?php echo $_smarty_tpl->tpl_vars['formSubmission']->value['prerecordDate'];?>
" disabled>
                    </div>
                    <span id="prerecord_help_block" class="help-block<?php if (!$_smarty_tpl->tpl_vars['prerecordError']->value) {?> hidden<?php }?>">
                        <span id="missing_prerecord_date_message" class="<?php if (!$_smarty_tpl->tpl_vars['formErrors']->value['missingPrerecordDate']) {?> hidden<?php }?>">
                            If this episode is prerecorded, it must have a valid prerecord date.
                        </span>
                        <span id="prerecord_date_too_far_in_past_message" class="<?php if (!$_smarty_tpl->tpl_vars['formErrors']->value['prerecordDateInPast']) {?> hidden<?php }?>">
                            Prerecord date must be within the <?php echo $_smarty_tpl->tpl_vars['prerecordDateEarlyDaysLimit']->value;?>
 days before the air date.
                        </span>
                        <span id="prerecord_date_too_far_in_future_message" class="<?php if (!$_smarty_tpl->tpl_vars['formErrors']->value['prerecordDateInFuture']) {?> hidden<?php }?>">
                            Prerecord date must be within the <?php echo $_smarty_tpl->tpl_vars['prerecordDateLateDaysLimit']->value;?>
 days after the air date.
                        </span>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label for="notes" class="control-label">Notes:</label>
                <textarea class="form-control" name="notes" id="notes"><?php echo $_smarty_tpl->tpl_vars['formSubmission']->value['notes'];?>
</textarea>
            </div>

            <input type="submit" value="Add Segments">
    </form>
</div>
</body>
</html><?php }
}
?>