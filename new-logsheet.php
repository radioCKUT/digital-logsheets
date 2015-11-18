<?php
    //----INCLUDE FILES----
    include("smarty/libs/Smarty.class.php");
    include("php/dev-mode.php");
    include_once("php/database/connectToDatabase.php");
    include_once("php/database/manageCategoryEntries.php");
    include_once("php/database/manageProgramEntries.php");
    require_once("php/objects/logsheet-classes.php");
    
    // create object
    $smarty = new Smarty;
    
    //database interactions
    try {
        //connect to database
        $db = connectToDatabase();
        
        $categories = manageCategoryEntries::getAllCategoriesFromDatabase($db);
        $programs = manageProgramEntries::getAllProgramsFromDatabase($db);
        
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