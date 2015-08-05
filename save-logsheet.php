<?php
    //---------------------
    //----INCLUDE FILES----
    //---------------------
    include("database.php");
    include("functions.php");
    include("objects/logsheet-classes.php");
    
    
    
    //----------------------------
    //----INITIALIZE VARIABLES----
    //----------------------------
    //store the id number for the program selected by user
    $program_id = $_POST["program"];
    
    //store programmer's first and last name
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    
    //array to hold all the fields for a segment, taken from the form
    $seg_fields = array(
        "name",
        "author",
        "category",
        /*
        "album",
        "length",
        "can_con",
        "new_release",
        "french_vocal_music",
        "request"
        */
    );
    
    $episode_fields = array(
        "playlist",
        "program", 
        "programmer", 
        "start_time", 
        "end_time"
    );
    
    
    
    //------------------------------
    //----STORE DATA IN DATABASE----
    //------------------------------
    $db = connectToDatabase();
    
    //create a new playlist
    $playlist = new Playlist($db);
    
    //add each segment to the playlist
    foreach($_POST["name"] as $i=>$segment) {
        
        $seg_data = array();
        
        //compile the data for each segment
        foreach($seg_fields as $field) {
            //create an array that holds each segment's entry for each field
            //fields are specified by contents of $seg_fields array
            array_push($seg_data,$_POST[$field][$i]);
        }
        
        $current_segment = new Segment($db, $seg_fields, $seg_data);
        $playlist->addSegment($db, $current_segment);
    }
    
    //create a new programmer record
    $programmer = new Programmer($db, $first_name, $last_name);
    
    $episode_data = array(
        $playlist->getId(),
        $program_id, 
        $programmer->getId(), 
        $_POST["start_time"], 
        $_POST["end_time"]
    );    
    
    //associate the playlist, programmer and program with a specific episode
    $episode = new Episode($db, $episode_fields, $episode_data);
    
    //close database connection
    $db = NULL;
    
    header("Location: index.php");
    die();
?>