<?php
    include('smarty/libs/Smarty.class.php');
    require("dbFunctions.php");
    include("devTools.php");
    
    // create object
    $smarty = new Smarty;
    
    //connect to database
    $db = connectToDatabase();
    
    //store genres in a variable and assign to Smarty object
    $genres = getTableData($db, "SELECT name FROM genre");
    $smarty->assign("genres", $genres);
    
    //close database connection
    $db = NULL;
        
    // display it
    echo $smarty->fetch('submit_genre.tpl');
    
    //retrieve data using select statements from the database
    function getTableData($db, $sql) {
        $data = array();
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch(PDOException $error) {
            echo "Query failed: " . $error->getMessage();
        } //end try/catch statment
        
        return $data;
    }//end getSegments
?>