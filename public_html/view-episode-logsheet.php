<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2017  Evan Vassallo
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once("../digital-logsheets-res/smarty/libs/Smarty.class.php");
require_once("../digital-logsheets-res/php/database/manageSegmentEntries.php");
require_once("../digital-logsheets-res/php/objects/Episode.php");
require_once("../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../digital-logsheets-res/php/objects/logsheetClasses.php");
include('session.php');

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
            echo $smarty->fetch('../digital-logsheets-res/templates/view-episode-logsheet.tpl');
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }


    }