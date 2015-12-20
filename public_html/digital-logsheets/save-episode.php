<?php
include_once('../../digital-logsheets-res/php/database/connectToDatabase.php');
include_once("../../digital-logsheets-res/php/database/manageEpisodeEntries.php");
include_once("../../digital-logsheets-res/php/database/managePlaylistEntries.php");
include_once("../../digital-logsheets-res/php/database/manageSegmentEntries.php");

error_reporting(E_ALL ^ E_NOTICE);

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$programId = $_POST['program'];

$prerecord = $_POST['prerecord'];
$prerecord_date = $_POST['prerecord_date'];

$episode_start_date = $_POST['start_date'];
$episode_start_time = $_POST['start_time'];
$episode_end_time = $_POST['end_time'];
$comment = $_POST['comment']; //TODO: table with comment column

session_start();

try {
    $db = connectToDatabase();

    $programmerId = 1; //TODO change programmerId once settled how programmers will be stored
    $playlistId = managePlaylistEntries::createNewPlaylist($db);
    $programId = 1; //TODO get actual program id from input

    $episode_id = manageEpisodeEntries::saveNewEpisode($db, $playlistId, $programId, $programmerId,
        $episode_start_time, $episode_end_time, isset($prerecord), $prerecord_date);

    $_SESSION["episode_id"] = $episode_id;

    header('Location: add-segments.php');

} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}