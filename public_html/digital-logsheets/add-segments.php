<?php
    //----INCLUDE FILES----
    include_once("../../digital-logsheets-res/smarty/libs/Smarty.class.php");
    include_once("../../digital-logsheets-res/php/database/connectToDatabase.php");
    include_once("../../digital-logsheets-res/php/database/manageCategoryEntries.php");
    include_once("../../digital-logsheets-res/php/database/manageProgramEntries.php");
    require_once("../../digital-logsheets-res/php/objects/logsheet-classes.php");

    // create object
    $smarty = new Smarty;

    session_start();

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

        $episode_id = $_SESSION['episode_id'];
        $smarty->assign("episode_id", $episode_id);

        // display it
        echo $smarty->fetch('../../digital-logsheets-res/templates/add-segments.tpl');
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }