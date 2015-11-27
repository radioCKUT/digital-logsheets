<?php
    //----INCLUDE FILES----
    include('../../digital-logsheets-res/smarty/libs/Smarty.class.php');
    include("../../digital-logsheets-res/php/database/connectToDatabase.php");
    include("../../digital-logsheets-res/php/dev-mode.php");
    require_once("../../digital-logsheets-res/php/objects/logsheet-classes.php");
    
    // create object
    $smarty = new Smarty;
    
    //database interactions
    try {
        //open database connection
        $db = connectToDatabase();
        $archive = new Archive($db);
        $episodes_archive = $archive->getArchive();

        $episodes = array();
    
        foreach($episodes_archive as $episode) {
            $playlist = array();
            $segments = $episode->getPlaylist();
            
            //create the playlist for each episode
            foreach($segments as $segment) {
                $playlist[$segment->getId()] = array(
                    "name"=>$segment->getName(),
                    "album"=>$segment->getAlbum(),
                    "author"=>$segment->getAuthor()
                );
            }
            
            //create an array to store each episode's data
            $episodes[$episode->getId()] = array(
                "program_name"=>$episode->getProgramName(),
                "start_date"=>$episode->getStartDate(),
                "start_time"=>$episode->getStartTime(),
                "end_time"=>$episode->getEndTime(),
                "playlist"=> $playlist
            );
        }
        
        //close database connection
        $db = NULL;
        
        $smarty->assign("episodes", $episodes);
    
        // display it
        echo $smarty->fetch('../../digital-logsheets-res/templates/index.tpl');
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

?>