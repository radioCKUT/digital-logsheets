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
        
        <!-- Script for adding form fields -->
        <script src="js/dynamic_form.js"></script>
    </head>
    
    <body>
        <div class="container">
            <h2>Current segments</h2>
            <p>The existing segments in the database</p>    
            
            <table class="table table-condensed">
                
                <!--Table headers-->
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Artist</th>
                    </tr>
                </thead>
                
                <!--Table body-->
                <tbody>
                    <!--Fill in variables for each row from database-->
                    {foreach $segments as $segment}
                    {strip}
                    <tr>
                        <td>{$segment.id}</td>
                        <td>{$segment.name}</td>
                        <td>{$segment.author}</td>
                    </tr>
                    {/strip}
                    {/foreach}
                </tbody>
                
            </table>
        
            <!--This needs to be dynamic-->
            <form id="logsheet" role="form" action="savePlaylist.php" method="POST">
                
                <div class="row form-inline">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Segment Title" name="name[]">
                    </div>{* End form-group *}
                    
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Artist/Author" name="author[]">
                    </div>{* End form-group *}
                    
                    <div class="form-group category-select">
                        {html_options class="form-control" name="category[]" options=$categories}
                    </div>{* End form-group *}
            
                    <button type="button" class="btn btn-default" onclick="cloneRow()" style="white-space: normal">
                         <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </div>{* End row *}
                
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
            
        </div><!--end bootstrap container-->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </body>
</html>