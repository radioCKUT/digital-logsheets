<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2017  Evan Vassallo
 * Copyright (C) 2017 Donghee Baik
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

require_once("../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../digital-logsheets-res/php/objects/Episode.php");
require_once("../digital-logsheets-res/php/validator/SegmentValidator.php");
require_once("../digital-logsheets-res/php/validator/errorContainers/SaveSegmentErrors.php");
require_once("../digital-logsheets-res/php/DataPreparationForUI.php");
include('session.php');

$episodeId = $_POST['episode_id'];

$segmentTime = $_POST['segment_time'];
$name = $_POST['name'];
$adNumber = $_POST['ad_number'];
$author = $_POST['author'];
$album = $_POST['album'];
$category = $_POST['category'];

$stationIdGiven = isset($_POST['station_id']);
$canCon = isset($_POST['can_con']);
$newRelease = isset($_POST['new_release']);
$frenchVocalMusic = isset($_POST['french_vocal_music']);

$editSegment = isset($_POST['is_existing_segment']);
$segmentId = $_POST['segment_id'];

if (!isset($episodeId) || $episodeId <= 0) {
    outputErrorResponse("Invalid episode ID");
}

try {
    $db = connectToDatabase();

    $episode = new Episode($db, intval($episodeId));
    $episodeStartDateTime = $episode->getStartTime();

    $segmentTime = addDateToSegmentStartTime($episodeStartDateTime, $segmentTime);

    $playlistId = $episode->getPlaylistId();

    $segment = new Segment($db, $segmentId);
    $segment->setCategory($category);
    $segment->setPlaylistId($playlistId);
    $segment->setDuration(null);
    $segment->setStartTime($segmentTime);
    $segment->setStationIdGiven($stationIdGiven);

    switch ($category) {
        case 2:
        case 3:
            $segment->setName($name);
            $segment->setAuthor($author);
            $segment->setAlbum($album);
            $segment->setIsCanCon($canCon);
            $segment->setIsNewRelease($newRelease);
            $segment->setIsFrenchVocalMusic($frenchVocalMusic);
            $segment->setAdNumber(null);
            break;

        case 5:
            $segment->setName(null);
            $segment->setAuthor(null);
            $segment->setAlbum(null);
            $segment->setIsCanCon(null);
            $segment->setIsNewRelease(null);
            $segment->setIsFrenchVocalMusic(null);
            $segment->setAdNumber($adNumber);
            break;

        case 4:
            $segment->setName($name);
            $segment->setAuthor(null);
            $segment->setAlbum(null);
            $segment->setIsCanCon(false);
            $segment->setIsNewRelease(false);
            $segment->setIsFrenchVocalMusic(false);
            $segment->setAdNumber(null);
            break;

        case 1:
        default:
            $segment->setName($name);
            $segment->setAuthor($author);
            $segment->setAlbum($album);
            $segment->setIsCanCon(false);
            $segment->setIsNewRelease(false);
            $segment->setIsFrenchVocalMusic(false);
            $segment->setAdNumber(null);
            break;
    }

    $segmentValidator = new SegmentValidator($segment, $episode);


    if ($editSegment) {
        $segment->setId($segmentId);

        $segmentErrors = $segmentValidator->isSegmentValidForEdit();

        if ($segmentErrors->doErrorsExist()) {
            outputErrorResponse($segmentErrors->getAllErrors());

        } else {
            manageSegmentEntries::editSegmentInDatabase($db, $segment);
        }


    } else {
        $segmentErrors = $segmentValidator->isSegmentValidForDraftSave();

        if ($segmentErrors->doErrorsExist()) {
            outputErrorResponse($segmentErrors->getAllErrors());

        } else {
            manageSegmentEntries::saveNewSegmentToDatabase($db, $segment);
        }
    }

    $episode = new Episode($db, $episodeId);
    $segmentList = getSegmentListWithErrors($episode);

    $db = null;

    outputSuccessResponse($segmentList);

} catch(PDOException $e) {
    $db = null;
    outputErrorResponse($e->getMessage());
}



function outputSuccessResponse($data) {
    outputResponse($data);
}

function outputErrorResponse($errorMessage) {
    $errorArray = array("error" => $errorMessage);
    outputResponse($errorArray);
}

function outputResponse($response) {
    header('Content-type: application/json');
    $responseJson = json_encode($response);
    echo $responseJson;
    exit();
}


/**
 * @param DateTime $episodeStartDateTime
 * @param $segmentTime
 * @return DateTime
 */
function addDateToSegmentStartTime($episodeStartDateTime, $segmentTime) {

    $dateToUse = $episodeStartDateTime->format("Y-m-d");
    $episodeStartTimeString = $episodeStartDateTime->format("H:i:s");

    if (!TimeValidator::isTimeInValidFormat($segmentTime)) {
        return null;
    }

    if (strtotime($segmentTime) < strtotime($episodeStartTimeString)) {
        $dayAfterEpisodeStartDateTime = clone $episodeStartDateTime;
        $dayAfterEpisodeStartDateTime->modify('+1 day');
        $dateToUse = $dayAfterEpisodeStartDateTime->format("Y-m-d");
    }
    
    $segmentTimeString = $dateToUse . " " . $segmentTime;
    $segmentDateTime = new DateTime($segmentTimeString, new DateTimeZone('America/Montreal'));

    return $segmentDateTime;
}