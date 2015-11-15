<?php
    
    function connectToDatabase() {
        //server settings
        $servername = "localhost";
        $port = "8889";
         
        //database settings
        $database = "c9";
        $username = "root";
        $password = "root";

		//cloud9 server settings
		/*//server settings
		$servername = getenv('IP');
		$port = "3306";

		//database settings
		$database = "c9";
		$username = getenv('C9_USER');
		$password = "";*/
        
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
?>