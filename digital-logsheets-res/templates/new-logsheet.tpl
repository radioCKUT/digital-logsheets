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
        {*<script src="js/segment_form.js"></script>*}
        <script src="js/category_button.js"></script>
        <script src="js/sisyphus.min.js"></script>
    </head>
    <body>
        <div class="container">
    <h3>New Logsheet</h3>
        <form id="logsheet" data-persist="garlic" role="form" action="../../digital-logsheets-res/php/save-logsheet.php" method="post">
            <h4>Episode Metadata</h4>
            <div class="form-group">

                <div class="form-group">
                    <label for="programmers">Programmer(s):</label>
                    <input type="text" name="programmers" id="programmers"><br />
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
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date">
                </div>
                <div class="form-group">
                <label for="start_time">Start Time:</label>
                <input type="time" name="start_time" id="start_time">
                </div>
                <div class="form-group">
                <label for="end_time">End Time:</label>
                <input type="time" name="end_time" id="end_time">
                </div>
                <div class="form-group">

                <label for="notes">Notes:</label>
                <textarea class="form-control" name="notes" id="notes"></textarea>
                </div>
            </div>
            
            <hr>
            <h4>Episode Playlist</h4>
            <h5>Enter the segments in any order; they will be sorted automatically later.</h5>

            <div id="segments">
                <div id="segment" class="form-group">
                    <div class="form-group">
                        <label for="segment_time" class="control-label">Time:</label>
                        <input name="segment_time" id="segment_time" class="form-control" type="time">
                    </div>
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <div class="btn-group" id="category" data-toggle="buttons">
                            <label class="btn btn-primary" onclick="setupCat1Fields()">
                                <input type="radio" name="category" id="category1" autocomplete="off" value="1">1</label>
                            <label class="btn btn-primary" onclick="setupCat2Fields()">
                                <input type="radio" name="category" id="category2" autocomplete="off" value="2">2</label>
                            <label class="btn btn-primary" onclick="setupCat3Fields()">
                                <input type="radio" name="category" id="category3" autocomplete="off" value="3">3</label>
                            <label class="btn btn-primary" onclick="setupCat4Fields()">
                                <input type="radio" name="category" id="category4" autocomplete="off" value="4">4</label>
                            <label class="btn btn-primary" onclick="setupCat5Fields()">
                                <input type="radio" name="category" id="category5" autocomplete="off" value="5">5</label></div>
                    </div>
                    <div class="form-group" id="name_group">
                        <label for="name">Name:</label>
                        <input class="form-control" type="text" name="name" id="name_input">
                    </div>
                    <div class="form-group" id="author_group">
                        <label for="author">Author:</label>
                        <input class="form-control" type="text" name="author" id="author_input">
                    </div>
                    <div class="form-group" id="album_group">
                        <label for="album">Album:</label>
                        <input class="form-control" type="text" name="album" id="album_input">
                    </div>
                    <label class="checkbox-inline" id="can_con_group">
                        <input type="checkbox" name="can_con" value="">CC</label>
                    <label class="checkbox-inline" id="new_release_group">
                        <input type="checkbox" name="new_release" value="">NR</label>
                    <label class="checkbox-inline" id="french_vocal_music_group">
                        <input type="checkbox" name="french_vocal_music" value="">FV</label>
                    <hr>
                </div>
            </div>
            
            <input type="submit" value="Continue">
        </form>
        </div>
    </body>
</html>