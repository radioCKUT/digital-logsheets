<?php
    //----INCLUDE FILES----
    include('../../digital-logsheets-res/smarty/libs/Smarty.class.php');
    include("../../digital-logsheets-res/php/database/connectToDatabase.php");
    require_once("../../digital-logsheets-res/php/objects/logsheetClasses.php");
    require_once("../../digital-logsheets-res/php/select2-preparation.php");
    
    // create object
    $smarty = new Smarty;
    
    //database interactions
    try {
        //open database connection
        $db = connectToDatabase();
        $archive = new Archive($db);
        $episodesArchive = $archive->getArchive();

        $episodes = array();
    
        foreach($episodesArchive as $episode) {
            $playlist = array();
            $segments = $episode->getPlaylist()->getSegments();
            
            //create the playlist for each episode
            foreach($segments as $segment) {
                $playlist[$segment->getId()] = $segment->getObjectAsArray();
            }
            
            //create an array to store each episode's data
            $episodes[$episode->getId()] = $episode->getObjectAsArray();
        }

        $programs = getSelect2ProgramsList($db);
        
        //close database connection
        $db = NULL;
        
        $smarty->assign("episodes", $episodes);
        $smarty->assign("programs", $programs);

        // display it
        echo $smarty->fetch('../../digital-logsheets-res/templates/index.tpl');
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }