<?php
    require("dbFunctions.php");
	
    //name and category are the two required fields to submit to database
    //don't check for category - it must be have a value from drop down menu
	if (isset($_GET["name"])) {
	    //connect to database
        $db = connectToDatabase();
    
        //insert segment into table
        try {
            
            //prepare statement using bound variables
            $stmt = $db->prepare(
                "INSERT INTO segment (name, album, author, category) 
                VALUES (:name, :album, :author, :category)"
            ); 
            
            //execute statement and fill in variables
            $stmt->execute(array(
                "name" => $_GET["name"],
                "album" => $_GET["album"],
                "author" => $_GET["author"],
                "category" => $_GET["category"],
            ));
            
        } catch(PDOException $error) {
            echo "Query failed: " . $error->getMessage();
        } //end try/catch statment
        
	} else {
	    //Use javascript to validate the form!
	    echo "Failed. Must specify name";
	} //end if statement
?>