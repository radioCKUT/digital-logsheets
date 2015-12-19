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

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

        <!-- Boostrap JS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        
        <!-- Script for adding form fields -->
        <script src="js/prerecord.js"></script>
        <script src="js/category_button.js"></script>
        <script src="js/sisyphus.min.js"></script>
        <script type="text/javascript">
            function startStoringFormEntries() {
                //$('form').sisyphus();
                checkPrerecordInput();
            }
        </script>
    </head>
    <body onload="startStoringFormEntries()">
        <div class="container">
    <h3>New Logsheet</h3>
        <form id="logsheet" role="form" action="save-episode.php" method="post">
            <h4>Episode Metadata</h4>
            <div class="form-group">
                <div class="form-group">
                    <label for="programmers">Programmer(s):</label>
                    <input type="text" name="programmers" id="programmers" required><br />
                </div>
                <div class="form-group">
                <label for="program">Program:</label>
                {html_options name="program" id="program" options=$programs}<br />
                </div>
                <div class="form-group">
                    <label for="prerecord">Pre-recorded: </label>
                    <input type="checkbox" name="prerecord" value="prerecord" id="prerecord"> &nbsp;
                    <label for="prerecord_date" id="prerecord_date_label">Date recorded: </label>
                    <input type="date" name="prerecord_date" id="prerecord_date">
                </div>
                <div class="form-group">
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" id="start_date" required>
                </div>
                <div class="form-group">
                    <label for="start_time">Start Time:</label>
                    <input type="time" name="start_time" id="start_time" required>
                </div>
                <div class="form-group">
                    <label for="end_time">End Time:</label>
                    <input type="time" name="end_time" id="end_time" required>
                </div>
                <div class="form-group">
                    <label for="notes">Notes:</label>
                    <textarea class="form-control" name="notes" id="notes"></textarea>
                </div>
            </div>
            
            <input type="submit" value="Add Segments">
        </form>
        </div>
    </body>
</html>