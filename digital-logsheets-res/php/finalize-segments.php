<?php
require_once("../../digital-logsheets-res/php/database/manageEpisodeEntries.php");
require_once("../../digital-logsheets-res/php/database/manageSegmentEntries.php");
require_once("../../digital-logsheets-res/php/objects/Episode.php");

$episode_id = $_POST['episode_id'];

try {
    $db = connectToDatabase();

    $episode = new Episode($db, $episode_id);
    $segments = $episode->getSegments();
    $episode_end_time = $episode->getEndTime();

    $segments = computeSegmentDurations($segments, $episode_end_time);

    foreach ($segments as $segment) {
        manageSegmentEntries::editExistingSegmentDuration($db, $segment);
    }

    manageEpisodeEntries::turnOffEpisodeDraftStatus($db, $episode);

    $db = null;

    echo "Episode saved!";

} catch (PDOException $e) {
    echo $e->getMessage();
}

function computeSegmentDurations($segments, $episode_end_time) {
    $segmentCount = count($segments);

    for ($i = 0; $i < $segmentCount; $i++) {
        if ($i < ($segmentCount - 1)) {
            $duration = date_diff(new DateTime($segments[$i+1]->getStartTime()), new DateTime($segments[$i]->getStartTime()));
        } else {
            $duration = date_diff(new DateTime($episode_end_time), new DateTime($segments[$i]->getStartTime()));
        }

        $formatted_duration = $duration->format('%H:%i:%s');
        $segments[$i]->setDuration($formatted_duration);
    }

    return $segments;
}