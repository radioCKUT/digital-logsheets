<?php

require_once("../../digital-logsheets-res/smarty/libs/Smarty.class.php");
require_once("../../digital-logsheets-res/php/database/manageSegmentEntries.php");
require_once("../../digital-logsheets-res/php/objects/Episode.php");
require_once("../../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../../digital-logsheets-res/php/objects/logsheetClasses.php");

   $episodeId = $_GET["episode_id"];


    if ($episodeId != null) {

        try {
            $smarty = new Smarty();

            $dbConn = connectToDatabase();

            $episode = new Episode($dbConn, $episodeId);
            $segments = $episode->getSegments();

            $episodeAsArray = $episode->getObjectAsArray();

            $segmentsForThisEpisode = manageSegmentEntries::getAllSegmentsForEpisodeId($dbConn, $episodeId);

            for($i = 0; $i < count($segmentsForThisEpisode); $i++) {
                $currentSegment = $segmentsForThisEpisode[$i];
                $segmentsForThisEpisode[$i] = $currentSegment->getObjectAsArray();
            }

            $smarty->assign("episode", $episodeAsArray);
            $smarty->assign("segments", $segmentsForThisEpisode);


            // display it
            echo $smarty->fetch('../../digital-logsheets-res/templates/view-episode-segment.tpl');
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }


    }