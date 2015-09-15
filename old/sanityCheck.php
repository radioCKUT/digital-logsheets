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
        
        <link rel="stylesheet" href="jscss.css">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>
    
    <body>
        <div class="container">
        	<div class="row">
        		<input type="hidden" name="count" value="1" />
                <div class="control-group" id="fields">
                    <label class="control-label" for="field1">Nice Multiple Form Fields</label>
                    <div class="controls" id="profs"> 
                        <form class="input-append">
                            <div id="field"><input autocomplete="off" class="input" id="field1" name="prof1" type="text" placeholder="Type something" data-items="8"/><button id="b1" class="btn add-more" type="button">+</button></div>
                        </form>
                    <br>
                    <small>Press + to add another form field :)</small>
                    </div>
                </div>
        	</div>
        </div>
        <script type="text/javascript" src="js/dynamic_form.js"></script>
    </body>
</html>