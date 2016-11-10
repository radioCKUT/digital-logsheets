<?php
include 'connect_to_mysql.php';
	
$episodeId = $_GET["episodeId"];
mysql_query("UPDATE episode SET draft=0 WHERE id=$episodeId") or die(mysql_error());


?>