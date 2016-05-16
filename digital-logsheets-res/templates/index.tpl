<!DOCTYPE html>
<html>
<head>
    <title>
        Page Title
    </title>
    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="http://getbootstrap.com/dist/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Select2 -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
    <link href="css/select2-bootstrap.css" rel="stylesheet"/>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Boostrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>


    <script type="text/javascript">
        var episodes = {$episodes|json_encode};

        function init() {
            var data = {$programs};
            var $programSelect = $(".program");

            $programSelect.select2({
                data: data
            });

            $programSelect.on("select2:select", function (e) {
                var selectedProgramName = e.params.data.text;
                console.log(selectedProgramName);

            } );
        }

        function isDateEntryBlank(dateEntry) {
            return dateEntry == null || dateEntry == '';
        }

        function checkWhetherEpisodeFallsWithinDateRange(startDate, endDate) {
            if (isDateEntryBlank(startDate) && isDateEntryBlank(endDate)) { //TODO: check if this covers blank date submissions
                return true;

            } else if (isDateEntryBlank(startDate)) {
                return episode.start_date < endDate;

            } else if (isDateEntryBlank(endDate)) {
                return episode.end_date > startDate;

            } else if (startDate < endDate) {
                return episode.start_date < endDate || episode.end_date > startDate;
            }
        }

        function appendEpisodeLink(existingLogsheetsContainer, episode) {
            existingLogsheetsContainer.append("<a href=\"view-episode-logsheet.php?episode_id=" + episode.episode_id + "\">" + episode.program + " - " + episode.start_date + "</a> <br />");
        }

        function filterDate(programNameFilterList, startDateFilter, endDateFilter) {
            var episodes = {$episodes|json_encode};

            var existingLogsheetsContainer = $(".logsheets");
            existingLogsheetsContainer.empty();

            episodes.each(function (index, episode) {
                if (programNameFilterList == null && startDateFilter == null && endDateFilter == null) {
                    appendEpisodeLink(existingLogsheetsContainer, episode);
                }

                var doesEpisodeMatchProgramName = false;
                var episodeProgramName = episode.program;

                programNameFilterList.each(function(index, element) {
                    if (episodeProgramName == element) {
                        doesEpisodeMatchProgramName = true;
                        return false;
                    }
                    return true;
                });

                if (!doesEpisodeMatchProgramName) {
                    return true;
                }

                var doesEpisodeFallWithinDateRange = checkWhetherEpisodeFallsWithinDateRange(startDateFilter, endDateFilter);

                if (doesEpisodeFallWithinDateRange) {
                    appendEpisodeLink(existingLogsheetsContainer, episode);
                }
            });

        }

    </script>
</head>
<body onload="init()">

<div class="container-fluid">
    <a href="new-logsheet.php">New Logsheet</a>

    <br/>
    <br/>

    <div class="row">
        <div class="col-sm-4">
            <label for="filterProgram" class="control-label">Program:</label>
            <select class="form-control program" name="filterProgram" id="filterProgram" multiple="multiple"></select>
        </div>

        <div class="col-sm-4">
            <label for="filterStartDate" class="control-label">Start:</label>
            <input type="datetime" id="filterStartDate">
        </div>

        <div class="col-sm-4">
            <label for="filterEndDate" class="control-label">End:</label>
            <input type="datetime" id="filterEndDate">
        </div>



    </div>

    <div class="logsheets">
        {foreach $episodes as $episode}
            <a href="view-episode-logsheet.php?episode_id={$episode.episode_id}">{$episode.program} - {$episode.start_date}</a> <br />
        {/foreach}
    </div>
</div>


</body>
</html>
    