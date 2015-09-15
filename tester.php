<?php
    //----INCLUDE FILES----
    include('smarty/libs/Smarty.class.php');
    include("database.php");
    include("dev-mode.php");
    require_once("objects/logsheet-classes.php");
    

    //open database connection
    $db = connectToDatabase();
    $prgm = new Program($db);
    $prgm->setId("1");
    echo $prgm->getName();
        
    //close database connection
    $db = NULL;
?>