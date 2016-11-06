<?php
include 'connect_to_mysql.php';
	
if ($_GET["programmer"] == ""){
	$programmer = 0;
} else {
	$programmer = $_GET["programmer"];
}
if ($_GET["program"] == ""){
	$program = 0;
} else {
	$program = $_GET["program"];
}
if ($_GET["start_datetime"] == ""){
	$start_datetime = "0";
} else {
	$start_datetime = $_GET["start_datetime"];
}
if ($_GET["episode_duration"] == ""){
	$episode_duration = 0;
} else {
	$episode_duration = $_GET["episode_duration"];
}
$end_date = strtotime($start_datetime)+$episode_duration*3600;
$end_datetime = date("Y-m-d H:i:s", $end_date);

$prerecord = $_GET["prerecord"];
$prerecord_date = $_GET["prerecord_date"];
$notes = $_GET["notes"];
$same_episode = $_GET["same_episode"];

$max = mysql_query("SELECT MAX(playlist) as max_playlist, MAX(id) as max_id FROM episode");
$max_row = mysql_fetch_array($max);
if ($same_episode == 0){
	$max_playlist = $max_row['max_playlist']+1;
	$max_id = $max_row['max_id']+1;
	
	$result_programmer = mysql_query("SELECT * FROM programmer WHERE id=$programmer") or die();
	$number_programmer = mysql_num_rows($result_programmer);
	if ($number_programmer == 0) {
		mysql_query("INSERT INTO programmer VALUES ($programmer, '','')") or die(mysql_error());
	}
	
	mysql_query("INSERT INTO episode VALUES ($max_id, $max_playlist, $program, $programmer, '$start_datetime', '$end_datetime', $prerecord, '$prerecord_date', 1, '$notes')") or die(mysql_error());
	echo $max_id;
} else {
	$result_programmer = mysql_query("SELECT * FROM programmer WHERE id=$programmer") or die();
	$number_programmer = mysql_num_rows($result_programmer);
	if ($number_programmer == 0) {
		mysql_query("INSERT INTO programmer VALUES ($programmer, '','')") or die(mysql_error());
	}
	
	$max_id = $max_row['max_id'];
	mysql_query("UPDATE episode SET program=$program, programmer=$programmer, start_time='$start_datetime', end_time='$end_datetime', prerecord=$prerecord, prerecord_date='$prerecord_date', comment='$notes' WHERE id=$max_id") or die(mysql_error());
	echo $max_id;
}

?>