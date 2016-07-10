<?php
    //----INCLUDE FILES----
    include_once("../../digital-logsheets-res/smarty/libs/Smarty.class.php");
    include_once("../../digital-logsheets-res/php/database/connectToDatabase.php");
    include_once("../../digital-logsheets-res/php/database/manageCategoryEntries.php");
    include_once("../../digital-logsheets-res/php/database/manageProgramEntries.php");
    require_once("../../digital-logsheets-res/php/objects/logsheetClasses.php");

    // create object
    $smarty = new Smarty;

    session_start();

    //database interactions
    try {
        //connect to database
        $db = connectToDatabase();

        $categories = manageCategoryEntries::getAllCategoriesFromDatabase($db);
        $programs = manageProgramEntries::getAllProgramsFromDatabase($db);

        $episode_id = $_SESSION['episode_id'];
        $episode = new Episode($db, $episode_id);
        $episode_array = $episode->getObjectAsArray();

        //close database connection
        $db = NULL;

        $smarty->assign("programs", $programs);
        $smarty->assign("categories", $categories);
        $smarty->assign("episode", $episode_array);

        // display it
        echo $smarty->fetch('../../digital-logsheets-res/templates/add-segments.tpl');
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }