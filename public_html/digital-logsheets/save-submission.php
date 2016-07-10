<?php
require_once("../../digital-logsheets-res/smarty/libs/Smarty.class.php");
require_once("../../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../../digital-logsheets-res/php/database/manageEpisodeEntries.php");
require_once("../../digital-logsheets-res/php/database/manageSegmentEntries.php");
require_once("../../digital-logsheets-res/php/objects/Episode.php");

session_start();

try {
    //connect to database
    $db = connectToDatabase();

    $episodeId = $_SESSION['episodeId'];
    $episode = new Episode($db, $episodeId);

    manageEpisodeEntries::turnOffEpisodeDraftStatus($db, $episode);

    unset($_SESSION['episodeId']);
    
    echo "Episode saved!";

} catch (PDOException $e) {
    echo $e->getMessage();
}

