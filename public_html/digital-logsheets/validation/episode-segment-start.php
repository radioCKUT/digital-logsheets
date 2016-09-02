<?php

require_once("../../../digital-logsheets-res/php/database/connectToDatabase.php");
session_start();

$dbConn = connectToDatabase();

$episodeId = $_SESSION["episodeId"];
$episode = new Episode($dbConn, $episodeId);

