<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Submit a playlist</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        
        <!-- datetimepicker -->
        <link rel="stylesheet" href="/css/bootstrap-datetimepicker.css">
    </head>
    
    <body>
        <div class="container">
            <div class="jumbotron">
                <h1>CKUT Logsheets</h1>
                <p>Submit logsheet data below.</p>
            </div>
            
            <!--This needs to be dynamic-->
            <form id="logsheet" role="form" action="saveEpisode.php" method="POST">
                
                <div class="row">
                    <div class="col-md-4">   
                        <div class="form-group">
                            <label for="program">Program</label>
                            <input type="text"  id="program" class="form-control" placeholder="Title" name="program">
                        </div>{* End form-group *}
                    </div>
                </div>{* End row *}
                
                <div class="row">
                    <div class="col-md-4">   
                        <div class="form-group">
                            <label for="programmer">Programmer's Name</label>
                            <input type="text"  id="programmer" class="form-control" placeholder="First and Last name" name="programmer">
                        </div>{* End form-group *}
                    </div>
                </div>{* End row *}
                
                <div class="row">
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label><input type="checkbox">Pre-recorded</label>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="datetimepicker6">Time Started</label>
                            <div class='input-group date' id='datetimepicker6'>
                                <input type='text' class="form-control" name="start_time" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="datetimepicker7">Time Ended</label>
                            <div class='input-group date' id='datetimepicker7'>
                                <input type='text' class="form-control" name="end_time" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>{* end row *}
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="comment">Did your show feature a theme, feature, interview, etc.?</label>
                            <textarea class="form-control" rows="3" id="comment"></textarea>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-md-1">
                        <input type='text' id='datetimepicker10' class="form-control" name="length[]" />
                    </div>
                    
                    <div class='col-md-2'>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Segment Title" name="name[]" />
                        </div>{* End form-group *}
                    </div>
                    
                    <div class='col-md-2'>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Artist/Author" name="author[]" />
                        </div>{* End form-group *}
                    </div>
                    
                    <div class='col-md-2'>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Album" name="album[]" />
                        </div>{* End form-group *}
                    </div>
                    
                    <div class='col-md-2'>
                        <div class="form-group category-select">
                            {html_options class="form-control" name="category[]" options=$categories}
                        </div>{* End form-group *}
                    </div>
                    
                    <div class='col-md-3 form-inline'>    
                        <div class="checkbox">
                            <label><input type="checkbox" name="can_con">CanCon</label>
                        </div>    
                        <div class="checkbox">
                            <label><input type="checkbox" name="new_release">New</label>
                        </div>    
                        <div class="checkbox">
                            <label><input type="checkbox" name="french_vocal_music">French</label>
                        </div>    
                        <div class="checkbox">
                            <label><input type="checkbox" name="request">Request</label>
                        </div>
                    </div>
                </div>{* End row *}
                
                <hr>
                
                <div class="row">
                    <div class='col-md-11'>
                    </div>
                    <div class='col-md-1'>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
  
            </form>
            
        </div>

        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        
        <!-- Bootstrap -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        
        <!-- Javascript libraries for datetimepicker -->
        <script src="js/moment.min.js"></script> <!-- moment.js -->
        <script src="js/bootstrap-datetimepicker.js"></script> <!-- datetimepicker -->
        
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker6').datetimepicker();
                $('#datetimepicker7').datetimepicker();
                $("#datetimepicker6").on("dp.change", function (e) {
                    $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
                });
                $("#datetimepicker7").on("dp.change", function (e) {
                    $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
                });
            });
        </script>
        
        
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker10').datetimepicker({
                    viewMode: 'years',
                    format: 'MM/YYYY'
                });
            });
        </script>
        
    </body>
</html>