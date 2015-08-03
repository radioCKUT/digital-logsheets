<?php
    
    function connectToDatabase() {
        //server settings
        $servername = getenv('IP');
        $port = "3306";
         
        //database settings
        $database = "c9";
        $username = getenv('C9_USER');
        $password = "";
        
        //Attempt to connect to database, throw an error if connection fails
		try {
			$database = new PDO("mysql:host=$servername;port=$port;dbname=$database",$username,$password);
			
			//set the PDO error mode to exception
    		$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			//Turn off emulation of prepared statements
			$database->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			
			//return a PDO database object upon successful connection
			return $database;
			
		} catch(PDOException $error) {
			echo 'Connection failed: ' . $error->getMessage();
		} //end try/catch statment
		
		//return null PDO object if successful conection is not made
		return NULL;
    }
	
	//if an argument is given, prepend fields with the string provided
    function formatFields($fields, $character = "") {
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