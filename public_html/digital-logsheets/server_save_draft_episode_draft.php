<?php
include 'connect_to_mysql.php';
	
$episodeId = $_GET["episodeId"];
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
	
mysql_query("UPDATE episode SET program=$program, programmer='$programmer', start_time='$start_datetime', end_time='$end_datetime', prerecord=$prerecord, prerecord_date='$prerecord_date', comment='$notes' WHERE id=$episodeId") or die(mysql_error());


?>