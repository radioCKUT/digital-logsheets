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
    
    //database interactions
    try {
		echo "<table class='table'>";
		if ($program == -1){
			$draft = mysql_query("SELECT * FROM episode WHERE draft=1");
		} else {
			$draft = mysql_query("SELECT * FROM episode WHERE draft=1 AND program=$program");
		}
		while ($draft_row = mysql_fetch_array($draft)){
			$program_id = $draft_row['program'];
			$result_program = mysql_query("SELECT * FROM program WHERE id = $program_id") or die();
			$row_program = mysql_fetch_array($result_program);
			
			$start_time = date("Y-m-d\TH:i", strtotime($draft_row['start_time']));
			if ($draft_row['start_time']==''){
				$start_time = 0;
			}
			$end_time = $draft_row['end_time'];
			if ($end_time==''){
				$end_time = 0;
			}
			if ($start_time != 0 && $end_time != 0){
				$duration = round((strtotime($draft_row['end_time']) - strtotime($draft_row['start_time']))/3600);
			} else {
				$duration = 0;
			}
			
			$prerecord_date = date("Y-m-d", strtotime($draft_row['prerecord_date']));
			if ($draft_row['prerecord_date']==''){
				$prerecord_date = 0;
			}
			$comment = $draft_row['comment'];
			
			echo '
			<tr>
            <td><a href="new-logsheet-draft.php?episode_id='.$draft_row['id'].'&program='.$draft_row['program'].'&programmer='.$draft_row['programmer'].'&start_time='.$start_time.'&end_time='.$end_time.'&duration='.$duration.'&prerecord='.$draft_row['prerecord'].'&prerecord_date='.$prerecord_date.'&comment='.$comment.'">'.$row_program['name'].': '.$draft_row['start_time'].' - '.$draft_row['end_time'].'</a></td>
			</tr>';
		}
		echo "</table>";
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
?>