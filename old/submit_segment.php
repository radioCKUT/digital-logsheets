<?php
    include('smarty/libs/Smarty.class.php');
    require("dbFunctions.php");
    
    // create object
    $smarty = new Smarty;
    
    //connect to database
    $db = connectToDatabase();
    
    //Try to put categories in smarty arrays for the drop down menu in the .tpl
    try {
        $stmt = $db->prepare("SELECT id, name FROM category"); 
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        //create arrays to hold the ID and names
        //used for assigning option using smarty templating
        $id = array();
        $names = array();
        
        //Fill the smarty options arrays with ids and names of categories
        foreach($categories as $category) {
            $ids[] = $category["id"];
            $names[] = $category["name"];
        }
        
        // assign options arrays for category selectiion (drop down menu)
        $smarty->assign('id', $ids);
        $smarty->assign('categories', $names);
        
    } catch(PDOException $error) {
        echo "Query failed: " . $error->getMessage();
    } //end try/catch statment
    
    //close database connection
    $db = NULL;
        
    // display it
    $smarty->display('submit_segment.tpl');
?>