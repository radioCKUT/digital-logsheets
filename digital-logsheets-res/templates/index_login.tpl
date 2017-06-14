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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" rel="stylesheet"/>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Boostrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>

    <script src="js/filterLogsheetList.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

    <script type="text/javascript">

        //for select list
        function init() {
            //var program_id = {$program_id}; //error select box login by admin
            var data = {$programs};
            var $programSelect = $(".program");

            $programSelect.select2({
                data: data
            });
            $programSelect.on("change", function (e) {
                updateFilteredLogsheetList();
            });

        }

        function updateFilteredLogsheetList() {
            var programNameFilterList = $(".program").select2('data').map(function (index, element) {
                console.log(index.text);
                return index.text;
            });

            var startDateFilter = $( "#startDateFilter" ).val();
            var endDateFilter = $( "#endDateFilter" ).val();

            var episodes = {$episodes|json_encode};

            filterLogsheetList(episodes, programNameFilterList, startDateFilter, endDateFilter);
        }
    </script>
</head>
<body onload="init()">

<div class='container-fluid'>
    {if $program_id != null}

        <div class="row">
            <div class="col-sm-2">
                <a href="new-logsheet.php?program_id={$program_id}">New Logsheet</a>
            </div>
        </div>

        {else}
        <div class="row">
            <div class="col-sm-2">
                <a href="new-logsheet.php">New Logsheet</a>
            </div>
        </div>

    {/if}

    <div class="form-group">
        <div class="col-sm-2 col-sm-offset-2">
         </div>
    </div>

    <br/>
    <br/>
    <div class="row">
        <div class="form-group">
        {if $program_id != null}
            <div class="col-sm-4 " style="display: none">
                <label for="program" class="control-label">Program:</label>
                <select class="form-control program" name="program" id="program" multiple="multiple"></select>
            </div>
        {/if}
        {if $program_id == null}
            <div class="col-sm-4">
                <label for="program" class="control-label">Program:</label>
                <select class="form-control program" name="program" id="program" multiple="multiple"></select>
            </div>
        {/if}

        <div class="col-sm-4">
            <label for="startDateFilter" class="control-label">Start:</label>
            <input type="date" id="startDateFilter" onchange="updateFilteredLogsheetList()">
        </div>
        <div class="col-sm-4">
            <label for="endDateFilter" class="control-label">End:</label>
            <input type="date" id="endDateFilter" onchange="updateFilteredLogsheetList()">
        </div>
        </div>
    </div>

    <div class="logsheets">
        <br/>
        {foreach $episodes as $episode}
            <a href="view-episode-logsheet.php?episode_id={$episode.id}">{$episode.program} - {$episode.startDate}</a> <br />
        {/foreach}
    </div>
</div>

</body>
</html>