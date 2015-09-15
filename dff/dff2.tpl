<!DOCTYPE html>
<html>
    <head>
        <title>Dynamic Form Fields Test</title>
       
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script>
            function addRow() {
                //get the form to add the elements
                var form = document.getElementById("tracks");
                
                //add a space between the element
                var br = document.createElement("br");
                form.appendChild(br);
                
                //create elements to add
                var formgroup = document.createElement("div");
                formgroup.className = "form-group";
                
                var input1 = document.createElement("input");
                input1.className="form-control";
                input1.type = "text";
                input1.name = "artist[]";
                
                var input2 = document.createElement("input");
                input2.className="form-control";
                input2.type = "text";
                input2.name = "song[]";
                
                form.appendChild(formgroup);
                formgroup.appendChild(input1);
                form.appendChild(formgroup);
                formgroup.appendChild(input2);
            }
        </script>
    </head>
    <body>
        <div class="container">
            <form class="form-inline" role="form" id="tracks" method="post" action="{$smarty.server.PHP_SELF}">
                <div class="form-group">
                    <input class="form-control" type="text" name="artist[]">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="song[]">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
                <button onClick="addRow()"><span class="glyphicon glyphicon-plus"></span></button>
                <br />
        </div>
    </body>
</html>