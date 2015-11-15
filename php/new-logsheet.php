<?php
    //----INCLUDE FILES----
    include("../smarty/libs/Smarty.class.php");
    include("dev-mode.php");
    include_once("database/connectToDatabase.php");
    include_once("database/readFromDatabase.php");
    require_once("objects/logsheet-classes.php");
    
    // create object
    $smarty = new Smarty;
    
    //database interactions
    try {
        //connect to database
        $db = connectToDatabase();
        
        $categories = getAllCategoriesFromDatabase($db);
        $programs = getAllProgramsFromDatabase($db);
        
        //close database connection
        $db = NULL;
        
        //assign categories to smarty variable
        $smarty->assign("programs", $programs);
        
        //assign categories to smarty variable
        $smarty->assign("categories", $categories);
        
        // display it
        echo $smarty->fetch('new-logsheet.tpl');
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
?>