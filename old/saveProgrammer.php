<?php
    include("function-definitions.php");
    
    //fields used to store the programmer data in database
    //playlist must be the first entry here
    $programmerFields = array( 
        "last_name",
        "first_name"
    );
    
    $db = connectToDatabase();
    
    if(is_null(createProgrammer($db, $programmerFields))) {
        echo "Error: programmer not saved."; 
    } else {
        echo "programmer saved."; 
    }
    
    //close database connection
    $db = NULL;
    
    function createProgrammer($db, $fields) {
        
        $programmerData = array();
        
        foreach($fields as $i=>$field) {
            //push data for each field to the end of the array
            array_push($programmerData, $_POST[$field]);
        }
        
        //insert segment into the database and get its auto incremented ID
        try {
            //generate dynamic SQL string for inserting segments into database
            $insertProgrammerSQL = "INSERT INTO programmer(" . printFields($fields) . 
                                ") VALUES (" . printFields($fields,":") . ")";
            
            //execute the mysql command with the bound variables
            $insertProgrammer = $db->prepare($insertProgrammerSQL);
            $insertProgrammer->execute($programmerData);
            
            //return the segment_id to associate it with playlist
            $programmerID = $db->lastInsertId();

        } catch(PDOException $error) {
            echo $error;
            $programmerID = NULL;
        }
        
        return $programmerID;   
    }
    
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
    
?>