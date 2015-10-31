<!DOCTYPE html>
<html>
    <head>
        <title> </title>
        
        <!-- Script for adding form fields -->
        <script src="js/dynamic_form.js"></script>
    </head>
    <body>
        <form id="logsheet" action="save-logsheet.php" method="post">
            <div>
                First Name: <input type="text" name="first_name"><br />
                Last Name: <input type="text" name="last_name"><br />
                Program: {html_options name="program" options=$programs}<br />
                <input type="checkbox" name="prerecord" value="prerecord">Pre-recorded &nbsp; Pre-recorded Date: <input type="date" name="prerecord_date"><br />
                Start Time: <input type="datetime-local" name="start_time"><br />
                End Time: <input type="datetime-local" name="end_time"><br />
                Comment: <input type="text" name="comment"><br />
            </div>
            
            <hr>
            
            <div>
                Time: <input type="datetime-local" name="segment_time[]">
                Duration: <input type="time" name="duration[]">
                Name: <input type="text" name="name[]">
                Author: <input type="text" name="author[]">
                Category: {html_options name="category[]" options=$categories}
                CanCon: <input type="checkbox" name="cancon[]">
                New Release: <input type="checkbox" name="new_release[]">
                French Vocal Music: <input type="checkbox" name="french_vocal[]">
                Request: <input type="checkbox" name="request[]">
                <a href="#" onClick="cloneRow(event)">add</a>
                <a href="#" onClick="removeRow(event)">remove</a>
                <br>
            </div>
            
            <input type="submit" value="Continue">
        </form>
    </body>
</html>