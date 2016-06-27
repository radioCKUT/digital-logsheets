<?php
include_once('../../digital-logsheets-res/php/database/connectToDatabase.php');
include_once("../../digital-logsheets-res/php/database/manageEpisodeEntries.php");
include_once("../../digital-logsheets-res/php/database/managePlaylistEntries.php");
include_once("../../digital-logsheets-res/php/database/manageSegmentEntries.php");

error_reporting(E_ALL ^ E_NOTICE);

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$programId = $_POST['program'];

$prerecord = isset($_POST['prerecord']);
$prerecord_date = $_POST['prerecord_date'];

$episode_start_time = $_POST['start_datetime'];
$episode_duration = $_POST['episode_duration'];
$comment = $_POST['comment'];

session_start();

try {
    $db = connectToDatabase();

    $programmerId = 1; //TODO change programmerId once settled how programmers will be stored
    $playlistId = managePlaylistEntries::createNewPlaylist($db);

    $episode_start_time = new DateTime($episode_start_time, new DateTimeZone('America/Montreal'));

    $episode_end_time = clone $episode_start_time;
    $episode_duration_mins = ($episode_duration*60);
    $episodeDurationDateInterval = new DateInterval('PT' . $episode_duration_mins . 'M');
    $episode_end_time->add($episodeDurationDateInterval);

    $episode_object = new Episode($db, null);

    $episode_object->setPlaylist(new Playlist($db, $playlistId));
    $episode_object->setProgram(new Program($db, $programId));
    $episode_object->setProgrammer(new Programmer($db, $programmerId));
    $episode_object->setStartTime($episode_start_time);
    $episode_object->setEndTime($episode_end_time);
    $episode_object->setIsPrerecord($prerecord);
    $episode_object->setPrerecordDate($prerecord_date);
    $episode_object->setComment($comment);

    $episode_id = manageEpisodeEntries::saveNewEpisode($db, $episode_object);

    $_SESSION["episode_id"] = $episode_id;

    header('Location: add-segments.php');

} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

