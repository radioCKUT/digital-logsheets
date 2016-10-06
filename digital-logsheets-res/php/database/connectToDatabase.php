<?php
    require_once("databaseLogin.php");
    function connectToDatabase() {

        //Attempt to connect to database, throw an error if connection fails
		try {
			$database = getPDOStatementWithLogin();
			$database->exec("set names utf8");
			
			//set the PDO error mode to exception
    		$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			//Turn off emulation of prepared statements
			$database->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			
			//return a PDO database object upon successful connection
			return $database;
			
		} catch(PDOException $error) {
			echo 'Connection failed: ' . $error->getMessage();
		} //end try/catch statement
		
		//return null PDO object if successful conection is not made
		return NULL;
    }
?>