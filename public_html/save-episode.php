<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2017  Evan Vassallo
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

include_once('../digital-logsheets-res/php/database/connectToDatabase.php');
include_once("../digital-logsheets-res/php/database/manageEpisodeEntries.php");
include_once("../digital-logsheets-res/php/database/managePlaylistEntries.php");
include_once("../digital-logsheets-res/php/database/manageSegmentEntries.php");
require_once("../digital-logsheets-res/php/validator/EpisodeValidator.php");
require_once("../digital-logsheets-res/php/objects/logsheetClasses.php");
require_once("../digital-logsheets-res/php/DataPreparationForUI.php");


$programId = intval($_POST['program']);

$programmer = $_POST['programmer'];
$prerecord = isset($_POST['prerecord']);
$prerecordDate = $_POST['prerecord_date'];

$episodeStartTime = $_POST['start_datetime'];
$episodeEndTime = $_POST['end_datetime'];
$notes = $_POST['notes'];

$isExistingEpisode = isset($_POST['existingEpisode']);
$existingEpisodeId = $_POST['existingEpisode'];

session_start();


try {
    $db = connectToDatabase();

    if ($isExistingEpisode) {
        $episodeObject = new Episode($db, $existingEpisodeId);
    } else {
        $episodeObject = new Episode($db, null);
    }

    $episodeObject = fillEpisodeObject($db, $episodeObject, $programId, $programmer,
        $episodeStartTime, $episodeEndTime, $prerecord, $prerecordDate, $notes);

    error_log("episode object: " . print_r($episodeObject, true));

    $episodeValidator = new EpisodeValidator($episodeObject);
    $episodeErrors = $episodeValidator->checkDraftSaveValidity();

    $doEpisodeErrorsExist = $episodeErrors->doErrorsExist();

    if ($doEpisodeErrorsExist) {
        error_log("Errors exist in episode: " . print_r($episodeErrors, true) . print_r($episodeObject->getObjectAsArray(), true));

        $formErrors = $episodeErrors->getAllErrors();

        $formSubmission = getFormSubmissionArray($episodeObject);

        $episodeErrorsAsQuery = http_build_query(array(
            'formErrors' => $formErrors,
            'formSubmission' => $formSubmission
        ));

        header('Location: new-logsheet.php?' . $episodeErrorsAsQuery);
        exit();

    } else if ($isExistingEpisode) {
        manageEpisodeEntries::editEpisode($db, $episodeObject);
        header('Location: add-segments.php');

    } else {
        $playlistId = managePlaylistEntries::createNewPlaylist($db);
        $episodeObject->setPlaylist(new Playlist($db, $playlistId));

        $episodeId = manageEpisodeEntries::saveNewEpisode($db, $episodeObject);
        $_SESSION["episodeId"] = intval($episodeId);
        header('Location: add-segments.php');
    }


} catch(PDOException $e) {
    error_log('Error while saving an episode: ' . $e->getMessage());
    //TODO: error handling
}

function getDateTimeFromDateString($dateString) {
    $d = new DateTime($dateString);
    //$d = DateTime::createFromFormat('Y-m-d', $dateString);

    if ($d && $d->format('Y-m-d') === $dateString) {

        return new DateTime($dateString);

    } else {
        return null;
    }
}



/**
 * @param $db
 * @param Episode $episodeObject
 * @param $programId
 * @param $programmer
 * @param $episodeStartTime
 * @param $episodeEndTime
 * @param $prerecord
 * @param $prerecordDate
 * @param $notes
 * @return Episode
 */
function fillEpisodeObject($db, $episodeObject, $programId, $programmer, $episodeStartTime, $episodeEndTime, $prerecord, $prerecordDate, $notes) {

    $episodeObject->setProgram(new Program($db, $programId));
    $episodeObject->setProgrammer($programmer);

    $episodeStartTime = getDateTimeFromDateTimeString($episodeStartTime);
    $episodeObject->setStartTime($episodeStartTime);

    $episodeEndTime = getDateTimeFromDateTimeString($episodeEndTime);
    $episodeObject->setEndTime($episodeEndTime);

    $episodeObject->setIsPrerecord($prerecord);
    $prerecordDate = getDateTimeFromDateString($prerecordDate);
    $episodeObject->setPrerecordDate($prerecordDate);

    $episodeObject->setNotes($notes);

    $episodeObject->setIsDraft(true);

    return $episodeObject;
}

function getDateTimeFromDateTimeString($dateString) {
    $d = new DateTime($dateString);
    //$d = DateTime::createFromFormat('Y-m-d\TH:i', $dateString);

    if ($d && $d->format('Y-m-d\TH:i') === $dateString) {
        return new DateTime($dateString, new DateTimeZone('America/Montreal'));

    } else {
        return null;
    }
}

/**
 * @param DateTime $episodeStartTime
 * @param int $episodeDurationHours
 * @return mixed
 */
function computeEpisodeEndTime($episodeStartTime, $episodeDurationHours) {
    $episodeEndTime = clone $episodeStartTime;
    $episodeDurationMins = ($episodeDurationHours * 60);
    $episodeDurationDateInterval = new DateInterval('PT' . $episodeDurationMins . 'M');
    $episodeEndTime->add($episodeDurationDateInterval);

    return $episodeEndTime;
}





