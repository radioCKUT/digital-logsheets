<?php
include 'connect_to_mysql.php';

$date_start = $_GET["date_start"];	
$time_start = $_GET["time_start"];	
$start = new DateTime($date_start.' '.$time_start);
$date_end = $_GET["date_end"];	
$time_end = $_GET["time_end"];	
$end = new DateTime($date_end.' '.$time_end);

$ad_num = $_GET["ad_num"];

$can_time_1 = 0;
$total_time_1 = 0;
$can_time_2 = 0;
$total_time_2 = 0;
$can_time_3 = 0;
$total_time_3 = 0;
$can_time_4 = 0;
$total_time_4 = 0;
$can_time_5 = 0;
$total_time_5 = 0;
$can_time_6 = 0;
$total_time_6 = 0;

$album_names = []; 
$author_names = []; 
$album_numbers = []; 

$station_ids = []; 
$station_ids_unique = []; 

$h=0;
$result = mysql_query("SELECT * FROM segment");
while ($row = mysql_fetch_array($result)){
	$start_time = new DateTime($row['start_time']);
			
	$approx_duration_mins = $row['approx_duration_mins'];
	if ($row['approx_duration_mins']==''){
		$approx_duration_mins = 0;
	}
	$end_time_string = date("Y-m-d H:i:s", strtotime($row['start_time']) + $approx_duration_mins*60);
	$end_time = new DateTime($end_time_string);
	
	if ($start < $start_time && $end_time < $end && $row['start_time'] != '' && $approx_duration_mins >= 0){//in this time period
		if ($row['category'] == 1){
			if ($row['can_con'] == 1){
				$can_time_1 = (int)$row['approx_duration_mins'] + $can_time_1;
			}
			$total_time_1 = (int)$row['approx_duration_mins'] + $total_time_1;
		} else if ($row['category'] == 2){
			if ($row['can_con'] == 1){
				$can_time_2 = (int)$row['approx_duration_mins'] + $can_time_2;
			}
			$total_time_2 = (int)$row['approx_duration_mins'] + $total_time_2;
		} else if ($row['category'] == 3){
			if ($row['can_con'] == 1){
				$can_time_3 = (int)$row['approx_duration_mins'] + $can_time_3;
			}
			$total_time_3 = (int)$row['approx_duration_mins'] + $total_time_3;
		} else if ($row['category'] == 4){
			if ($row['can_con'] == 1){
				$can_time_4 = (int)$row['approx_duration_mins'] + $can_time_4;
			}
			$total_time_4 = (int)$row['approx_duration_mins'] + $total_time_4;
		} else if ($row['category'] == 5){
			if ($row['can_con'] == 1){
				$can_time_5 = (int)$row['approx_duration_mins'] + $can_time_5;
			}
			$total_time_5 = (int)$row['approx_duration_mins'] + $total_time_5;
		} else if ($row['category'] == 6){
			if ($row['can_con'] == 1){
				$can_time_6 = (int)$row['approx_duration_mins'] + $can_time_6;
			}
			$total_time_6 = (int)$row['approx_duration_mins'] + $total_time_6;
		}
		
		if ($row['album'] != ''){
			$j = 0;
			$album_sample = $row['album'];
			$result_album = mysql_query("SELECT * FROM segment WHERE album REGEXP '$album_sample'");
			while ($row_album = mysql_fetch_array($result_album)){
				similar_text($row['album'], $row_album['album'], $p);
				if ($p > 90){
					$j++;
				}		
			}
			if ($j > 0){ //how many times it was played
				$k = 0;
				foreach ($album_names as $album_name){
					if ($row['album'] == $album_name){
						$k = 1;
						break;
					}
				}
				if ($k == 0){
					$album_names[] = $row['album'];
					$author_names[] = $row['author'];
					$album_numbers[] = $j;
				}
			}
		}
		
		if ($ad_num != ''){
			$result_ad = mysql_query("SELECT * FROM segment WHERE ad_number = $ad_num");
			$number_ad = mysql_num_rows($result_ad);
			$ad = 'Advertisement number '.$ad_num.' has been played '.$number_ad.' times.';
		} else {
			$ad = 'No advertisement number has been picked.';
		}
		
		if ($row['station_id'] != ''){
			$station_ids[] = $row['station_id'];
		}
		
		echo '
		<tr>
		<td>'.$row['name'].': '.$row['start_time'].' - '.$end_time_string.' : ('.$approx_duration_mins.' mins) , Canadian content: '.$row['can_con'].'</td>
		</tr>';
		
		$h++;
	}
}

if ($h == 0){
	echo "No segment found.";
}

if ($total_time_1 != 0){
	$percent_1 = number_format((float)$can_time_1/$total_time_1, 4)*100;
} else {
	$percent_1 = 0;
}
if ($total_time_2 != 0){
	$percent_2 = number_format((float)$can_time_2/$total_time_2, 4)*100;
} else {
	$percent_2 = 0;
}
if ($total_time_3 != 0){
	$percent_3 = number_format((float)$can_time_3/$total_time_3, 4)*100;
} else {
	$percent_3 = 0;
}
if ($total_time_4 != 0){
	$percent_4 = number_format((float)$can_time_4/$total_time_4, 4)*100;
} else {
	$percent_4 = 0;
}
if ($total_time_5 != 0){
	$percent_5 = number_format((float)$can_time_5/$total_time_5, 4)*100;
} else {
	$percent_5 = 0;
}
if ($total_time_6 != 0){
	$percent_6 = number_format((float)$can_time_6/$total_time_6, 4)*100;
} else {
	$percent_6 = 0;
}

echo '<br><br>';
echo 'Canadian content duration as a percentage of total airtime in Category 1: ('.$can_time_1.' / '.$total_time_1.') '.$percent_1.'%<br>';
echo 'Canadian content duration as a percentage of total airtime in Category 2: ('.$can_time_2.' / '.$total_time_2.') '.$percent_2.'%<br>';
echo 'Canadian content duration as a percentage of total airtime in Category 3: ('.$can_time_3.' / '.$total_time_3.') '.$percent_3.'%<br>';
echo 'Canadian content duration as a percentage of total airtime in Category 4: ('.$can_time_4.' / '.$total_time_4.') '.$percent_4.'%<br>';
echo 'Canadian content duration as a percentage of total airtime in Category 5: ('.$can_time_5.' / '.$total_time_5.') '.$percent_5.'%<br>';
echo 'Canadian content duration as a percentage of total airtime in Category 6: ('.$can_time_6.' / '.$total_time_6.') '.$percent_6.'%<br>';

echo '<br><br>';
$l = 0;
foreach ($album_names as $album_name){
	echo $album_name.' by '.$author_names[$l].' is played '.$album_numbers[$l].' times.<br>';
	$l++;
}

echo '<br><br>'.$ad;

$unique_ids = '';
$station_ids_unique = array_unique($station_ids);
$number_of_unique_ids = sizeof($station_ids_unique);
foreach ($station_ids_unique as $station_id_unique){
	$unique_ids .= $station_id_unique.', ';
}
echo '<br><br>';
echo 'Station IDs: '.$unique_ids.'how many: '.$number_of_unique_ids;

?>