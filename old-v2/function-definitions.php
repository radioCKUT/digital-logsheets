<?php

	//globally controlled error reporting (for development)
	$dev_mode = TRUE;
	
	if($GLOBALS["dev_mode"]) {
	    error_reporting(E_ALL);
	    ini_set("display_errors", "1");
	}
    
    //showing array contents in nice format
    function printArray($data) {
        print "<pre>";
        print_r($data);
        print "</pre>";
    }
	
    /*
     * Description: Create an object for a database connection.
     * Input:       None
     * Output:      Returns a database connection object.
     */
    function connectToDatabase() {
        //get the settings to connect to a database
        require("db-credentials.php");
        
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
    
    function mapIDtoName($db, $table) {
        $sql = "SELECT id, name FROM " . $table;
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