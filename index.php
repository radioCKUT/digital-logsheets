<?php
    include('smarty/libs/Smarty.class.php');
    require("function-definitions.php");
    
    // create object
    $smarty = new Smarty;
    
    //get all episodes from database
    $db = connectToDatabase();
    
    getEpisodes($db);
    
    $db = NULL;
    
    // display it
    echo $smarty->fetch('index.tpl');
    
    /*
    
        $episode_date = "";
        $episode_time = "";
        $program_name = "";
        
        $segment_data = array($name,$author,$album);
        
        $segments = array_push($segment_data);
    
    //display on front page
    $episodes = array($episode_dates, $episode_times, $program_names, $segments);
    
    $fields = array("program", "playlist", "programmer", "start_time", "end_time");
    
    */
    
    function getEpisodes($db) {
        $sql = "SELECT id, playlist, program, programmer, start_time, end_time
                    FROM episode";
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
            while($episode_data = $stmt->fetch()) {
                
            }
        } catch(PDOException $error) {
            echo "Query failed: " . $error->getMessage();
        } //end try/catch statment
    }
?>