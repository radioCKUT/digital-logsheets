<?php
include_once('database/connectToDatabase.php');
include("dev-mode.php");
include_once("database/manageEpisodeEntries.php");
include_once("database/managePlaylistEntries.php");
include_once("database/manageSegmentEntries.php");

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

$segment_times = $_POST['segment_time'];
$names = $_POST['name'];
$authors = $_POST['author'];
$albums = $_POST['album'];
$categories = $_POST['category'];

$can_con = $_POST['can_con'];
$new_release = $_POST['new_release'];
$french_vocal_music = $_POST['french_vocal_music'];

//this script should be only one that knows how the HTML form is structured, so it can convert inputs into entities the manageEntries classes can manage

try {
    $db = connectToDatabase();

    $programmerId = 1; //TODO change programmerId once settled how programmers will be stored
    $playlistId = managePlaylistEntries::createNewPlaylist($db);

    $segment_times = addDateToSegmentStartTimes($episode_start_date, $episode_start_time, $segment_times);

    $segments = packageSegmentAttributesForSavingAndSorting($segment_times, $names, $authors, $albums, $categories,
        $can_con, $new_release, $french_vocal_music);

    $segments = computeSegmentDurations($segments, $episode_end_time);

    for ($i = 0; $i < count($segments); $i++) {
        manageSegmentEntries::saveNewSegmentToDatabase($db, $segments[$i]['start_time'], $segments[$i]['duration'], $segments[$i]['name'], $segments[$i]['author'],
            $segments[$i]['album'], 2/*$segments[$i]['category']*/, $segments[$i]['can_con'], $segments[$i]['new_release'], $segments[$i]['french_vocal_music'], $playlistId);
    }

    manageEpisodeEntries::saveNewEpisode($db, $playlistId, $programId, $programmerId,
        $episode_start_time, $episode_end_time, isset($prerecord), $prerecord_date);

    header('Location: ../../public_html/digital-logsheets/new-logsheet.php');

} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

function addDateToSegmentStartTimes($episode_start_date, $episode_start_time, $segment_times) {
    for ($i = 0; $i < count($segment_times); $i++) {
        $dateToUse = $episode_start_date;

        if (strtotime($segment_times[$i]) < strtotime($episode_start_time)) {
            $episodeStartDateTimestamp = strtotime($episode_start_date);
            $dayAfterStartDateTimestamp = strtotime('+1 day', $episodeStartDateTimestamp);
            $dateToUse = date("Y-m-d", $dayAfterStartDateTimestamp);
        }

        $segmentTimeWithDate = strtotime($dateToUse . " " . $segment_times[$i]);
        $segment_times[$i] = date("Y-m-d H:m:s", $segmentTimeWithDate);
    }

    return $segment_times;
}

function packageSegmentAttributesForSavingAndSorting($segment_times, $names, $authors, $albums, $categories, $can_con,
                                                     $new_release, $french_vocal_music) {



    $segmentCount = count($segment_times);
    $segments = array();

    for ($i = 0; $i < $segmentCount; $i++) {
        $segments[$i] = array('start_time' => $segment_times[$i], 'name' => $names[$i], 'author' => $authors[$i], 'album' => $albums[$i], 'category' => $categories[$i],
            'can_con' => isset($can_con[$i]), 'new_release' => isset($new_release[$i]), 'french_vocal_music' => isset($french_vocal_music[$i]));
    }

    usort($segments, function ($a, $b) {
        return strtotime($a['start_time']) > strtotime($b['start_time']);
    });

    return $segments;
}

function computeSegmentDurations($segments, $end_time) {
    $segmentStartTimeCount = count($segments);

    for ($i = 0; $i < $segmentStartTimeCount; $i++) {
        if ($i < ($segmentStartTimeCount - 1)) {
            $duration = date_diff(new DateTime($segments[$i+1]['start_time']), new DateTime($segments[$i]['start_time']));
        } else {
            $duration = date_diff(new DateTime($end_time), new DateTime($segments[$i]['start_time']));
        }

        $segments[$i]['duration'] = $duration->format('%H:%i:%s');
    }

    return $segments;
}

?>