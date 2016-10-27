<?php
include 'connect_to_mysql.php';

$date_search = $_GET["date_search"];	
$time_search = $_GET["time_search"];	
$time = new DateTime($date_search.' '.$time_search);

$h=0;
$result = mysql_query("SELECT * FROM episode") or die();
$number = mysql_num_rows($result);
if ($number > 0) {
   	while ($row =  mysql_fetch_array($result)){
		$start_time = new DateTime($row['start_time']);
		$end_time = new DateTime($row['end_time']);
		if ($start_time < $time && $end_time > $time){
			$program_id = $row['program'];
			$result_program = mysql_query("SELECT * FROM program WHERE id = $program_id") or die();
			$row_program = mysql_fetch_array($result_program);
			
			echo '
			<tr>
            <td><a href="view-episode-segment.php?episode_id='.$row['id'].'">'.$row_program['name'].': '.$row['start_time'].' - '.$row['end_time'].'</a></td>
			</tr>';
			$h++;
		}
   	}
}

if ($h == 0){
	echo "No episode found.";
}

?>