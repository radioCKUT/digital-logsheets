<?php

require_once("../../../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../../../digital-logsheets-res/php/objects/Episode.php");
require("../../../digital-logsheets-res/php/validator/TimeValidator.php");
session_start();

const MINUTES_IN_DAY = 24 * 60;
$dbConn = connectToDatabase();

$episodeId = $_SESSION["episodeId"];
$episode = new Episode($dbConn, $episodeId);

$segmentTime = $_GET['segment_time'];

$timeValidator = new TimeValidator();
$isSegmentStartTimeInEpisode = $timeValidator::isSegmentWithinEpisodeBounds($segmentTime, $episode);

if ($isSegmentStartTimeInEpisode) {
    http_response_code(200);
} else {
    http_response_code(400);
}