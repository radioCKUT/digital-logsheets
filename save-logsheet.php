<?php
include_once('connectToDatabase.php');

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
    
    $programmerId = createProgrammer($db, $first_name, $last_name);
    $playlistId = createPlaylist($db);
    
    $segmentCount = count($segment_times);
    $segments = array();

    for ($i = 0; $i < $segmentCount; $i++) {
        $segments[$i] = array('start_time' => $segment_times[$i], 'name' => $names[$i], 'author' => $authors[$i], 'category' => $categories[$i],
            'can_con' => isset($can_con[$i]), 'new_release' => isset($new_release[$i]), 'french_vocal_music' => isset($french_vocal_music[$i]));
    }

    usort($segments, function ($a, $b) {
        return strtotime($a['start_time']) > strtotime($b['start_time']);
    });

    //array_multisort($segment_times, $names, $authors, $categories, $can_con, $new_release, $french_vocal_music);

    $segments = computeSegmentDurations($segments, $end_time);

    for ($i = 0; $i < $segmentCount; $i++) {
        $segmentId = createSegment($db, $segments[$i]['start_time'], $segments[$i]['duration'], $segments[$i]['name'], $segments[$i]['author'],
            $segments[$i]['category'], $segments[$i]['can_con'], $segments[$i]['new_release'], $segments[$i]['french_vocal_music']);

        addSegmentToPlaylist($db, $playlistId, $segmentId);
    }
    
    createEpisode($db, $playlistId, $programId, $programmerId, $start_time, $end_time, isset($prerecord), $prerecord_date);
    
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

function createProgrammer($db, $first_name, $last_name) {
    //TODO: Account for duplicate program entries
    $newProgrammerQuery = "INSERT INTO programmer (first_name,last_name) VALUES ('" . $first_name . "','" . $last_name . "')";
    $db->exec($newProgrammerQuery);
    
    return getIdOfLastEntry($db);
}

function createPlaylist($db) {
    $newPlaylistQuery = "INSERT INTO playlist () VALUES ()";
    $db->exec($newPlaylistQuery);
    
    return getIdOfLastEntry($db);
}

function createSegment($db, $start_time, $duration, $name, $author, $category, $is_can_con, $is_new_release, $is_french_vocal_music) {
    //TODO: should we be adding duplicate segments? Or should there only be one segment of the same name and author
    //TODO: account for song, author being spelt slightly differently
    $newSegmentQuery = "INSERT INTO segment (start_time,duration,name,author,category,can_con,new_release,french_vocal_music)
      VALUES (:start_time,:duration,:name,:author,:category,:can_con,:new_release,:french_vocal_music)";
    $newSegmentStmt = $db->prepare($newSegmentQuery);

    $newSegmentStmt->bindParam(":start_time", $start_time, PDO::PARAM_STR);
    $newSegmentStmt->bindParam(":duration", $duration, PDO::PARAM_STR);

    $newSegmentStmt->bindParam(":name", $name, PDO::PARAM_STR);
    $newSegmentStmt->bindParam(":author", $author, PDO::PARAM_STR);
    $newSegmentStmt->bindParam(":category", $category, PDO::PARAM_STR);

    $trueChar = 'o';
    $falseChar = null;

    $newSegmentStmt->bindParam(":can_con", ($is_can_con ? $trueChar : $falseChar), PDO::PARAM_STR);
    $newSegmentStmt->bindParam(":new_release", ($is_new_release ? $trueChar : $falseChar), PDO::PARAM_STR);
    $newSegmentStmt->bindParam(":french_vocal_music", ($is_french_vocal_music ? $trueChar : $falseChar), PDO::PARAM_STR);

    $newSegmentStmt->execute();
    
    return getIdOfLastEntry($db);
}

function addSegmentToPlaylist($db, $playlistId, $segmentId) {
    $addSegmentToPlaylistQuery = "INSERT INTO playlist_segments (playlist, segment) VALUES (:playlist,:segment)";
    $addSegmentToPlaylistStmt = $db->prepare($addSegmentToPlaylistQuery);
    
    $addSegmentToPlaylistStmt->bindParam(":playlist", $playlistId, PDO::PARAM_INT);
    $addSegmentToPlaylistStmt->bindParam(":segment", $segmentId, PDO::PARAM_INT);
    $addSegmentToPlaylistStmt->execute();
}

function getIdOfLastEntry($db) {
    //in its own function for now b/c may get more complicated 
    //if not adding duplicates to some tables
    
    return $db->lastInsertId();
}

function createEpisode($db, $playlistId, $programId, $programmerId, $start_time, $end_time, $is_prerecord, $prerecord_date) {
    $is_prerecord_string = $is_prerecord ? "TRUE" : "FALSE";

    $newEpisodeQuery = "INSERT INTO episode (playlist,program,programmer,start_time,end_time,prerecord,prerecord_date)
        VALUES (:playlist,:program,:programmer,:start_time,:end_time," . $is_prerecord_string . ",:prerecord_date)";
    $newEpisodeStmt = $db->prepare($newEpisodeQuery);
    
    $newEpisodeStmt->bindParam(":prerecord_date", $prerecord_date, PDO::PARAM_STR);

    $newEpisodeStmt->bindParam(":playlist", $playlistId, PDO::PARAM_INT);
    $newEpisodeStmt->bindParam(":program", $programId, PDO::PARAM_INT);
    $newEpisodeStmt->bindParam(":programmer", $programmerId, PDO::PARAM_INT);

    $newEpisodeStmt->bindParam(":start_time", $start_time, PDO::PARAM_STR);
    $newEpisodeStmt->bindParam(":end_time", $end_time, PDO::PARAM_STR);



    $newEpisodeStmt->execute();
}


?>