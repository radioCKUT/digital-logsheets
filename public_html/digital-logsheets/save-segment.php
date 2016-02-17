<?php

require_once("../../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../../digital-logsheets-res/php/objects/Episode.php");

$episode_id = $_POST['episode_id'];

$segment_time = $_POST['segment_time'];
$name = $_POST['name'];
$ad_number = $_POST['ad_number'];
$author = $_POST['author'];
$album = $_POST['album'];
$category = $_POST['category'];

$can_con = isset($_POST['can_con']);
$new_release = isset($_POST['new_release']);
$french_vocal_music = isset($_POST['french_vocal_music']);

if (!isset($episode_id) || $episode_id <= 0) {
    outputErrorResponse("Invalid episode ID");
}

try {
    $db = connectToDatabase();

    $episode = new Episode($db, $episode_id);

    $episodeStartDateTime = $episode->getStartTime();

    $segment_time = addDateToSegmentStartTime($episodeStartDateTime, $segment_time);

    $playlist_id = $episode->getPlaylistId();

    switch ($category) {
        case 2:
        case 3:
            manageSegmentEntries::saveNewSegmentToDatabase($db, $segment_time, null, $name, $author,
                $album, $category, $can_con, $new_release, $french_vocal_music, null, $playlist_id);
            break;

        case 5:
            manageSegmentEntries::saveNewSegmentToDatabase($db, $segment_time, null, $ad_number, null,
                null, 5, false, false, false, $ad_number, $playlist_id);
            break;

        case 4:
            manageSegmentEntries::saveNewSegmentToDatabase($db, $segment_time, null, $name, null,
                null, $category, false, false, false, null, $playlist_id); //TODO: add hide from listener, add station ID given
            break;

        case 1:
        default:
            manageSegmentEntries::saveNewSegmentToDatabase($db, $segment_time, null, $name, $author,
                $album, $category, false, false, false, null, $playlist_id); //TODO: add hide from listener, add station ID given
            break;
    }



    $episode = new Episode($db, $episode_id);
    $segment_list = $episode->getSegments();

    $db = null;

    outputSuccessResponse($segment_list);

} catch(PDOException $e) {
    $db = null;
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

function addDateToSegmentStartTime($episodeStartDateTime, $segment_time) {

    $dateToUse = $episodeStartDateTime->format("Y-m-d");
    $episodeStartTimeString = $episodeStartDateTime->format("H:i:s");

    if (strtotime($segment_time) < strtotime($episodeStartTimeString)) {
        $dayAfterEpisodeStartDateTime = clone $episodeStartDateTime;
        $dayAfterEpisodeStartDateTime->add(new DateInterval('P1D'));
        $dateToUse = $dayAfterEpisodeStartDateTime->format("Y-m-d");
    }

    error_log("segmentTimeString: " . $dateToUse . " " . $segment_time);

    $segmentTimeString = $dateToUse . " " . $segment_time;
    $segmentDateTime = new DateTime($segmentTimeString, new DateTimeZone('America/Montreal'));

    return $segmentDateTime;
}