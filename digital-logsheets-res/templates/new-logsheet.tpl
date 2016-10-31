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
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Boostrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <!-- Select2 -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
    <link href="css/select2-bootstrap.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.js"></script>


    <link href="css/custom.css" rel="stylesheet"/>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"></script>
    <script src="js/validation/markErrors.js"></script>
    <script src="js/validation/episodeValidation.js"></script>
    <script src="js/ui/prerecord.js"></script>
    <script src="js/ui/categoryButton.js"></script>
    <script type="text/javascript">
        function init() {
            setupEpisodeValidation({
                episodeStartEarlyLimit: {$episodeStartEarlyLimit|json_encode},
                episodeStartLateLimit: {$episodeStartLateLimit|json_encode},
                prerecordDateEarlyDaysLimit: {$prerecordDateEarlyDaysLimit},
                prerecordDateLateDaysLimit:  {$prerecordDateLateDaysLimit},
                minDuration: {$minDuration},
                maxDuration: {$maxDuration}
            });

            $('#start_datetime').change(function() {
                adjustPrerecordDateBounds({$prerecordDateEarlyDaysLimit|json_encode}, {$prerecordDateLateDaysLimit|json_encode});
            }).focusout(function() {
                verifyEpisodeStartDatetime();
            });

            $('#programmer').focusout(function() {
                verifyProgrammer();
            });

            $('#program').focusout(function() {
                verifyProgram();
            });

            $('#episode_duration').focusout(function() {
                verifyEpisodeDuration();
            });


            var data = {$programs};

            $(".program").select2({
                data: data
            });
        }
    </script>
</head>

<body onload="init()">
<div class="container-fluid">
    <h3>New Logsheet</h3>
    <form id="logsheet" role="form" action="save-episode.php" method="post">
        <h4>Episode Metadata</h4>


            {if $formErrors.programmerError}
                {assign var="programmerError" value=true}
            {else}
                {assign var="programmerError" value=false}
            {/if}

            <div id="programmer_group" class="form-group programmer_group row{if $programmerError} has-error{/if}">
                <div class="col-md-6 col-sm-8">
                    <label for="programmer" class="control-label">Programmer(s):</label>
                    <input class="form-control" type="text" name="programmer" id="programmer" required>
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

            <div id="program_group" class="form-group row{if $programError} has-error{/if}">
                <div class="col-md-4 col-sm-6">
                    <label for="program" class="control-label">Program:</label>
                    <select class="form-control program" name="program" id="program"></select>
                    <span id="program_help_block" class="help-block{if !$programError} hidden{/if}">
                        Please enter a program.
                    </span>
                </div>
            </div>




            {if $formErrors.missingStartTime || $formErrors.airDateTooFarInPast || $formErrors.airDateTooFarInFuture}
                {assign var="startDatetimeError" value=true}
            {else}
                {assign var="startDatetimeError" value=false}
            {/if}

            <div id="start_datetime_group" class="form-group row{if $startDatetimeError} has-error{/if}">
                <div class="col-md-3 col-sm-5">
                    <label for="start_datetime" class="control-label">Start Date/Time:</label>
                    <input class="form-control" type="datetime-local"
                           name="start_datetime" id="start_datetime" step="60" required>
                    <span id="start_datetime_help_block" class="help-block{if !$startDatetimeError} hidden{/if}">
                        <span id="missing_start_time_message" class="{if !$formErrors.missingStartTime}hidden{/if}">
                            Please enter a valid start date/time.
                        </span>
                        <span id="air_date_too_far_in_past_message" class="{if !$formErrors.airDateTooFarInPast}hidden{/if}">
                            Start date/time must be after {$episodeStartEarlyLimit}.
                        </span>
                        <span id="air_date_too_far_in_future_message" class="{if !$formErrors.airDateTooFarInFuture}hidden{/if}">
                            Start date/time must be before {$episodeStartLateLimit}.
                        </span>
                    </span>
                </div>
            </div>




            {if $formErrors.missingDuration || $formErrors.tooShort || $formErrors.tooLong}
                {assign var="durationError" value=true}
            {else}
                {assign var="durationError" value=false}
            {/if}

            <div id="duration_group" class="form-group row{if $durationError} has-error{/if}">
                <div class="col-md-2 col-sm-4">
                    <label for="episode_duration" class="control-label">Duration (in hours):</label>
                    <input class="form-control" type="number"
                           step="0.5" name="episode_duration"
                           id="episode_duration" required>
                    <span id="duration_help_block" class="help-block{if !$durationError} hidden{/if}">
                        <span id="missing_duration_message" class="{if !$formErrors.missingDuration}hidden{/if}">
                            Please enter a duration.
                        </span>
                        <span id="too_short_message" class="{if $formErrors.tooShort}hidden{/if}">
                            Episode must be at least {$minDuration} hours long
                        </span>
                        <span id="too_long_message" class="{if $formErrors.tooLong}hidden{/if}">
                            Episode must be less than {$maxDuration} hours long
                        </span>
                    </span>
                </div>
            </div>




            {if $formErrors.missingPrerecordDate || $formErrors.prerecordDateInPast || $formErrors.prerecordDateInFuture}
                {assign var="prerecordError" value=true}
            {else}
                {assign var="prerecordError" value=false}
            {/if}

            <div class="form-group row{if $prerecordError} has-error{/if}">
                <div class="col-md-2 col-sm-4">
                    <label for="prerecord_date" id="prerecord_date_label" class="control-label">Prerecord Date:</label>
                    <div class="input-group">
                    <span class="input-group-addon">
                        <input type="checkbox" id="prerecord" title="Was episode prerecorded?" aria-label="Was episode prerecorded?">
                    </span>
                        <input class="form-control" type="date"
                               name="prerecord_date" id="prerecord_date"
                               aria-label="Prerecord date" disabled>
                    </div>
                    <span class="help-block{if !$prerecordError} hidden{/if}">
                    {if $formErrors.missingPrerecordDate}
                        If this episode is prerecorded, it must have a prerecord date.
                    {elseif $formErrors.prerecordDateInPast}
                        Prerecord date must be within the {$prerecordDateEarlyDaysLimit} days before the air date.
                    {elseif $formErrors.prerecordDateInFuture}
                        Prerecord date must be within the {$prerecordDateLateDaysLimit} days after the air date.
                    {/if}
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label for="notes" class="control-label">Notes:</label>
                <textarea class="form-control" name="notes" id="notes"></textarea>
            </div>

            <input type="submit" value="Add Segments">
    </form>
</div>
</body>
</html>