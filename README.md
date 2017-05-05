# digital-logsheets

A web-based application for tracking the playback of audio segments on a community radio station. Developed by Michael Dean and Evan Vassallo for CKUT 90.3FM in Montréal, Canada. Driven by PHP, MySQL and the Smarty templating system.

## Deployment

1. Add the contents of the public_html folder into the public document root. Do not simply place the folder into the public document root.
2. Add the digital-logsheets-res folder itself into the public document root’s parent folder.
3. Add a databaseLogin.php file to digital-logsheets-res/php/database. It should have the following contents, replacing PLACEHOLDER with a string literal corresponding to your database environment:

```
<?php
function getPDOStatementWithLogin() {
    //server settings
    $serverName = PLACEHOLDER;
    $port = PLACEHOLDER;

    //database settings
    $database = PLACEHOLDER;
    $username = PLACEHOLDER;
    $password = PLACEHOLDER;

    return new PDO("mysql:host=$serverName;port=$port;dbname=$database",$username,$password);
}
?>
```