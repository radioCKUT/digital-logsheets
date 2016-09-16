<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2016  Evan Vassallo
 * Copyright (C) 2016  James Wang
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

/**
 * Created by PhpStorm.
 * User: Evan
 * Date: 2016-03-24
 * Time: 7:40 PM
 */

require_once("../../digital-logsheets-res/smarty/libs/Smarty.class.php");
require_once("../../digital-logsheets-res/php/database/manageSegmentEntries.php");
require_once("../../digital-logsheets-res/php/objects/Episode.php");
require_once("../../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../../digital-logsheets-res/php/objects/logsheetClasses.php");

// create object
$smarty = new Smarty;

session_start();


//database interactions
try {
    //connect to database
    $db = connectToDatabase();

    $episodeId = $_SESSION['episodeId'];

    $episode = new Episode($db, $episodeId);
    $segments = $episode->getSegments();
    $episodeEndTime = $episode->getEndTime();

    $segments = computeSegmentDurations($segments, $episodeEndTime);

    foreach ($segments as $segment) {
        error_log("about to edit segment duration");
        manageSegmentEntries::editExistingSegmentDuration($db, $segment);
    }

    $episodeAsArray = $episode->getObjectAsArray();
    
    $segmentsForThisEpisode = manageSegmentEntries::getAllSegmentsForEpisodeId($db, $episodeId);

    for($i = 0; $i < count($segmentsForThisEpisode); $i++) {
        $currentSegment = $segmentsForThisEpisode[$i];
        $segmentsForThisEpisode[$i] = $currentSegment->getObjectAsArray();
    }

    //close database connection
    $db = NULL;

    $smarty->assign("episode", $episodeAsArray);
    $smarty->assign("segments", $segmentsForThisEpisode);


    // display it
    echo $smarty->fetch('../../digital-logsheets-res/templates/review-logsheet.tpl');
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

function computeSegmentDurations($segments, $episodeEndTime) {
    $segmentCount = count($segments);

    for ($i = 0; $i < $segmentCount; $i++) {
        $currentSegment = $segments[$i];
        $currentSegmentStartDateTime = $currentSegment->getStartTime();
        $currentSegmentStartTimeStamp = $currentSegmentStartDateTime->getTimestamp();

        if ($i < ($segmentCount - 1)) {
            $nextSegment = $segments[$i+1];
            $nextSegmentStartDateTime = $nextSegment->getStartTime();
            $nextSegmentStartTimestamp = $nextSegmentStartDateTime->getTimestamp();

            $duration = $nextSegmentStartTimestamp - $currentSegmentStartTimeStamp;

        } else {
            $episodeEndTimeStamp = $episodeEndTime->getTimestamp();
            $duration = $episodeEndTimeStamp - $currentSegmentStartTimeStamp;
        }

        error_log("duration: " . $duration);

        $durationMinutes = $duration/60;
        error_log("duration minutes: " . $durationMinutes);
        $currentSegment->setDuration($durationMinutes);
    }

    return $segments;
}