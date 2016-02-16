<?php
require_once("../../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../../digital-logsheets-res/php/database/manageEpisodeEntries.php");
require_once("../../digital-logsheets-res/php/database/manageSegmentEntries.php");
require_once("../../digital-logsheets-res/php/objects/Episode.php");

$episode_id = $_POST['episode_id'];

try {
    error_log("just entered finalize-segments try statement");
    $db = connectToDatabase();
    error_log("passed connectToDatabase()");

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

    $db = null;

    echo "Episode saved!";

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