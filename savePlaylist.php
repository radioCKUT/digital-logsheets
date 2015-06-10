<?php
    include("devTools.php");
    require("dbFunctions.php");
    
    //array to hold all the fields taken from the form
    $fields = array(
        "name",
        "author",
        "category"
    );
    
    //format data so segments can be referenced by name
    //each key is a segment, referenced by the segment's name
    $playlist = formatSegments($fields);
    
    //create database connection
    $db = connectToDatabase();
    
    //store all segments in database and associate with a playlist
    //return the id of the new playlist
    $playlistID = savePlaylistInDatabase($db, $playlist, $fields);
    
    //close database connection
    $db = NULL;
    
    function savePlaylistInDatabase($db, $segments, $fields) {
        //create a new playlist and get the id number
        $playlistID = createPlaylist($db);
    
        //confirm new playlist was created
        if($playlistID != NULL) {
            //store each segment in the database and associate with the playlist
            associateSegmentsWithPlaylist($db, $segments, $playlistID, $fields);
        } else {
            //failed to create playlist
            echo "Error: failed to create playlist in database";
        }
    }
    
    //create a new playlist in the database
    //return the id number, or null if operation fails
    function createPlaylist($db) {
        
        //function returns null if playlist creation fails
        $playlistID = NULL;
        
        try {
            
            //Create a new record for the playlist
            $db->exec("INSERT INTO playlist VALUES(NULL)");
            
            //retrieve auto incremented id number
            $playlistID = $db->lastInsertId();
            
        } catch(PDOException $error) {
            echo "Insert failed: " . $error->getMessage();
        } //end try/catch statment
        
        return $playlistID;
        
    } //end createPlaylist()
    
    //create a new segment in the database
    //return the id number, or null if operation fails
    function createSegment($db,$segment, $fields) {
        
        //insert segment into the database and get its auto incremented ID
        try {
            //generate dynamic SQL string for inserting segments into database
            $insertSegmentSQL = "INSERT INTO segment(" . printFields($fields) . 
                                ") VALUES (" . printFields($fields,":") . ")";
                    
            //associate fields provided in SQL statement with keys in $segment
            $insertSegment = $db->prepare($insertSegmentSQL);
            $insertSegment->execute($segment);
            
            //return the segment_id to associate it with playlist
            $segmentID = $db->lastInsertId();

        } catch(PDOException $error) {
            $segmentID = NULL;
        }
        
        return $segmentID;
        
    } //end createSegment()
    
    //if an argument is given, prepend fields with the string provided
    function printFields($fields,$character = "") {
        $fieldsString = "";
        
        //prepend first field with the character provided
        if($character !== "") {   
            $fieldsString = $character;
        }
        
        foreach($fields as $i=>$field) {
            //dont prepend with a comma, space or $character if first in the list
            if($i<1) {
                $fieldsString = $fieldsString . $field;
                continue;
            } else {   
                //prepend the field with comma and space characters
                $fieldsString = $fieldsString . ", ";
                
                //prepend field with the optional character, if provided
                if($character !== "") {
                     $fieldsString = $fieldsString . $character;
                }

                //append the field
                $fieldsString = $fieldsString . $field;
            }
        }//end foreach
        
        return $fieldsString;
        
    } //end printFields
    
    //associate each segment with playlist
    function associateSegmentsWithPlaylist($db, $segments, $playlistID, $fields) {
        foreach($segments as $segment) {
            //create the segment in the database
            $segmentID = createSegment($db, $segment, $fields);
            
            if($segmentID!=NULL) {
                //associate the segment with the playlist
                try {
                    //insert into playlist_segments table
                    $insertPlistSegsSQL = "INSERT INTO playlist_segments(playlist, segment) 
                                            VALUES (:playlist, :segment)";
                    $insertPlistSegs = $db->prepare($insertPlistSegsSQL);
                        
                    //bind the IDs for playlist and the segment 
                    $insertPlistSegs->execute(array(
                        "playlist" => $playlistID,
                        "segment" => $segmentID
                    ));
                    
                    echo "success";
                    
                } catch(PDOException $error) {
                    echo "Segments could not be associated with playlist: " . $error->getMessage();
                }
            } else {
                //failed to create segment in database
            echo "Error: failed to create segment in database";
            }
        } //end foreach loop
    } //end associateSegmentWithPlaylist()
    
    function formatSegments($fields) {
        //store all segments in a single array
        $segments = array();
        
        //for each submitted segment, store associated data in $segments
        //use name of segment as key value
        for($row=0; $row<count($_POST["name"]); $row++) {
            
            //create a new segment
            $segment = array();
            
            //get data associated with the segment for each field in submission form
            for($field=0;$field<count($fields);$field++) {
                
                //get the name of the current field
                $fieldName = $fields[$field];
                
                //store the field data associated with this row and field
                $segment[$fieldName] = $_POST[$fieldName][$row];
            }
            
            //store segment in $segments array using the segment's name as the key
            $segmentName = $segment["name"];
            $segments[$segmentName] = $segment;
        }
        
        //return the formatted array of segments
        return $segments;
        
    } //end formatSegments()
?>