<?php

require_once("../../digital-logsheets-res/smarty/libs/Smarty.class.php");
require_once("../../digital-logsheets-res/php/database/manageSegmentEntries.php");
require_once("../../digital-logsheets-res/php/objects/Episode.php");
require_once("../../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../../digital-logsheets-res/php/objects/logsheetClasses.php");

   $episode_id = $_GET["episode_id"];


    if ($episode_id != null) {

        try {
            $smarty = new Smarty();

            $db_conn = connectToDatabase();

            $episode = new Episode($db_conn, $episode_id);
            $segments = $episode->getSegments();

            $episode_as_array = $episode->getObjectAsArray();

            $segmentsForThisEpisode = manageSegmentEntries::getAllSegmentsForEpisodeId($db_conn, $episode_id);

            for($i = 0; $i < count($segmentsForThisEpisode); $i++) {
                $currentSegment = $segmentsForThisEpisode[$i];
                $segmentsForThisEpisode[$i] = $currentSegment->getObjectAsArray();
            }

            $smarty->assign("episode", $episode_as_array);
            $smarty->assign("segments", $segmentsForThisEpisode);


            // display it
            echo $smarty->fetch('../../digital-logsheets-res/templates/view-episode-logsheet.tpl');
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }


    }