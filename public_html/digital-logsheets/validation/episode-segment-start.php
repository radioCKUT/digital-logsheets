<?php

require_once("../../../digital-logsheets-res/php/database/connectToDatabase.php");

$dbConn = connectToDatabase();

$episodeId = $_SESSION["episodeId"];
$episode = new Episode($dbConn, $episodeId);

$segmentTime = $_GET['segment_time'];