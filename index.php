<?php
    //----INCLUDE FILES----
    include('smarty/libs/Smarty.class.php');
    include("database.php");
    include("dev-mode.php");
    require_once("objects/logsheet-classes.php");
    
    // create object
    $smarty = new Smarty;
    
    //database interactions
    try {
        //open database connection
        $db = connectToDatabase();
        $archive = new Archive($db);
        $episodes = $archive->getArchive();
        
        //close database connection
        $db = NULL;
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
    
    
        
    foreach($episodes as $episode) {
        echo $episode->getProgramName() . "<br />";
    }
    
    // display it
    //echo $smarty->fetch('index.tpl');
?>