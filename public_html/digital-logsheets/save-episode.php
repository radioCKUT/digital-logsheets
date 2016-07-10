<?php
include_once('../../digital-logsheets-res/php/database/connectToDatabase.php');
include_once("../../digital-logsheets-res/php/database/manageEpisodeEntries.php");
include_once("../../digital-logsheets-res/php/database/managePlaylistEntries.php");
include_once("../../digital-logsheets-res/php/database/manageSegmentEntries.php");

$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$programId = $_POST['program'];

$prerecord = isset($_POST['prerecord']);
$prerecord_date = $_POST['prerecord_date'];

$episodeStartTime = $_POST['start_datetime'];
$episodeDuration = $_POST['episode_duration'];
$comment = $_POST['comment'];

session_start();

try {
    $db = connectToDatabase();

    $programmerId = 1; //TODO change programmerId once settled how programmers will be stored
    $playlistId = managePlaylistEntries::createNewPlaylist($db);

    $episodeStartTime = new DateTime($episodeStartTime, new DateTimeZone('America/Montreal'));

    $episode_end_time = clone $episodeStartTime;
    $episodeDurationMins = ($episodeDuration*60);
    $episodeDurationDateInterval = new DateInterval('PT' . $episodeDurationMins . 'M');
    $episode_end_time->add($episodeDurationDateInterval);

    $episodeObject = new Episode($db, null);

    $episodeObject->setPlaylist(new Playlist($db, $playlistId));
    $episodeObject->setProgram(new Program($db, $programId));
    $episodeObject->setProgrammer(new Programmer($db, $programmerId));
    $episodeObject->setStartTime($episodeStartTime);
    $episodeObject->setEndTime($episode_end_time);
    $episodeObject->setIsPrerecord($prerecord);
    $episodeObject->setPrerecordDate($prerecord_date);
    $episodeObject->setComment($comment);

    $episodeId = manageEpisodeEntries::saveNewEpisode($db, $episodeObject);

    $_SESSION["episodeId"] = $episodeId;

    header('Location: add-segments.php');

} catch(PDOException $e) {
    error_log('Error while saving an episode: ' . $e->getMessage());
    //TODO: error handling
}

