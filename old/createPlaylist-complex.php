<?php
    //start PHP session to hold playlist_id
    session_start();
    
    require("dbFunctions.php");
    
    //need to generate this array, linked with dynamic form
    //have this filled in automatically with the database fields
    //the keys are saved as variables so code below works when code is changed
    $title = "Title";
    $author = "Author";
    $keys = array($title,$author);                       
    
    $track1 = array($_POST['1-title'],$_POST['1-author']);  //generate this for each track
    $t1_assoc = array_combine($keys,$track1);
    
    $track2 = array($_POST['2-title'],$_POST['2-author']);
    $t2_assoc = array_combine($keys,$track2);
    
    $segments = array(
        "Track 1"=>$t1_assoc,
        "Track 2"=>$t2_assoc
    );
    
    //create database connection
    $db = connectToDatabase();
    
    //create a new playlist and get id
        try {
            
            //insert a new record for the playlist - auto assign id number
            $db->exec("INSERT INTO playlist VALUES(NULL)");
            
            //save the auto_incremented id number
            $playlist_id = $db->lastInsertId();
            
            echo "success playlist id: $playlist_id" . "<br />";
            
            //associate segments with playlist
            foreach($segments as $segment) {
                $track_name = $segment[$title];
                $authors_name = $segment[$author];
                
                //find out if segment exists in database
                $stmt = $db->prepare(
                    "SELECT id FROM segment WHERE name=? AND author=?"
                );
                
                //execute statement with bound parameters
                $stmt->execute(array($track_name, $authors_name));
                $num_tracks_found = $stmt->rowCount();
                $segment_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                //if it doesn't exist, create it in db, get id
                if(!$num_tracks_found > 0) {
                    echo "Track is unique" . "<br />";
                    $segment_id = ""; //get id after insert
                } else {
                    echo "Track found. IDs: " . print_r($segment_ids) . "<br />";
                    //at this point, need to ask user which one found is the right one, or if it's unique
                }
                
                //add entry to playlist_segments table using both ids
            
                //execute statement and fill in variables
                
            } //end foreach loop
            
        } catch(PDOException $error) {
            echo "Insert failed: " . $error->getMessage();
        } //end try/catch statment
    
    //close database connectino
    $db = NULL;
?>