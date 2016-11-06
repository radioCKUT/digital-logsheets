<?php

require_once("../../digital-logsheets-res/php/database/manageSegmentEntries.php");
require_once("../../digital-logsheets-res/php/database/connectToDatabase.php");

$segmentId = $_POST['segment_id'];

    try {
        if ($segmentId != null) {
            $dbConn = connectToDatabase();
            manageSegmentEntries::deleteSegmentFromDatabase($dbConn, $segmentId);
        }
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }