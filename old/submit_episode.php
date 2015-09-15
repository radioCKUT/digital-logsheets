<?php
    include('smarty/libs/Smarty.class.php');
    require("dbFunctions.php");
    include("devTools.php");
    
    // create object
    $smarty = new Smarty;
    
    //connect to database
    $db = connectToDatabase();
    
    //assign segments to smarty variable
    $segments = getTableData($db, "SELECT id, name, author FROM segment");
    $smarty->assign("segments", $segments);
    
    //assign categories to smarty variable
    $categories = mapIDtoName($db, "SELECT id, name FROM category");
    $smarty->assign("categories", $categories);
    
    //close database connection
    $db = NULL;
        
    // display it
    echo $smarty->fetch('submit_episode.tpl');
    
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
    
    function mapIDtoName($db, $sql) {
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