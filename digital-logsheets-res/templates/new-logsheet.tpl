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
        <script src="js/dynamic_form.js"></script>
    </head>
    <body>
        <div class="container">
    <h3>New Logsheet</h3>
        <form id="logsheet" role="form" action="../php/save-logsheet.php" method="post">
            <h4>Episode Metadata</h4>
            <div class="form-group">
                <label for="programmers">Programmer(s):</label>
                <input type="text" name="programmers" id="programmers"><br />

                <label for="program">Program:</label>
                {html_options name="program" id="program" options=$programs}<br />

                <label for="prerecord">Pre-recorded</label>
                <input type="checkbox" name="prerecord" value="prerecord" id="prerecord">
                <label for="prerecord_date">Pre-recorded Date:</label>
                <input type="date" name="prerecord_date" id="prerecord_date"><br />

                <label for="start_time">Start Time:</label>
                <input type="datetime-local" name="start_time" id="start_time"><br />
                <label for="end_time">End Time:</label>
                <input type="datetime-local" name="end_time" id="end_time"><br />

                <label for="notes">Notes:</label>
                <input type="text" name="notes" id="notes"><br />
            </div>
            
            <hr>
            <h4>Episode Playlist</h4>
            <h5>Enter the segments in any order; they will be sorted automatically later.</h5>

            <div id="segments">
                <div class="form-group" id="segment">
                    <label for="segment_time">Time:</label>
                    <input type="datetime-local" class="form-control" name="segment_time[]">
                    <label for="category">Category:</label>
                    {html_options name="category[]" class="form-control" options=$categories}
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name[]">
                    <label for="author">Author:</label>
                    <input type="text" class="form-control" name="author[]">
                    <label for="album">Album:</label>
                    <input type="text" class="form-control" name="album[]">
                    <label class="checkbox-inline" for="can_con">CanCon:</label><input type="checkbox" name="can_con[]" value="">

                    <label class="checkbox-inline" for="new_release">New Release:</label><input type="checkbox" name="new_release[]" value="">

                    <label class="checkbox-inline" for="french_vocal_music"> French Vocal Music:</label><input type="checkbox" name="french_vocal_music[]" value="">

                    <a href="#" onClick="cloneRow(event)">add</a>
                    <a href="#" onClick="removeRow(event)">remove</a>
                    <br>
                </div>
            </div>
            
            <input type="submit" value="Continue">
        </form>
        </div>
    </body>
</html>