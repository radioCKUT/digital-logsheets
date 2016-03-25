<?php
require_once("../../digital-logsheets-res/smarty/libs/Smarty.class.php");
require_once("../../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../../digital-logsheets-res/php/database/manageEpisodeEntries.php");
require_once("../../digital-logsheets-res/php/database/manageSegmentEntries.php");
require_once("../../digital-logsheets-res/php/objects/Episode.php");

$episode_id = $_POST['episode_id'];

session_start();

try {
    error_log("just entered finalize-segments try statement");
    $db = connectToDatabase();
    error_log("passed connectToDatabase()");

    $episode_id = $_SESSION['episode_id'];

    $episode = new Episode($db, $episode_id);
    error_log("new Episode created");
    $segments = $episode->getSegments();
    $episode_end_time = $episode->getEndTime();

    $segments = computeSegmentDurations($segments, $episode_end_time);

    foreach ($segments as $segment) {
        error_log("about to edit segment duration");
        manageSegmentEntries::editExistingSegmentDuration($db, $segment);
    }

    manageEpisodeEntries::turnOffEpisodeDraftStatus($db, $episode);

    $smarty = new Smarty();

    $episode = new Episode($db, $episode_id);

    $segmentsForThisEpisode = manageSegmentEntries::getAllSegmentsForEpisodeId($db, $episode_id);

    for($i = 0; $i < count($segmentsForThisEpisode); $i++) {
        $currentSegment = $segmentsForThisEpisode[$i];
        $segmentsForThisEpisode[$i] = $currentSegment->getObjectAsArray();
        $segmentsForThisEpisode[$i]["duration"] = $segmentsForThisEpisode[$i]["duration"]/60;
        error_log($segmentsForThisEpisode);
    }

    //close database connection
    $db = NULL;

    $smarty->assign("episode", $episode);
    $smarty->assign("segments", $segmentsForThisEpisode);

    error_log("segment array passed into finalize-logsheet.tpl: " . $segmentsForThisEpisode);


    // display it
    echo $smarty->fetch('../../digital-logsheets-res/templates/finalize-logsheet.tpl');

} catch (PDOException $e) {
    echo $e->getMessage();
}

function computeSegmentDurations($segments, $episodeEndTime) {
    $segmentCount = count($segments);

    for ($i = 0; $i < $segmentCount; $i++) {
        $currentSegment = $segments[$i];
        $currentSegmentStartDateTime = $currentSegment->getStartTime();
        $currentSegmentStartTimeStamp = $currentSegmentStartDateTime->getTimestamp();

        if ($i < ($segmentCount - 1)) {
            $nextSegment = $segments[$i+1];
            $nextSegmentStartDateTime = $nextSegment->getStartTime();
            $nextSegmentStartTimestamp = $nextSegmentStartDateTime->getTimestamp();

            $duration = $nextSegmentStartTimestamp - $currentSegmentStartTimeStamp;

        } else {
            $episodeEndTimeStamp = $episodeEndTime->getTimestamp();
            $duration = $episodeEndTimeStamp - $currentSegmentStartTimeStamp;
        }

        error_log("duration: " . $duration);

        $durationMinutes = $duration/60;
        error_log("duration minutes: " . $durationMinutes);
        $currentSegment->setDuration($durationMinutes);
    }

    return $segments;
}