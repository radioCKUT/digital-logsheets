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

        <!-- Script for adding form fields -->
        <script src="js/dynamic_form.js"></script>
    </head>
    <body>
        <form id="logsheet" role="form" action="../save-logsheet.php" method="post">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name"><br />
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name"><br />
            </div>
            <div class="form-group">
                <label for="program">Program:</label>
                {html_options name="program" id="program" options=$programs}<br />
            </div>
            <div class="form-group">
                <label for="prerecord">Pre-recorded</label>
                <input type="checkbox" name="prerecord" value="prerecord" id="prerecord">
                <label for="prerecord_date">Pre-recorded Date:</label>
                <input type="date" name="prerecord_date" id="prerecord_date"><br />
            </div>
            <div class="form-group">
                <label for="start_time">Start Time:</label>
                <input type="datetime-local" name="start_time" id="start_time"><br />
                <label for="end_time">End Time:</label>
                <input type="datetime-local" name="end_time" id="end_time"><br />
            </div>
            <div class="form-group">
                <label for="comment">Comment:</label>
                <input type="text" name="comment" id="comment"><br />
            </div>
            
            <hr>
            
            <div>
                Time: <input type="datetime-local" name="segment_time[]">
                Name: <input type="text" name="name[]">
                Author: <input type="text" name="author[]">
                Category: {html_options name="category[]" options=$categories}
                CanCon: <input type="checkbox" name="can_con[]" value="can_con">
                New Release: <input type="checkbox" name="new_release[]" value="new_release">
                French Vocal Music: <input type="checkbox" name="french_vocal_music[]" value="french_vocal_music">
                <a href="#" onClick="cloneRow(event)">add</a>
                <a href="#" onClick="removeRow(event)">remove</a>
                <br>
            </div>
            
            <input type="submit" value="Continue">
        </form>
    </body>
</html>