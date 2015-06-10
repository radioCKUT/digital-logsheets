<?php
    include("devTools.php");
    require("dbFunctions.php");
    
    //hold all data submitted from the form
    //this allows fields to be easily added
    //new fields must also be added in the formatSegments loop
    $segmentData = array(
        "names"=>$_POST['name'],
        "authors"=>$_POST['author'],
        "categories"=>$_POST['category'],
    );
    
    //format dat so segments can be referenced by name
    //each key is a segment, referenced by the segment's name
    $playlist = formatSegments($segmentData);
    
    printArray($playlist);
    
    //create database connection
    $db = connectToDatabase();
    
    //store all segments in database and associate with a playlist
    //return the id of the new playlist
    $playlistID = savePlaylistInDatabase($db, $playlist);
    
    //close database connection
    $db = NULL;
    
    function savePlaylistInDatabase($db, $segments) {
        //create a new playlist and get the id number
        $playlistID = createPlaylist($db);
    
        //confirm new playlist was created
        if($playlistID != NULL) {
            //store each segment in the database and associate with the playlist
            associateSegmentsWithPlaylist($db, $segments, $playlistID);
        } else {
            //failed to create playlist
        }
    }
    
    //create a new playlist in the database
    //return the id number, or null if operation fails
    function createPlaylist($db) {
        try {
            
            //Create a new record for the playlist
            $db->exec("INSERT INTO playlist VALUES(NULL)");
            
            //retrieve auto incremented id number
            $playlistID = $db->lastInsertId();
            
        } catch(PDOException $error) {
            echo "Insert failed: " . $error->getMessage();
            return NULL;
        } //end try/catch statment
        
        return $playlistID;
        
    } //end createPlaylist()
    
    //create a new segment in the database
    //return the id number, or null if operation fails
    function createSegment($db,$segment) {
        
    } //end createSegment()
    
    //associate each segment with playlist
    function associateSegmentsWithPlaylist($db, $segments, $playlistID) {
        foreach($segments as $segment) {
            //create the segment in the database
            $segmentID = createSegment($db, $segment);
            
            if($segmentID!=NULL) {
                //associate the segment with the playlist
            } else {
                //failed to create segment in database
            }
        } //end foreach loop
    } //end associateSegmentWithPlaylist()
    
    function formatSegments($playlist) {
        //array user to store segments submitted from the playlist
        $segments = array();
        
        //go through each segment and store data in the $segments array
        //each segment is indexed in $segments by using the name as the key
        for($segIndex=0;$segIndex<count($playlist["names"]);$segIndex++) {
            
            //create an array for all the segment's data
            $segment = array(
                "name"=>$playlist["names"][$segIndex],
                "author"=>$playlist["authors"][$segIndex],
                "category"=>$playlist["categories"][$segIndex],
            );
            
            //store each segment in the segments array, indexed by name
            $segments[$segment["name"]]=$segment;
        }
        
        //return the formatted array of segments
        return $segments;
    } //end formatSegments()
?>