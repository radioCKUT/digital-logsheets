<?php

require_once("../../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../../digital-logsheets-res/php/objects/Episode.php");

$episodeId = $_POST['episode_id'];

$segmentTime = $_POST['segmentTime'];
$name = $_POST['name'];
$author = $_POST['author'];
$album = $_POST['album'];
$category = $_POST['category'];

$canCon = isset($_POST['can_con']);
$newRelease = isset($_POST['new_release']);
$frenchVocalMusic = isset($_POST['french_vocal_music']);

if (!isset($episodeId) || $episodeId <= 0) {
    outputErrorResponse("Invalid episode ID");
}

try {
    $db = connectToDatabase();

    $episode = new Episode($db, $episodeId);
    $segmentList = $episode->getSegments();

    $db = null;

    outputSuccessResponse($segmentList);

} catch(PDOException $e) {
    $db = null;
    error_log("get_segments error: " . $e->getMessage());
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
    $responseJSON = json_encode($response);
    echo $responseJSON;
    exit();
}

function addDateToSegmentStartTime($episodeStartDate, $episodeStartTime, $segmentTime) {

    $dateToUse = $episodeStartDate;
    error_log("segmentTime: " . $segmentTime . " episodeStartTime " . $episodeStartTime);

    if (strtotime($segmentTime) < strtotime($episodeStartTime)) {
        $episodeStartDateTimestamp = strtotime($episodeStartDate);
        $dayAfterStartDateTimestamp = strtotime('+1 day', $episodeStartDateTimestamp);
        $dateToUse = date("Y-m-d", $dayAfterStartDateTimestamp);

    }

    error_log("dateToUse: " . $dateToUse);

    $segmentTimeWithDate = strtotime($dateToUse . " " . $segmentTime);
    $segmentTime = date("Y-m-d H:m:s", $segmentTimeWithDate);

    return $segmentTime;
}