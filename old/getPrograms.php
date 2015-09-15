<?php
    require("dbFunctions.php");
    
    //connect to database
    $db = connectToDatabase();
        
    //Turn on all error reporting
	error_reporting(E_ALL);
    
    try {
        $stmt = $db->prepare("SELECT * FROM program"); 
        $stmt->execute();
        $programs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($programs as $program) {
            echo $program["id"] . " ";
            echo $program["name"];
            echo "<br />";
        }
        
        
    } catch(PDOException $error) {
        echo "Query failed: " . $error->getMessage();
    } //end try/catch statment
?>