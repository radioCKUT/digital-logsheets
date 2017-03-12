<?php
    //----INCLUDE FILES----
    include("../../digital-logsheets-res/smarty/libs/Smarty.class.php");
    include_once("../../digital-logsheets-res/php/database/connectToDatabase.php");
    include_once("../../digital-logsheets-res/php/database/manageCategoryEntries.php");
    require_once("../../digital-logsheets-res/php/objects/logsheetClasses.php");
    require_once("../../digital-logsheets-res/php/select2-preparation.php");
	include 'connect_to_mysql.php';
    
    // create object
    $smarty = new Smarty;
	
	$episodeId = $_GET["episode_id"];
	$program = $_GET["program"];
	$programmer = $_GET["programmer"];
	$start_time = $_GET["start_time"];
	$end_time = $_GET["end_time"];
	$duration = $_GET["duration"];
	$prerecord = $_GET["prerecord"];
	$prerecord_date = $_GET["prerecord_date"];
	$comment = $_GET["comment"];
    
    //database interactions
    try {
        //connect to database
        $db = connectToDatabase();
        
        $categories = manageCategoryEntries::getAllCategoriesFromDatabase($db);
        $programs = getSelect2ProgramsList($db);
        
        //close database connection
        $db = NULL;
        
        $smarty->assign("programs", $programs);
        $smarty->assign("categories", $categories);
		$smarty->assign("episodeId", $episodeId);
		$smarty->assign("program", $program);
		$smarty->assign("programmer", $programmer);
		$smarty->assign("start_time", $start_time);
		$smarty->assign("end_time", $end_time);
		$smarty->assign("duration", $duration);
		$smarty->assign("prerecord", $prerecord);
		$smarty->assign("prerecord_date", $prerecord_date);
		$smarty->assign("comment", $comment);
		
		 // display it
        echo $smarty->fetch('../../digital-logsheets-res/templates/new-logsheet-draft.tpl');
		
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
?>