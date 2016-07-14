<?php

require_once("../../../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../../../digital-logsheets-res/php/objects/Episode.php");
session_start();

const MINUTES_IN_DAY = 24 * 60;
$dbConn = connectToDatabase();

$episodeId = $_SESSION["episodeId"];
$episode = new Episode($dbConn, $episodeId);

$segmentTime = $_GET['segment_time'];
$segmentDateTime = new DateTime("January 1, " . $segmentTime);
$segmentStartTimeInMinutes = getTimeInMinutesSinceMidnight($segmentDateTime);

$episodeStartTime = $episode->getStartTime();
$episodeStartTimeInMinutes = getTimeInMinutesSinceMidnight($episodeStartTime);
$episodeStartDay = $episodeStartTime->format('N');

$episodeEndTime = $episode->getEndTime();
$episodeEndTimeInMinutes = getTimeInMinutesSinceMidnight($episodeEndTime);
$episodeEndDay = $episodeEndTime->format('N');

if ($episodeStartDay === $episodeEndDay) {
    if (($segmentStartTimeInMinutes >= $episodeStartTimeInMinutes)
    && ($segmentStartTimeInMinutes <= $episodeEndTimeInMinutes)) {
        http_response_code(200);
    }
} else {
    if (($segmentStartTimeInMinutes + MINUTES_IN_DAY >= $episodeStartTimeInMinutes
        && $segmentStartTimeInMinutes <= $episodeEndTimeInMinutes)
    || ($segmentStartTimeInMinutes >= $episodeStartTimeInMinutes
        && $segmentStartTimeInMinutes <= $episodeEndTimeInMinutes + MINUTES_IN_DAY)) {
        http_response_code(200);
    }
}

http_response_code(400);

/**
 * @param DateTime $dateTime
 * @return int mixed
 */
function getTimeInMinutesSinceMidnight($dateTime) {
    //TODO: error handling
    return (((int) $dateTime->format('H')) * 60) + (int) $dateTime->format('i');
}