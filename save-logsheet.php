<?php
include_once('database.php');

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$programId = $_POST['program'];
$prerecord = $_POST['prerecord']; //TODO: table with prerecord column
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$comment = $_POST['comment']; //TODO: table with comment column

$names = $_POST['name'];
$authors = $_POST['author'];
$categories = $_POST['category'];

try {
    $db = connectToDatabase();
    
    $programmerId = createProgrammer($db);
    $playlistId = createPlaylist($db);
    
    $segmentCount = count($names);
    
    for ($i = 0; $i < $segmentCount; $i++) {
        $segmentId = createSegment($db, $names[$i], $authors[$i], $categories[$i]);
        addSegmentToPlaylist($db, $playlistId, $segmentId);
    }
    
    createEpisode($db, $playlistId, $programId, $programmerId, $start_time, $end_time);
    
    print "Entry added! \n";
    include('new-logsheet.php');
    
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

function createProgrammer($db) {
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

function createSegment($db, $name, $author, $category) {
    //TODO: should we be adding duplicate segments? Or should there only be one segment of the same name and author
    //TODO: account for song, author being spelt sligtly differently
    $newSegmentQuery = "INSERT INTO segment (name,author,category) VALUES (:name,:author,:category)";
    $newSegmentStmt = $db->prepare($newSegmentQuery);
    
    $newSegmentStmt->bindParam(":name", $name, PDO::PARAM_STR);
    $newSegmentStmt->bindParam(":author", $author, PDO::PARAM_STR);
    $newSegmentStmt->bindParam(":category", $category, PDO::PARAM_STR);
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

function createEpisode($db, $playlistId, $programId, $programmerId, $start_time, $end_time) {
    $newEpisodeQuery = "INSERT INTO episode (playlist, program, programmer, start_time, end_time) 
        VALUES ('" . $playlistId . "','" . $programId . "','" . $programmerId . "','" . $start_time . "','" . $end_time . "')";
    $db->exec($newEpisodeQuery);
}


?>