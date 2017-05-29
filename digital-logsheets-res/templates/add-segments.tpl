<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>New Logsheet</title>

    {include './header.tpl'}
    
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
    <script type="text/javascript" src="js/init/add-segments.js"></script>
</head>


<body onload="init()">
    <div class="container-fluid">
        <div class="col-md-7">

            <h3>Add Segments</h3>

            <h5>Episode Information:</h5>
            Program:  {$episode.program} <br/>
            Start Date/Time: {$episode.startDatetime} <br/>
            End Date/Time: {$episode.endDatetime} <br/> <br/>


            {include file='./segment-form.tpl' idSuffix=''}
            {include file='./segment-form.tpl' idSuffix='_edit'}

            <br />

            <form id="finalize" class="forward_form" role="form" action="review-logsheet.php" method="get" onsubmit="">
                <input type="hidden" name="epId" value={$episode.id|json_encode}>
                <input type="submit" value="Final Review">
            </form>

            <form class="backward_form" action="new-logsheet.php" method="get">
                <input type="hidden" name="epId" value="{$episode.id}"/>
                <input type="submit" value="Back to Episode Metadata"/>
            </form>
        </div>

        <br />
        <br />

        <div class="col-md-5">
            <span id="playlist_not_aligned_help_text" class="help-block{if !isset($formErrors.noAlignmentWithEpisodeStart)} hidden{/if}">
                The earliest segment must align with the episode start date/time.
            </span>

            <span id="segment_errors_exist_help_text" class="help-block{if !isset($formErrors.erroneousSegmentsExist)} hidden{/if}">
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
</html>