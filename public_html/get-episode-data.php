<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2017  Evan Vassallo
 * Copyright (C) 2017 Donghee Baik
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once("../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../digital-logsheets-res/php/objects/Episode.php");
require_once("../digital-logsheets-res/php/DataPreparationForUI.php");

$episodeId = $_POST['episode_id'];

$segmentTime = $_POST['segmentTime'];
$name = $_POST['name'];
$author = $_POST['author'];
$album = $_POST['album'];
$category = $_POST['category'];

$canCon = isset($_POST['can_con']);
$newRelease = isset($_POST['new_release']);
$frenchVocalMusic = isset($_POST['french_vocal_music']);

if (!isset($episodeId) || $episodeId <= 0) {
    outputErrorResponse("Invalid episode ID");
}

try {
    $db = connectToDatabase();

    $episode = new Episode($db, $episodeId);
    $segmentList = getSegmentListWithErrors($episode);
    
    $db = null;
    outputSuccessResponse($segmentList);

} catch(PDOException $e) {
    $db = null;
    outputErrorResponse($e->getMessage());
}



function outputSuccessResponse($data) {
    outputResponse($data);
}

function outputErrorResponse($errorMessage) {
    $errorArray = array("error" => $errorMessage);
    outputResponse($errorArray);
}

function outputResponse($response) {
    header('Content-type: application/json');
    $responseJSON = json_encode($response);
    echo $responseJSON;
    exit();
}

function addDateToSegmentStartTime($episodeStartDate, $episodeStartTime, $segmentTime) {

    $dateToUse = $episodeStartDate;

    if (strtotime($segmentTime) < strtotime($episodeStartTime)) {
        $episodeStartDateTimestamp = strtotime($episodeStartDate);
        $dayAfterStartDateTimestamp = strtotime('+1 day', $episodeStartDateTimestamp);
        $dateToUse = date("Y-m-d", $dayAfterStartDateTimestamp);

    }

    $segmentTimeWithDate = strtotime($dateToUse . " " . $segmentTime);
    $segmentTime = date("Y-m-d H:m:s", $segmentTimeWithDate);

    return $segmentTime;
}