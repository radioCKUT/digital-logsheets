<?php
    include('smarty/libs/Smarty.class.php');
    require("dbFunctions.php");
    
    // create object
    $smarty = new Smarty;
    
    //connect to database
    $db = connectToDatabase();
    
    try {
        $stmt = $db->prepare("SELECT id, name, author FROM segment");
        $stmt->execute();
        $segments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $smarty->assign('segments', $segments);
        
    } catch(PDOException $error) {
        echo "Query failed: " . $error->getMessage();
    } //end try/catch statment
        
    // display it
    $smarty->display('submit_playlist.tpl');
?>