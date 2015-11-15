<?php
    //----INCLUDE FILES----
    include('smarty/libs/Smarty.class.php');
    include("connectToDatabase.php");
    include("dev-mode.php");
    require_once("objects/logsheet-classes.php");
    

    //open database connection
    $db = connectToDatabase();
    
    //close database connection
    $db = NULL;
?>