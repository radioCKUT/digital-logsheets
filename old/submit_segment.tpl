<!DOCTYPE html>
<html>
    <head>
        <title>Submit a new segment</title>
    </head>
    
    <body>
        <form action="createSegment.php" method="GET">
            Title: <input type="text" name="name"><br>
            Artist: <input type="text" name="author"><br>
            Album: <input type="text" name="album"><br>
            <select name="category">
                {html_options values=$id output=$categories}
            </select><br>
            <input type="checkbox" name="can_can"> CC
            <input type="submit">
        </form>
    </body>
</html>