<?php
    include('../smarty/libs/Smarty.class.php');
    require("function-definitions.php");
    
    // create object
    $smarty = new Smarty;
    
    //get all episodes from database
    $db = connectToDatabase();
    
    $db = NULL;
    
    // display it
    echo $smarty->fetch('index.tpl');
?>