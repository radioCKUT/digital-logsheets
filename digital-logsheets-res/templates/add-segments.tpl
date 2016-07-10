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

    <script type="text/javascript" src="js/parsley.js"></script>


    <script type="text/javascript" src="js/date.js"></script>
    <script type="text/javascript" src="js/segment-validation.js"></script>
    <script type="text/javascript" src="js/manage-segments.js"></script>
    <script type="text/javascript" src="js/category-button.js"></script>
    <script type="text/javascript" src="js/sisyphus.min.js"></script>
    <script type="text/javascript">
        function startStoringFormEntries() {
            getEpisodeSegments();
            $('#logsheet_edit').hide();
            $('form').sisyphus();
        }
    </script>
</head>
<body onload="startStoringFormEntries()">
<div class="container-fluid">
    <div class="col-md-8">
        <h3>Add Segments</h3>
        <form id="logsheet" role="form" method="post">
            <h5>Episode ID: {$episode.id|json_encode}</h5>

            <div id="segments">
                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="segment_time" class="control-label">Time:</label>
                        <input name="segment_time" id="segment_time"
                               class="form-control segment-time" type="time" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="category" class="control-label">Category:</label>
                    <div class="btn-group category" data-toggle="buttons">
                        <label class="btn btn-primary" onclick="setupCat1Fields()">
                            <input type="radio" name="category" class="category1"
                                   autocomplete="off" required value="1">1</label>
                        <label class="btn btn-primary" onclick="setupCat2Fields()">
                            <input type="radio" name="category" class="category2"
                                   autocomplete="off" value="2">2</label>
                        <label class="btn btn-primary" onclick="setupCat3Fields()">
                            <input type="radio" name="category" class="category3"
                                   autocomplete="off" value="3">3</label>
                        <label class="btn btn-primary" onclick="setupCat4Fields()">
                            <input type="radio" name="category" class="category4"
                                   autocomplete="off" value="4">4</label>
                        <label class="btn btn-primary" onclick="setupCat5Fields()">
                            <input type="radio" name="category" class="category5"
                                   autocomplete="off" value="5">5</label>
                    </div>
                </div>
                <div class="form-group row ad_number_group" style="display:none;">
                    <div class="col-md-3">
                        <label for="ad_number_input" class="control-label ad_number_label">Ad Number:</label>
                        <input class="form-control" type="number" min="1" step="1" max="300" name="ad_number" id="ad_number_input">
                    </div>
                </div>
                <div class="form-group row name_group" style="display:none;">
                    <div class="col-md-9">
                        <label for="name_input" class="control-label name_label">Name:</label>
                        <input class="form-control name_input" type="text" name="name" id="name_input" required>
                    </div>
                </div>
                <div class="form-group row author_group" style="display:none;">
                    <div class="col-md-9">
                        <label for="author_input" class="control-label">Author:</label>
                        <input class="form-control author_input" type="text" name="author" id="author_input">
                    </div>
                </div>
                <div class="form-group row album_group" style="display:none;">
                    <div class="col-md-9">
                        <label for="album_input" class="control-label">Album:</label>
                        <input class="form-control album_input" type="text" name="album" id="album_input">
                    </div>
                </div>
                <label class="checkbox-inline can_con_group" style="display:none;">
                    <input type="checkbox" name="can_con" value="">CC</label>
                <label class="checkbox-inline new_release_group" style="display:none;">
                    <input type="checkbox" name="new_release" value="">NR</label>
                <label class="checkbox-inline french_vocal_music_group" style="display:none;">
                    <input type="checkbox" name="french_vocal_music" value="">FV</label>

                <input type="hidden" name="episode_id" value={$episode.id|json_encode}>
                <hr>
            </div>

            <input type="submit" value="Add">
        </form>

        <form id="logsheet_edit" role="form" method="post">
            <h5>Episode ID: {$episode.id|json_encode}</h5>

            <div id="segments">
                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="segment_time_edit" class="control-label">Time:</label>
                        <input name="segment_time" class="form-control segment-time" type="time" id="segment_time_edit" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="category" class="control-label">Category:</label>
                    <div class="btn-group category" data-toggle="buttons">
                        <label class="btn btn-primary" onclick="setupCat1Fields()">
                            <input type="radio" name="category" class="category1" autocomplete="off" required value="1">1</label>
                        <label class="btn btn-primary" onclick="setupCat2Fields()">
                            <input type="radio" name="category" class="category2" autocomplete="off" value="2">2</label>
                        <label class="btn btn-primary" onclick="setupCat3Fields()">
                            <input type="radio" name="category" class="category3" autocomplete="off" value="3">3</label>
                        <label class="btn btn-primary" onclick="setupCat4Fields()">
                            <input type="radio" name="category" class="category4" autocomplete="off" value="4">4</label>
                        <label class="btn btn-primary" onclick="setupCat5Fields()">
                            <input type="radio" name="category" class="category5" autocomplete="off" value="5">5</label></div>
                </div>
                <div class="form-group row ad_number_group" style="display:none;">
                    <div class="col-md-3">
                        <label for="ad_number_input_edit" class="control-label ad_number_label">Ad Number:</label>
                        <input class="form-control" type="number" min="1" step="1" max="300" name="ad_number" id="ad_number_input_edit">
                    </div>
                </div>
                <div class="form-group row name_group" style="display:none;">
                    <div class="col-md-9">
                        <label for="name_input_edit" class="control-label name_label">Name:</label>
                        <input class="form-control name_input" type="text" name="name" id="name_input_edit" required>
                    </div>
                </div>
                <div class="form-group row author_group" style="display:none;">
                    <div class="col-md-9">
                        <label for="author_input_edit" class="control-label">Author:</label>
                        <input class="form-control author_input" type="text" name="author" id="author_input_edit">
                    </div>
                </div>
                <div class="form-group row album_group" style="display:none;">
                    <div class="col-md-9">
                        <label for="album_input_edit" class="control-label">Album:</label>
                        <input class="form-control album_input" type="text" name="album" id="album_input_edit">
                    </div>
                </div>
                <label class="checkbox-inline can_con_group" style="display:none;">
                    <input type="checkbox" name="can_con" value="" id="can_con_edit">CC</label>
                <label class="checkbox-inline new_release_group" style="display:none;">
                    <input type="checkbox" name="new_release" value="" id="new_release_edit">NR</label>
                <label class="checkbox-inline french_vocal_music_group" style="display:none;">
                    <input type="checkbox" name="french_vocal_music" value="" id="french_vocal_music_edit">FV</label>

                <input type="hidden" name="episode_id" value={$episode.id|json_encode}>
                <hr>
            </div>

            <input type="hidden" name="segment_id" id="segment_id_edit">
            <input type="hidden" name="is_segment_edit" id="is_segment_edit">
            <input type="button" name="cancel" value="Cancel" onclick="cancelEdit()">
            <input type="submit" name="save" value="Save">
        </form>

        <form id="finalize" role="form" action="review-logsheet.php" method="post">
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