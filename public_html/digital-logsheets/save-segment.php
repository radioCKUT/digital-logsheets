<?php

require_once("../../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../../digital-logsheets-res/php/objects/Episode.php");

$episodeId = $_POST['episode_id'];

$segmentTime = $_POST['segmentTime'];
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
    error_log("episode id received by save segment: " . $episodeId . ", segmentTime: " . $segmentTime);
    outputErrorResponse("Invalid episode ID");
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
    
    if ($editSegment) {
        error_log("segment id: " . $segment->getId());
        $segment->setId($segmentId);
        manageSegmentEntries::editSegmentInDatabase($db, $segment);
    } else {
        manageSegmentEntries::saveNewSegmentToDatabase($db, $segment);
    }

    $episode = new Episode($db, $episodeId);
    $segmentList = $episode->getSegments();

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

function addDateToSegmentStartTime($episodeStartDateTime, $segmentTime) {

    $dateToUse = $episodeStartDateTime->format("Y-m-d");
    $episodeStartTimeString = $episodeStartDateTime->format("H:i:s");

    if (strtotime($segmentTime) < strtotime($episodeStartTimeString)) {
        $dayAfterEpisodeStartDateTime = clone $episodeStartDateTime;
        $dayAfterEpisodeStartDateTime->add(new DateInterval('P1D'));
        $dateToUse = $dayAfterEpisodeStartDateTime->format("Y-m-d");
    }
    
    $segmentTimeString = $dateToUse . " " . $segmentTime;
    $segmentDateTime = new DateTime($segmentTimeString, new DateTimeZone('America/Montreal'));

    return $segmentDateTime;
}