<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>New Logsheet</title>

    {include './scripts/core.tpl'}
    {include './scripts/datetime-picker.tpl'}
    {include './scripts/select2.tpl'}


    <link href="css/custom.css" rel="stylesheet"/>

    <script src="js/validation/markErrors.js"></script>
    <script src="js/validation/episodeValidation.js"></script>
    <script src="js/ui/prerecord.js"></script>
    <script src="js/ui/categoryButton.js"></script>
    <script type="text/javascript">
        function init() {
            var programDropdown = $(".program");
            var data = {$programs};

            if (!{$loginProgram|json_encode}) {
                programDropdown.select2({
                    data: data
                });
            } else {
                var program = data.filter(function (program) {
                    return program.text === {$loginProgram|json_encode};
                });

                programDropdown.select2({
                    data: program
                });
            }


            setupEpisodeValidation({
                episodeStartEarlyLimit: {$episodeStartEarlyLimit|json_encode},
                episodeStartLateLimit: {$episodeStartLateLimit|json_encode},
                prerecordDateEarlyDaysLimit: {$prerecordDateEarlyDaysLimit},
                prerecordDateLateDaysLimit:  {$prerecordDateLateDaysLimit},
                minDuration: {$minDuration},
                maxDuration: {$maxDuration}
            });

            $('#programmer').focusout(function() {
                verifyProgrammer();
            });

            $('#program').focusout(function() {
                verifyProgram();
            });

            $('#start_datetime').change(function() {
                adjustPrerecordDateBounds({$prerecordDateEarlyDaysLimit|json_encode},
                        {$prerecordDateLateDaysLimit|json_encode});
                adjustEndDatetimeBounds({$minDuration}, {$maxDuration});

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

            $('#start_datetime').datetimepicker();
            $('#end_datetime').datetimepicker();
            $('#prerecord_date').datetimepicker({
                format: "L"
            });
        }
    </script>
</head>
<body onload="init()">
<div class="container-fluid">
    <h3>New Logsheet</h3>

    <!--Show program id: {$program_id} <br/-->

    <form id="logsheet" role="form" action="save-episode.php" method="post">
        <h4>Episode Metadata</h4>

        {if $existingEpisode}
            <input type="hidden" name="existingEpisode" value="{$existingEpisode}"/>
        {/if}

            {if $formErrors.missingProgrammer}
                {assign var="programmerError" value=true}
            {else}
                {assign var="programmerError" value=false}
            {/if}



            <div id="programmer_group" class="form-group programmer_group row{if $programmerError} has-error{/if}" >
                <div class="col-md-6 col-sm-8">
                    <label for="programmer" class="control-label">Programmer(s):</label>
                    <input class="form-control" type="text"
                           name="programmer" id="programmer"
                           value="{$formSubmission.programmer}" required>
                    <span id="programmer_help_block" class="help-block{if !$programmerError} hidden{/if}">
                        Please enter a programmer name.
                    </span>
                </div>
            </div>




            {if $formErrors.missingProgram}
                {assign var="programError" value=true}
            {else}
                {assign var="programError" value=false}
            {/if}

        {if $programId == null}
        <div id="program_group" class="form-group row{if $programError} has-error{/if}">
            <div class="col-md-4 col-sm-6">
                <label for="program" class="control-label">Program:</label>

                <select class="form-control program" name="program" id="program">
                    {if isset($formSubmission.programName)}
                        <option value="{$formSubmission.programId}" selected="selected">{$formSubmission.programName}</option>
                    {/if}
                </select>
                <span id="program_help_block" class="help-block{if !$programError} hidden{/if}">
                        Please enter a program.
                </span>
            </div>
        </div>
        {else}
        <input type="hidden" value="{$programId}" name="program">
        {/if}

            {if $formErrors.missingStartTime || $formErrors.airDateTooFarInPast || $formErrors.airDateTooFarInFuture}
                {assign var="startDatetimeError" value=true}
            {else}
                {assign var="startDatetimeError" value=false}
            {/if}

            <div id="start_datetime_group" class="form-group row{if $startDatetimeError} has-error{/if}">
                <div class="col-md-6 col-sm-6">
                    <label for="start_datetime" class="control-label">Start Date/Time:</label>
                    <input class="form-control" type="text"
                           name="start_datetime" id="start_datetime" step="60"
                           value="{$formSubmission.startDatetime}" required>
                    <span id="start_datetime_help_block" class="help-block{if !$startDatetimeError} hidden{/if}">
                        <span id="missing_start_time_message" class="{if !$formErrors.missingStartTime}hidden{/if}">
                            Please enter a valid start date/time.
                        </span>
                        <span id="air_date_too_far_in_past_message" class="{if !$formErrors.airDateTooFarInPast}hidden{/if}">
                            Start date/time must be after {$episodeStartEarlyLimit|date_format:"%m/%d/%Y %l:%M"}.
                        </span>
                        <span id="air_date_too_far_in_future_message" class="{if !$formErrors.airDateTooFarInFuture}hidden{/if}">
                            Start date/time must be before {$episodeStartLateLimit|date_format:"%m/%d/%Y %l:%M"}.
                        </span>
                    </span>
                </div>
            </div>




            {if $formErrors.missingEndTime || $formErrors.tooShort || $formErrors.tooLong}
                {assign var="endDateTimeError" value=true}
            {else}
                {assign var="endDateTimeError" value=false}
            {/if}

            <div id="end_datetime_group" class="form-group row{if $endDateTimeError} has-error{/if}">
                <div class="col-md-6 col-sm-6">
                    <label for="end_datetime" class="control-label">End Date/Time:</label>
                    <input class="form-control" type="text"
                           name="end_datetime" id="end_datetime" step="60"
                           value="{$formSubmission.endDatetime}" required>
                    <span id="end_datetime_help_block" class="help-block{if !$endDateTimeError} hidden{/if}">
                            <span id="missing_end_datetime_message" class="{if !$formErrors.missingEndTime}hidden{/if}">
                                Please enter a valid end date/time.
                            </span>
                            <span id="too_short_message" class="{if !$formErrors.tooShort}hidden{/if}">
                                Episodes must be at least {$minDuration} hours long.
                            </span>
                            <span id="too_long_message" class="{if !$formErrors.tooLong}hidden{/if}">
                                Episodes must be less than {$maxDuration} hours long.
                            </span>
                        </span>
                </div>
            </div>




            {if $formErrors.missingPrerecordDate || $formErrors.prerecordDateInPast || $formErrors.prerecordDateInFuture}
                {assign var="prerecordError" value=true}
            {else}
                {assign var="prerecordError" value=false}
            {/if}

            <div id="prerecord_group" class="form-group row{if $prerecordError} has-error{/if}">
                <div class="col-md-2 col-sm-4">
                    <label for="prerecord_date" id="prerecord_date_label" class="control-label">Prerecord Date:</label>
                    <div class="input-group">
                    <span class="input-group-addon">
                        <input type="checkbox" id="prerecord" title="Was episode prerecorded?" name="prerecord"
                               aria-label="Was episode prerecorded?"{if $formSubmission.prerecord} checked{/if}>
                    </span>
                        <input class="form-control" type="text"
                               name="prerecord_date" id="prerecord_date"
                               aria-label="Prerecord date"
                               value="{$formSubmission.prerecordDate}" disabled>
                    </div>
                    <span id="prerecord_help_block" class="help-block{if !$prerecordError} hidden{/if}">
                        <span id="missing_prerecord_date_message" class="{if !$formErrors.missingPrerecordDate} hidden{/if}">
                            If this episode is prerecorded, it must have a valid prerecord date.
                        </span>
                        <span id="prerecord_date_too_far_in_past_message" class="{if !$formErrors.prerecordDateInPast} hidden{/if}">
                            Prerecord date must be within the {$prerecordDateEarlyDaysLimit} days before the air date.
                        </span>
                        <span id="prerecord_date_too_far_in_future_message" class="{if !$formErrors.prerecordDateInFuture} hidden{/if}">
                            Prerecord date must be within the {$prerecordDateLateDaysLimit} days after the air date.
                        </span>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label for="notes" class="control-label">Notes:</label>
                <textarea class="form-control" name="notes" id="notes">{$formSubmission.notes}</textarea>
            </div>

            <input type="submit" value="Add Segments">
    </form>
</div>
</body>
</html>