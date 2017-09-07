<!DOCTYPE HTML>
<html>
<head>

    <title>logsheet login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        body {
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
<body>

<div id="login">
    <form method="post" action="" name="login" class="form-horizontal">
        <div class="row">
            <div class="col-sm-2 col-sm-offset-2">
                <h3>Digital Logsheets Login</h3>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="username">Username</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="username" autocomplete="off" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="password">Password</label>
            <div class="col-sm-2">
                <input type="password" class="form-control" name="password" autocomplete="off" />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2 col-sm-offset-2">
                {if $errMsg}
                    <p class="text-danger"> {$errMsg} </p>
                {/if}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-2 col-sm-offset-2">
                <input type="submit" class="btn btn-default" name="loginSubmit" value="Login">
            </div>
        </div>
    </form>
</div>
</body>
</html>