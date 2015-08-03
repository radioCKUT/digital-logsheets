<?php
    include("smarty/libs/Smarty.class.php");
    include("function-definitions.php");
    
    // create object
    $smarty = new Smarty;
    
    //connect to database
    $db = connectToDatabase();
    
    //assign categories to smarty variable
    $programs = mapIDtoName($db, "program");
    $smarty->assign("programs", $programs);
    
    //assign categories to smarty variable
    $categories = mapIDtoName($db, "category");
    $smarty->assign("categories", $categories);
    
    //close database connection
    $db = NULL;
    
    // display it
    echo $smarty->fetch('new-logsheet.tpl');
?>