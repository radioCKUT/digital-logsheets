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
            <form action="createPlaylist.php" method="POST">
                Segment 1: <input type="number" name="s1"><br>
                Segment 2: <input type="number" name="s2"><br>
                Segment 3: <input type="number" name="s3"><br>
                <input type="submit">
            </form>
        </div><!--end bootstrap container-->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </body>
</html>