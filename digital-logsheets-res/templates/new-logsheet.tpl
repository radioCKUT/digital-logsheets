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

    <!-- Select2 -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
    <link href="css/select2-bootstrap.css" rel="stylesheet"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Boostrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <!-- Select2 -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>


    <script src="js/date.js"></script>
    <script src="js/episode-validation.js"></script>
    <script src="js/prerecord.js"></script>
    <script src="js/category_button.js"></script>
    <script type="text/javascript">
        function init() {
            //checkPrerecordInput();
            var data = {$programs};

            console.log(data);
            $(".programs").select2({
                data: data
            })
        }
    </script>
</head>

<body onload="init()">
<div class="container-fluid">
    <h3>New Logsheet</h3>
    <form id="logsheet" role="form" action="save-episode.php" method="post">
        <h4>Episode Metadata</h4>

        <div class="form-group row">
            <div class="col-md-6">
                <label for="programmers">Programmer(s):</label>
                <input class="form-control" type="text" name="programmers" id="programmers" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="program">Program:</label>
                <select class="form-control programs" name="program" id="program"></select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="start_datetime">Start Date/Time:</label>
                <input class="form-control" type="datetime-local" name="start_datetime" id="start_datetime" onchange="adjustPrerecordDateBounds()" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <label for="episode_duration">Duration (in hours):</label>
                <input class="form-control" type="number" step="0.5" min="0.5" max="6.0" name="episode_duration" id="episode_duration" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <label for="prerecord_date" id="prerecord_date_label">Prerecord Date:</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="checkbox" id="prerecord" title="Was episode prerecorded?" aria-label="Was episode prerecorded?">
                    </span>
                    <input class="form-control" type="date" name="prerecord_date" id="prerecord_date" aria-label="Prerecord date" disabled>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="notes">Notes:</label>
            <textarea class="form-control" name="notes" id="notes"></textarea>
        </div>

        <input type="submit" value="Add Segments">
    </form>
</div>
</body>
</html>