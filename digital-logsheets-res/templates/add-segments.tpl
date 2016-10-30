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
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Boostrap JS -->
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function getEpisodeStartTime() {
            return {$episode.startTime|json_encode};
        }
    </script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"></script>
    <script type="text/javascript" src="js/validation/markErrors.js"></script>
    <script type="text/javascript" src="js/validation/segmentValidation.js"></script>
    <script type="text/javascript" src="js/validation/playlistValidation.js"></script>
    <script type="text/javascript" src="js/deleteSegment.js"></script>
    <script type="text/javascript" src="js/editSegment.js"></script>
    <script type="text/javascript" src="js/ui/segmentOptionsMenu.js"></script>
    <script type="text/javascript" src="js/saveReceiveSegments.js"></script>
    <script type="text/javascript" src="js/ui/categoryButton.js"></script>
    <script type="text/javascript" src="js/lib/sisyphus.min.js"></script>
    <script type="text/javascript">

        function init() {
            getEpisodeSegments();
            setFormOnSubmitBehaviour();
            setFocusOutBehaviour();
            $('form').sisyphus();
        }


        function setFormOnSubmitBehaviour() {
            var episode = {$episode|json_encode};

            $('#logsheet').on('submit', function(e) {
                e.preventDefault();
                var logsheetForm = $(e.delegateTarget);
                var timeGroup = logsheetForm.find('.time_group');

                if (verifySegmentStartTime(timeGroup, episode)) {
                    createSegment();
                }
            });

            var logsheetEdit = $('#logsheet_edit');

            logsheetEdit.on('submit', function(e) {
                e.preventDefault();
                var logsheetForm = $(e.delegateTarget);
                var timeGroup = logsheetForm.find('.time_group');

                if (verifySegmentStartTime(timeGroup, episode)) {
                    editEpisodeSegment();
                }
            });

            logsheetEdit.hide();

            $('#finalize')
                    .on('submit', function(e) {
                        if (!verifyPlaylistEpisodeAlignment()) {
                            e.preventDefault();
                        }
                    });
        }

        function setFocusOutBehaviour() {
            var segmentTimeInput = $('.segment_time');

            segmentTimeInput
                    .focusout(function(e) {
                        var segmentTimeField = $(e.delegateTarget);
                        var timeGroup = segmentTimeField.parent().parent();

                        verifySegmentStartTime(timeGroup,
                                {$episode|json_encode});
                    });
        }
    </script>
</head>
<body onload="init()">
<div class="container-fluid">
    <div class="col-md-8">
        <h3>Add Segments</h3>

        <h5>Episode Information:</h5>
        Program:  {$episode.program} <br/>
        Start Date/Time: {$episode.startDatetime} <br/>
        End Date/Time: {$episode.endDatetime} <br/> <br/>


        {include file='../../digital-logsheets-res/templates/segment-form.tpl' idSuffix=''}
        {include file='../../digital-logsheets-res/templates/segment-form.tpl' idSuffix='_edit'}

        <form id="finalize" role="form" action="review-logsheet.php" method="post" onsubmit="">
            <input type="hidden" name="episode_id" value={$episode.id|json_encode}>
            <input type="submit" value="Submit All">
        </form>
    </div>

    <div class="col-md-4">
        <span id="playlist_not_aligned_help_text" class="help-block{if !isset($formErrors.noAlignmentWithEpisodeStart)} hidden{/if}">
            The earliest segment must align with the episode start date/time.
        </span>

        <div class="panel panel-default">
            <div class="panel-heading">Episode Segments</div>

            <table class="table table-hover" id="added_segments">
                <colgroup>
                    <col />
                    <col id="start_time_column"/>
                    <col />
                </colgroup>
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>