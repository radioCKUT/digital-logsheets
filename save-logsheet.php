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
    
    //TODO: Account for duplicate program entries
    $newProgrammerQuery = "INSERT INTO programmer (first_name,last_name) VALUES ('" . $first_name . "','" . $last_name . "')";
    $db->exec($newProgrammerQuery);
    $programmerId = $db->lastInsertId();
    
    $newPlaylistQuery = "INSERT INTO playlist () VALUES ()";
    $db->exec($newPlaylistQuery);
    $playlistId = $db->lastInsertId();
    
    //TODO: should we be adding duplicate segments? Or should there only be one segment of the same name and author
    //TODO: account for song, author being spelt sligtly differently
    $newSegmentQuery = "INSERT INTO segment (name,author,category) VALUES (:name,:author,:category)";
    $addSegmentToPlaylistQuery = "INSERT INTO playlist_segments (playlist, segment) VALUES ('". $playlistId . "',:segment)";
    
    $newSegmentStmt = $db->prepare($newSegmentQuery);
    $addSegmentStmt = $db->prepare($addSegmentToPlaylistQuery);
    
    $segmentCount = count($names);
    for ($i = 0; $i < $segmentCount; $i++) {
        $newSegmentStmt->bindParam(":name", $names[$i], PDO::PARAM_STR);
        $newSegmentStmt->bindParam(":author", $authors[$i], PDO::PARAM_STR);
        $newSegmentStmt->bindParam(":category", $categories[$i], PDO::PARAM_STR);
        $newSegmentStmt->execute();
        
        $newSegmentId = $db->lastInsertId();
        $addSegmentStmt->bindParam(":segment", $newSegmentId, PDO::PARAM_INT);
        $addSegmentStmt->execute();
    }
    
    $newEpisodeQuery = "INSERT INTO episode (playlist, program, programmer, start_time, end_time) 
        VALUES ('" . $playlistId . "','" . $programId . "','" . $programmerId . "','" . $start_time . "','" . $end_time . "')";
    $db->exec($newEpisodeQuery);
    
    print "Entry added! \n";
    
    include('new-logsheet.php');
    
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}


?>