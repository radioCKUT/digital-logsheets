<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Edit Genres</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        
        <!-- datetimepicker -->
        <link rel="stylesheet" href="/css/bootstrap-datetimepicker.css">
    </head>
    
    <body>
        <div class="container">
            <div class="row">
                <h1>
                    Current genres:
                </h1>
            </div>
            <div class="row">
                <ul>
                    <!--Fill in variables for each row from database-->
                    {foreach $genres as $genre}
                    {strip}
                    <li>{$genre.name}</li>
                    {/strip}
                    {/foreach}
                </ul>
            </div>
        </div>
        <div class="container">
            <form id="new-genre" role="form" action="saveGenre.php" method="post">
                <div class="row">
                    <div class="form-group">
                      <label for="genre">Name of New Genre:</label>
                      <input type="text" class="form-control" id="genre" name="genre">
                    </div>
                </div>
                <div class="row">
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
            </form>
        </div>

        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        
        <!-- Bootstrap -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        </script>
        
    </body>
</html>