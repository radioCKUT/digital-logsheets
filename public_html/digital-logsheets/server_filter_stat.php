<?php
include 'connect_to_mysql.php';

$date_start = $_GET["date_start"];	
$time_start = $_GET["time_start"];	
$start = new DateTime($date_start.' '.$time_start);
$date_end = $_GET["date_end"];	
$time_end = $_GET["time_end"];	
$end = new DateTime($date_end.' '.$time_end);

$h=0;
$draft = mysql_query("SELECT * FROM segment");
while ($draft_row = mysql_fetch_array($draft)){
	$h++;
			
	$start_time = new DateTime($draft_row['start_time']);
			
	$approx_duration_mins = $draft_row['approx_duration_mins'];
	if ($draft_row['approx_duration_mins']==''){
		$approx_duration_mins = 0;
	}
	$end_time_string = date("Y-m-d H:i:s", strtotime($draft_row['start_time']) + $approx_duration_mins*60);
	$end_time = new DateTime($end_time_string);
	
	if ($start < $start_time && $end_time < $end && $draft_row['start_time'] != '' && $approx_duration_mins >= 0){	
		echo '
		<tr>
		<td>'.$draft_row['name'].': '.$draft_row['start_time'].' - '.$end_time_string.' : ('.$approx_duration_mins.' mins)</td>
		</tr>';
	}
}

if ($h == 0){
	echo "No segment found.";
}

?>