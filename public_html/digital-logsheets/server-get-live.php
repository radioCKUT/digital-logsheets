<?php
include_once("../../digital-logsheets-res/php/database/connectToDatabase.php");
include_once("../../digital-logsheets-res/php/database/manageSegmentEntries.php");

		date_default_timezone_set('America/New_York');
		$now_string = date("Y-m-d H:i:s");
		echo 'Now playing at '.$now_string.'<br>';
		
		//database interactions
		try {
			//connect to database
			$db = connectToDatabase();
			
			$start = new DateTime('2017-01-01 01:00:00');
			$end = new DateTime('2018-01-01 01:00:00');
			$h = 0;
			
			$segments = manageSegmentEntries::getAllSegmentsBetweenTwoStartDateTimes($db, $start, $end);
			for($i = 0; $i < count($segments); $i++) {
				$currentSegment = $segments[$i];
			
				$start_time = $currentSegment->getStartTime();
				$start_time_string = $start_time->format('Y-m-d H:i:s');
				$approx_duration_mins = $currentSegment->getDuration();
				if ($approx_duration_mins == ''){
					$approx_duration_mins = 0;
				}
				$end_time_string = date("Y-m-d H:i:s", strtotime($start_time_string) + $approx_duration_mins*60);
				$end_time = new DateTime($end_time_string);
				
				$now_string = date("Y-m-d H:i:s");
				$now = new DateTime($now_string);
				if (strtotime($start_time_string) <= strtotime($now_string) && strtotime($now_string) <= strtotime($end_time_string) && $start_time_string != '' && $approx_duration_mins >= 0){//in this time period
				
					$name = $currentSegment->getName();
					$author = $currentSegment->getAuthor();
					echo $name.'<br>
					'.$author.'<br>
					'.$start_time_string.' - '.$end_time_string.'<br><br>';
					
					$h++;
				}
			}

			if ($h == 0){
				echo "No segment is playing now.";
			}			
		} catch(PDOException $e) {
			
		}

?>