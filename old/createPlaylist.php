<?php
    //start PHP session to hold playlist_id
    session_start();
    
    require("dbFunctions.php");
    include_once("devTools.php");
    
    //need to generate this array, linked with dynamic form
    //have this filled in automatically with the database fields
    //the keys are saved as variables so code below works when code is changed
    //Form data needs to be check to make sure the proper information has been submitted
    //name and category are the two required fields to submit to database
    //don't check for category - it must be have a value from drop down menu
    $name= "name";
    $author = "author";
    $cat = "category";
    
    $keys = array($name,$author,$cat);
    
    //generate this for each track
    $track1 = array($_POST['name'][0],$_POST['author'][0],$_POST['category'][0]);
    $t1_assoc = array_combine($keys,$track1);
    
    $track2 = array($_POST['name'][1],$_POST['author'][1],$_POST['category'][1]);
    $t2_assoc = array_combine($keys,$track2);
    
    $segments = array(
        "Track 1"=>$t1_assoc,
        "Track 2"=>$t2_assoc
    );
    
    //create database connection
    $db = connectToDatabase();
    
    createPlaylist($db, $segments);
        
    //close database connectino
    $db = NULL;
    
    function createPlaylist($db, $segments) {
        //create a new playlist and get id
        try {
            
            //Create a new record for the playlist
            $db->exec("INSERT INTO playlist VALUES(NULL)");
            
            //id number is auto incremented - save in variable
            $playlist_id = $db->lastInsertId();
            
            //associate segments with playlist
            foreach($segments as $segment) {
                //Insert segments into table and save the ID created by the database
                if(!NULL) {
                    $segment_id = createSegment($db, $segment);
                } else {
                    echo "Segment failed to be saved in the database";
                }
                
                //Associate the segments with the playlist in the playlist_segments table
                assocSegmentWithPlaylist($db, $playlist_id, $segment_id);
                
            } //end foreach loop
            
        } catch(PDOException $error) {
            echo "Insert failed: " . $error->getMessage();
        } //end try/catch statment
                
        echo "success";
        
    } //end createPlaylist()

    function createSegment($db, $segment) {
        //return null if insert operation fails
        $segment_id = NULL;
        
        try {
            //prepare statement using bound variables
            $stmt = $db->prepare(
                "INSERT INTO segment (name, author, category) 
                VALUES (:name, :author, :category)"
            ); 
            
            //execute statement and fill in variables
            $stmt->execute(array(
                "name" => $segment["name"],
                "author" => $segment["author"],
                "category" => $segment["category"]
            ));
            
            //return the segment_id to associate it with playlist
            $segment_id = $db->lastInsertId();
            
        } catch(PDOException $error) {
            echo "Couldn't create segments: " . $error->getMessage();
        } //end try/catch statment
        
        return $segment_id;
    } //end createSegment() function]
    
    function assocSegmentWithPlaylist($db, $playlist_id, $segment_id) {
        try {
            //prepare statement using bound variables
            $stmt = $db->prepare(
                "INSERT INTO playlist_segments (playlist, segment) 
                VALUES (:playlist, :segment)"
            ); 
            
            //execute statement and fill in variables
            $stmt->execute(array(
                "playlist" => $playlist_id,
                "segment" => $segment_id
            ));
            
        } catch(PDOException $error) {
            echo "Segments could not be associated with playlist: " . $error->getMessage();
        } //end try/catch statment
    } //end assocSegmentsWithPlaylist
?>