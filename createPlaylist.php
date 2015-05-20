<?php
    //start PHP session to hold playlist_id
    session_start();
    
    require("dbFunctions.php");
    
    //need to generate this array, linked with dynamic
    $segments = array($_POST['s1'], $_POST['s2'], $_POST['s3']);
    
    //create database connection
    $db = connectToDatabase();
    
    //create a new playlist and get id
        try {
            
            //insert a new record for the playlist - auto assign id number
            $db->exec("INSERT INTO playlist VALUES(NULL)");
            
            //save the auto_incremented id number
            $playlist_id = $db->lastInsertId();
            
            echo "success id: $playlist_id";
            
            //associate segments with playlist
            foreach($segments as $segment) {
                $track_name = "";
                $author = "";
                
                //find out if segment exists in database
                $stmt = $db->prepare(
                    "SELECT id FROM segment WHERE name=? AND author=?"
                );
                
                //execute statement with bound parameters
                $name_matches = $stmt->execute(array($track_name, $author));
                
                //if it doesn't exist, create it in db, get id
                if(!$name_matches > 0) {
                    $segment_id = "";
                } else {
                    $segment_id = "";
                }
                
                //add entry to playlist_segments table using both ids
                $stmt = $db->prepare(
                    "INSERT INTO playlist_segments(playlist, segment) 
                    VALUES (:playlist, :segment)"
                ); 
            
                //execute statement and fill in variables
                $stmt->execute(array(
                    "playlist" => $playlist_id,
                    "segment" => $segment_id
                ));
            
                echo "success";
            } //end foreach loop
            
        } catch(PDOException $error) {
            echo "Insert failed: " . $error->getMessage();
        } //end try/catch statment
    
    //close database connectino
    $db = NULL;
?>