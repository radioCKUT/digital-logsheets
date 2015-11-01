<?php
include_once('database.php');

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
$request = $_POST['request'];

try {
    $db = connectToDatabase();
    
    $programmerId = createProgrammer($db, $first_name, $last_name);
    $playlistId = createPlaylist($db);
    
    $segmentCount = count($names);
    
    for ($i = 0; $i < $segmentCount; $i++) {
        $segmentId = createSegment($db, $segment_times[$i], $segment_durations[$i], $names[$i], $authors[$i],
            $categories[$i], isset($can_con[$i]), isset($new_release[$i]), isset($french_vocal_music[$i]), isset($request[$i]));

        addSegmentToPlaylist($db, $playlistId, $segmentId);
    }
    
    createEpisode($db, $playlistId, $programId, $programmerId, $start_time, $end_time, isset($prerecord), $prerecord_date);
    
    print "Entry added! \n";
    include('new-logsheet.php');
    
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
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

function createSegment($db, $time, $duration, $name, $author, $category, $is_can_con, $is_new_release, $is_french_vocal_music, $is_request) {
    //TODO: should we be adding duplicate segments? Or should there only be one segment of the same name and author
    //TODO: account for song, author being spelt slightly differently
    $newSegmentQuery = "INSERT INTO segment (time,duration,name,author,category,can_con,new_release,french_vocal_music,request)
      VALUES (:time,:duration,:name,:author,:category,:can_con,:new_release,:french_vocal_music,:request)";
    $newSegmentStmt = $db->prepare($newSegmentQuery);

    $newSegmentStmt->bindParam(":time", $time, PDO::PARAM_STR);
    $newSegmentStmt->bindParam(":duration", $duration, PDO::PARAM_STR);

    $newSegmentStmt->bindParam(":name", $name, PDO::PARAM_STR);
    $newSegmentStmt->bindParam(":author", $author, PDO::PARAM_STR);
    $newSegmentStmt->bindParam(":category", $category, PDO::PARAM_STR);

    $trueChar = 'o';
    $falseChar = null;

    $newSegmentStmt->bindParam(":can_con", $is_can_con ? $trueChar : $falseChar, PDO::PARAM_STR);
    $newSegmentStmt->bindParam(":new_release", $is_new_release ? $trueChar : $falseChar, PDO::PARAM_STR);
    $newSegmentStmt->bindParam(":french_vocal_music", $is_french_vocal_music ? $trueChar : $falseChar, PDO::PARAM_STR);
    $newSegmentStmt->bindParam(":request", $is_request ? $trueChar : $falseChar, PDO::PARAM_STR);


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