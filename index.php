<?php
    include('smarty/libs/Smarty.class.php');
    require("function-definitions.php");
    
    // create object
    $smarty = new Smarty;
    
    //get all episodes from database
    $db = connectToDatabase();
    
    //getEpisode();
    
    $db = NULL;
    
        $episode_date = "";
        $episode_time = "";
        $program_name = "";
        
        $segment_data = array($name,$author,$album);
        
        $segments = array_push($segment_data);
    
    //display on front page
    $episodes = array($episode_dates, $episode_times, $program_names, $segments);
    
    // display it
    echo $smarty->fetch('index.tpl');
    
    $fields = array("program", "playlist", "programmer", "start_time", "end_time");
    
    function getEpisode($db, $fields, $table_name) {
        $sql = "SELECT " . formatFields($fields) . " FROM " . $table_name;
        $data = array();
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
            while($row = $stmt->fetch()) {
                $data[$row["id"]] = $row["name"];
            }
            
        } catch(PDOException $error) {
            echo "Query failed: " . $error->getMessage();
        } //end try/catch statment
        
        return $data;
    }
?>