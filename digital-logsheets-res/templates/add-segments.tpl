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

            var segmentTimeInput = $('.segment-time');

            segmentTimeInput
                    .focusout(function() {
                        verifySegmentStartTime(segmentTimeInput.val(),
                                {$episode|json_encode});
                    });


            $('form').sisyphus();
        }

        function setFormOnSubmitBehaviour() {
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
                        var addedSegmentsTable = $('#added_segments');
                        addedSegmentsTable = addedSegmentsTable.children('tbody');
                        var segmentRows = addedSegmentsTable.children();

                        var segmentData = [];

                        segmentRows.each(function (i) {
                            segmentData[i] = $(this).data("segment");
                        });

                        var episodeStartTime = {$episode.startTime|json_encode}

                        if (!verifyPlaylistEpisodeAlignment(segmentData, episodeStartTime)) {
                            e.preventDefault();
                        }
                    });
        }
    </script>
</head>
<body onload="init()">
<div class="container-fluid">
    <div class="col-md-8">
        <h3>Add Segments</h3>
        {include file='../../digital-logsheets-res/templates/segment-form.tpl' idSuffix=''}
        {include file='../../digital-logsheets-res/templates/segment-form.tpl' idSuffix='_edit'}

        <form id="finalize" role="form" action="review-logsheet.php" method="post" onsubmit="">
            <input type="hidden" name="episode_id" value={$episode.id|json_encode}>
            <input type="submit" value="Submit All">
        </form>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">Episode Segments</div>

            <!-- Table -->
            <table class="table table-hover" id="added_segments">
            </table>
        </div>
    </div>
</div>
</body>
</html>