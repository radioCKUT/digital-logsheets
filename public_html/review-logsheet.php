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
require_once("../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../digital-logsheets-res/php/objects/logsheetClasses.php");
require_once("../digital-logsheets-res/php/validator/PlaylistValidator.php");
require_once("../digital-logsheets-res/php/validator/errorContainers/SavePlaylistErrors.php");
include('session.php');

// create object
$smarty = new Smarty;

//database interactions
try {
    //connect to database
    $db = connectToDatabase();

    $episodeId = $_GET['epId'];

    $episode = new Episode($db, $episodeId);

    if (!$episode->doesEpisodeExist()) {
        header('HTTP/1.1 400 Bad Request', true, 400);
        echo $smarty->fetch('../digital-logsheets-res/templates/error.tpl');
        exit();
    }

    $playlistValidator = new PlaylistValidator($episode);
    $playlistErrors = $playlistValidator->checkFinalSaveValidity();

    if ($playlistErrors->doErrorsExist()) {
        $playlistErrorsAsQuery = http_build_query(array(
            'epId' => $episodeId,
            'formErrors' => $playlistErrors->getAllErrors()
        ));

        header('Location: add-segments.php?' . $playlistErrorsAsQuery);
        exit();
    }

/*    $episodeValidator = new EpisodeValidator($episode);
    $episodeErrors = $episodeValidator->checkFinalSaveValidity();*/

    $segments = $episode->getSegments();

    foreach ($segments as $segment) {
        $segmentValidator = new SegmentValidator($segment, $episode);
        $segmentErrors = $segmentValidator->isSegmentValidForFinalSave();

        if ($segmentErrors->doErrorsExist()) {
            $formErrorsArray = array('formErrors' => array('erroneousSegmentsExist' => true));
            $errorAsQuery = http_build_query($formErrorsArray);
            header('Location: add-segments.php?' . $errorAsQuery);
            exit();
        }
    }




    $segments = $episode->getSegments();
    $episodeEndTime = $episode->getEndTime();

    $segments = computeSegmentDurations($segments, $episodeEndTime);

    foreach ($segments as $segment) {
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

    $smarty->assign("episodeId", $episodeId);
    $smarty->assign("episode", $episodeAsArray);
    $smarty->assign("segments", $segmentsForThisEpisode);


    // display it
    echo $smarty->fetch('../digital-logsheets-res/templates/review-logsheet.tpl');
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

/**
 * @param Segment[] $segments
 * @param DateTime $episodeEndTime
 * @return mixed
 */
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

        $durationMinutes = $duration / 60;
        $currentSegment->setDuration($durationMinutes);
    }

    return $segments;
}