<?php

require_once("../../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../../digital-logsheets-res/php/objects/Episode.php");
require("../../digital-logsheets-res/php/validator/SegmentValidator.php");
require("../../digital-logsheets-res/php/validator/errorContainers/SaveSegmentErrors.php");

$episodeId = $_POST['episode_id'];

$segmentTime = $_POST['segment_time'];
$name = $_POST['name'];
$adNumber = $_POST['ad_number'];
$author = $_POST['author'];
$album = $_POST['album'];
$category = $_POST['category'];

$canCon = isset($_POST['can_con']);
$newRelease = isset($_POST['new_release']);
$frenchVocalMusic = isset($_POST['french_vocal_music']);

$editSegment = isset($_POST['is_existing_segment']);
$segmentId = $_POST['segment_id'];

if (!isset($episodeId) || $episodeId <= 0) {
    outputErrorResponse("Invalid episode ID", $editSegment);
}

try {
    $db = connectToDatabase();

    $episode = new Episode($db, $episodeId);

    $episodeStartDateTime = $episode->getStartTime();

    $segmentTime = addDateToSegmentStartTime($episodeStartDateTime, $segmentTime);

    $playlistId = $episode->getPlaylistId();

    $segment = new Segment($db, $segmentId);
    $segment->setCategory($category);
    $segment->setPlaylistId($playlistId);
    $segment->setDuration(null);
    $segment->setStartTime($segmentTime);

    switch ($category) {
        case 2:
        case 3:
            $segment->setName($name);
            $segment->setAuthor($author);
            $segment->setAlbum($album);
            $segment->setCategory($category);
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

    $errorsContainer = $segment->isValidForDraftSave($episode);

    if ($errorsContainer->doErrorsExist()) {
        $errorsList = $errorsContainer->getAllErrors();
        outputErrorResponse(json_encode($errorsList));
    };

    if ($editSegment) {
        $segment->setId($segmentId);

        $segmentErrors = $segmentValidator->isSegmentValidForEdit();

        if ($segmentErrors->doErrorsExist()) {
            outputErrorResponse($segmentErrors->getAllErrors(), $editSegment);

        } else {
            manageSegmentEntries::editSegmentInDatabase($db, $segment);
        }

    } else {
        $segmentErrors = $segmentValidator->isSegmentValidForDraftSave();

        if ($segmentErrors->doErrorsExist()) {
            outputErrorResponse($segmentErrors->getAllErrors(), $editSegment);

        } else {
            error_log('save new segment to db');
            manageSegmentEntries::saveNewSegmentToDatabase($db, $segment);
        }
    }

    $episode = new Episode($db, $episodeId);
    $segmentList = $episode->getSegments();

    $db = null;

    outputSuccessResponse($segmentList);

} catch(PDOException $e) {
    $db = null;
    outputErrorResponse($e->getMessage(), $editSegment);
}



function outputSuccessResponse($data) {
    outputResponse($data);
}

function outputErrorResponse($errorMessage, $wasEditing) {
    $errorArray = array(
        "error" => $errorMessage,
        "wasEditing" => $wasEditing);

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
        $errorsContainer = new SaveSegmentErrors();
        $errorsContainer->markStartTimeInvalidFormat();
        outputErrorResponse($errorsContainer->getAllErrors());
    }

    if (strtotime($segmentTime) < strtotime($episodeStartTimeString)) {
        $dayAfterEpisodeStartDateTime = clone $episodeStartDateTime;
        $dayAfterEpisodeStartDateTime->add(new DateInterval('P1D'));
        $dateToUse = $dayAfterEpisodeStartDateTime->format("Y-m-d");
    }
    
    $segmentTimeString = $dateToUse . " " . $segmentTime;
    $segmentDateTime = new DateTime($segmentTimeString, new DateTimeZone('America/Montreal'));

    return $segmentDateTime;
}