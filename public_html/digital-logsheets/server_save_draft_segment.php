<?php
include 'connect_to_mysql.php';

$segment_time = $_GET["segment_time"];	
if ($_GET["ad_number_input"] == ""){
	$ad_number = 0;
} else {
	$ad_number = $_GET["ad_number_input"];
}
if ($_GET["name_input"] == ""){
	$name = "Name";
} else {
	$name = $_GET["name_input"];
}
if ($_GET["author_input"] == ""){
	$author = "NULL";
} else {
	$author = $_GET["author_input"];
}
if ($_GET["album_input"] == ""){
	$album = "NULL";
} else {
	$album = $_GET["album_input"];
}
if ($_GET["can_con"] == ""){
	$can_con = 0;
} else {
	$can_con = $_GET["can_con"];
}
if ($_GET["new_release"] == ""){
	$new_release = 0;
} else {
	$new_release = $_GET["new_release"];
}
if ($_GET["french_vocal_music"] == ""){
	$french_vocal_music = 0;
} else {
	$french_vocal_music = $_GET["french_vocal_music"];
}
$category = $_GET["category_value"];
$episode_id = $_GET["episode_id"];


$start_time1 = date("Y-m-d H:i:s", strtotime($segment_time));
$start_time = new DateTime($start_time1, new DateTimeZone('America/Montreal'));
$start_time_string = $start_time->format('Y-m-d H:i:s');

$now = new DateTime("now", new DateTimeZone('America/Montreal') );
$now_string = $now->format('Y-m-d H:i:s');

$time = round((strtotime($now_string) - strtotime($start_time_string))/60);
echo $time." mins";

$result = mysql_query("SELECT * FROM episode WHERE id=$episode_id") or die();
$row =  mysql_fetch_array($result);
$playlist = $row['playlist'];

$result_playlist_segments = mysql_query("SELECT * FROM playlist_segments WHERE playlist=$playlist");
$number = mysql_num_rows($result_playlist_segments);
if ($number == 0) {
	$max = mysql_query("SELECT MAX(segment) as max_segment FROM playlist_segments");
	$max_row = mysql_fetch_array($max);
	$max_segment = $max_row['max_segment']+1;

	mysql_query("INSERT INTO segment VALUES ($max_segment, 1, $ad_number, '$name', '$album', '$author', $time, '$start_time_string', $category, $can_con, $new_release, $french_vocal_music)") or die(mysql_error());

	mysql_query("INSERT INTO playlist_segments VALUES ($playlist, $max_segment)") or die(mysql_error());
} else {
	$result_playlist_segments_row = mysql_fetch_array($result_playlist_segments);
	$segment_id = $result_playlist_segments_row['segment'];
	mysql_query("UPDATE segment SET ad_number=$ad_number, name='$name', album='$album', author='$author', approx_duration_mins=$time, start_time='$start_time_string', category=$category, can_con=$can_con, new_release=$new_release, french_vocal_music=$french_vocal_music WHERE id=$segment_id") or die(mysql_error());
}


?>