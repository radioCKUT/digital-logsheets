<?php

require_once("../../digital-logsheets-res/php/database/manageSegmentEntries.php");
require_once("../../digital-logsheets-res/php/database/connectToDatabase.php");

$segment_id = $_POST['segment_id'];

    try {
        error_log("in delete-segment. segment_id: " . $segment_id);
        if ($segment_id != null) {
            $db_conn = connectToDatabase();
            manageSegmentEntries::deleteSegmentFromDatabase($db_conn, $segment_id);
        }
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }