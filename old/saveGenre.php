<?php
    include("devTools.php");
    require("dbFunctions.php");
    
    //array to hold all the fields taken from the form
    $fields = array(
        "name"
    );
    
    //create database connection
    $db = connectToDatabase();
    
    //store all segments in database and associate with a playlist
    //return the id of the new playlist
    $genreID = createGenre($db, array($_POST["genre"]), $fields);
    
    //close database connection
    $db = NULL;
    
    //create a new genre in the database
    //return the id number, or null if operation fails
    function createGenre($db, $genre, $fields) {
        
        //insert genre into the database and get its auto incremented ID
        try {
            //generate dynamic SQL string for inserting genres into database
            $insertGenreSQL = "INSERT INTO genre(" . printFields($fields) . 
                                ") VALUES (" . printFields($fields,":") . ")";
                    
            //associate fields provided in SQL statement with keys in $genre
            $insertGenre = $db->prepare($insertGenreSQL);
            $insertGenre->execute($genre);
            
            //return the genre_id to associate it with playlist
            $genreID = $db->lastInsertId();

        } catch(PDOException $error) {
            $genreID = NULL;
        }
        
        return $genreID;
        
    } //end createGenre()
    
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