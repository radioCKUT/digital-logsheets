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

    $episode_id = $_SESSION['episode_id'];
    $episode = new Episode($db, $episode_id);

    manageEpisodeEntries::turnOffEpisodeDraftStatus($db, $episode);

    unset($_SESSION['episode_id']);
    
    echo "Episode saved!";

} catch (PDOException $e) {
    echo $e->getMessage();
}

