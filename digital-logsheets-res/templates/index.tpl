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

    <!-- Moment.js (for date picker) -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
    <script type="text/javascript" src="../../digital-logsheets-res/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="../../digital-logsheets-res/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />

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
    </script>
</head>
<body onload="init()">

<div class="container-fluid">
    <a href="new-logsheet.php">New Logsheet</a>

    <br/>
    <br/>

    <div class="row">
        <div class="col-sm-4">
            <label for="program" class="control-label">Program:</label>
            <select class="form-control program" name="program" id="program"></select>
        </div>

        <div class='col-sm-4'>
            <div class="form-group">
                <label for="datetimepicker1" class="control-label">Start:</label>
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
        </script>

        <div class='col-sm-4'>
            <div class="form-group">
                <label for="datetimepicker2" class="control-label">End:</label>
                <div class='input-group date' id='datetimepicker2'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker2').datetimepicker();
            });
        </script>

    </div>

    <div class="logsheets">
        {foreach $episodes as $episode}
            <a href="view-episode-logsheet.php?episode_id={$episode.episode_id}">{$episode.program} - {$episode.start_date}</a> </br>
        {/foreach}
    </div>
</div>


</body>
</html>
    