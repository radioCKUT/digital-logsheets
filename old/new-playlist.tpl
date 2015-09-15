<!DOCTYPE html>
<html>
    <head>
        <title></title>
        
        <!-- Script for adding form fields -->
        <script src="js/dynamic_form.js"></script>
    </head>
    <body>
        <form id="logsheet" action="savePlaylist.php" method="post" autocomplete="on">
            <div>
                Name: <input type="text" name="name[]">
                Author: <input type="text" name="author[]">
                Category: {html_options name="category[]" options=$categories}
                <a href="#" onClick="cloneRow(event)">add</a>
                <a href="#" onClick="removeRow(event)">remove</a>
                <br>
            </div>
            <input type="submit" value="submit"/>
        </form>
    </body>
</html>