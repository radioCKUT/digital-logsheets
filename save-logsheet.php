<?php
include_once('php/database/connectToDatabase.php');
include("php/dev-mode.php");
include_once("php/database/manageEpisodeEntries.php");
include_once("php/database/managePlaylistEntries.php");
include_once("php/database/manageSegmentEntries.php");

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$programId = $_POST['program'];

$prerecord = $_POST['prerecord']; //TODO: table with prerecord column
$prerecord_date = $_POST['prerecord_date'];

$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$comment = $_POST['comment']; //TODO: table with comment column

$segment_times = $_POST['segment_time'];
$segment_durations = $_POST['segment_duration'];
$names = $_POST['name'];
$authors = $_POST['author'];
$categories = $_POST['category'];

$can_con = $_POST['can_con'];
$new_release = $_POST['new_release'];
$french_vocal_music = $_POST['french_vocal_music'];

try {
    $db = connectToDatabase();
    
    $programmerId = 1; //TODO change programmerId once settled how programmers will be stored
    $playlistId = managePlaylistEntries::createNewPlaylist($db);
    
    $segmentCount = count($segment_times);
    $segments = array();

    for ($i = 0; $i < $segmentCount; $i++) {
        $segments[$i] = array('start_time' => $segment_times[$i], 'name' => $names[$i], 'author' => $authors[$i], 'category' => $categories[$i],
            'can_con' => isset($can_con[$i]), 'new_release' => isset($new_release[$i]), 'french_vocal_music' => isset($french_vocal_music[$i]));
    }

    usort($segments, function ($a, $b) {
        return strtotime($a['start_time']) > strtotime($b['start_time']);
    });

    $segments = computeSegmentDurations($segments, $end_time);

    for ($i = 0; $i < $segmentCount; $i++) {
        $segmentId = manageSegmentEntries::saveNewSegmentToDatabase($db, $segments[$i]['start_time'], $segments[$i]['duration'], $segments[$i]['name'], $segments[$i]['author'],
            $segments[$i]['category'], $segments[$i]['can_con'], $segments[$i]['new_release'], $segments[$i]['french_vocal_music']);

        managePlaylistEntries::addSegmentToDatabasePlaylist($db, $playlistId, $segmentId);
    }
    
    manageEpisodeEntries::saveNewEpisode($db, $playlistId, $programId, $programmerId,
        $start_time, $end_time, isset($prerecord), $prerecord_date);
    
    print "Entry added! \n";
    include('new-logsheet.php');
    
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
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