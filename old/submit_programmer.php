<?php
    include("smarty/libs/Smarty.class.php");
    include("function-definitions.php");
    
    // create object
    $smarty = new Smarty;
    
    //connect to database
    $db = connectToDatabase();
    
    //close database connection
    $db = NULL;
    
    // display it
    echo $smarty->fetch('submit_programmer.tpl');
?>