<?php
    require("dbFunctions.php");
    
    //connect to database
    $db = connectToDatabase();
        
    //Turn on all error reporting
	error_reporting(E_ALL);
    
    try {
        $stmt = $db->prepare("SELECT id, name FROM category"); 
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($categories as $category) {
            
            echo "<option value=\"" . $category["id"] .""\">";
            echo $category["name"];
            echo "</option>";
        }
        
        
    } catch(PDOException $error) {
        echo "Query failed: " . $error->getMessage();
    } //end try/catch statment
?>