<?php
    //----INCLUDE FILES----
    include("../../digital-logsheets-res/smarty/libs/Smarty.class.php");
    include_once("../../digital-logsheets-res/php/database/connectToDatabase.php");
    include_once("../../digital-logsheets-res/php/database/manageCategoryEntries.php");
    require_once("../../digital-logsheets-res/php/objects/logsheetClasses.php");
    require_once("../../digital-logsheets-res/php/select2-preparation.php");
	include 'connect_to_mysql.php';
    
	$program = -1;
	if (isset($_GET["program"])){
		$program = $_GET["program"];
	} else {
		
	}
	
    echo 'Program: '.$program.'<br>
		  <a href="new-logsheet.php?program='.$program.'">New Logsheet</a><br>
		  <a href="drafts.php?program='.$program.'">Drafts</a>';
		
?>