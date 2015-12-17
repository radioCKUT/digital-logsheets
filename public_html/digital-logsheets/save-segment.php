<?php

require_once("../../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../../digital-logsheets-res/php/objects/Episode.php");

$episode_id = $_POST['episode_id'];

$segment_time = $_POST['segment_time'];
$name = $_POST['name'];
$author = $_POST['author'];
$album = $_POST['album'];
$category = $_POST['category'];

$can_con = $_POST['can_con'];
$new_release = $_POST['new_release'];
$french_vocal_music = $_POST['french_vocal_music'];

if (!isset($episode_id) || $episode_id <= 0) {
    outputErrorResponse("Invalid episode ID");
}

try {
    $db = connectToDatabase();
    $episode = new Episode($db, $episode_id);

    $episode_start_date = $episode->getStartDate();
    $episode_start_time = $episode->getStartTime();

    $segment_time = addDateToSegmentStartTime($episode_start_date, $episode_start_time, $segment_time);

    $playlist_id = $episode->getPlaylistId();
    error_log("playlist id at save-segment.php: " . $playlist_id);

    manageSegmentEntries::saveNewSegmentToDatabase($db, $segment_time, 0, $name, $author,
        $album, 2/*$category*/, $can_con, $new_release, $french_vocal_music, $playlist_id);

    $episode = new Episode($db, $episode_id);
    $segment_list = $episode->getSegments();
    error_log("segment list: " . $segment_list[0]->getName());

    outputSuccessResponse($segment_list);

} catch(PDOException $e) {
    outputErrorResponse($e->getMessage());
}

function outputSuccessResponse($data) {
    outputResponse($data);
}

function outputErrorResponse($error_message) {
    $error_array = array("error" => $error_message);
    outputResponse($error_array);
}

function outputResponse($response) {
    header('Content-type: application/json');
    $response_json = json_encode($response);
    echo $response_json;
    exit();
}

function addDateToSegmentStartTime($episode_start_date, $episode_start_time, $segment_time) {

    $dateToUse = $episode_start_date;

    if (strtotime($segment_time) < strtotime($episode_start_time)) {
        $episodeStartDateTimestamp = strtotime($episode_start_date);
        $dayAfterStartDateTimestamp = strtotime('+1 day', $episodeStartDateTimestamp);
        $dateToUse = date("Y-m-d", $dayAfterStartDateTimestamp);
    }

    $segmentTimeWithDate = strtotime($dateToUse . " " . $segment_time);
    $segment_time = date("Y-m-d H:m:s", $segmentTimeWithDate);

    return $segment_time;
}