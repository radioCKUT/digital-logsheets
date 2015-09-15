<?php
    session_start();
    include("smarty/libs/Smarty.class.php");
    include("function-definitions.php");
    
    // create object
    $smarty = new Smarty;
    
    //connect to database
    $db = connectToDatabase();
    
    //assign categories to smarty variable
    $categories = mapIDtoName($db, "category");
    $smarty->assign("categories", $categories);
    
    // display it
    echo $smarty->fetch('new-playlist.tpl');
?>