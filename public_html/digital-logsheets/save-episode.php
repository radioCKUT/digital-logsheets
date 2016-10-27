<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2016  Evan Vassallo
 * Copyright (C) 2016  James Wang
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

include_once('../../digital-logsheets-res/php/database/connectToDatabase.php');
include_once("../../digital-logsheets-res/php/database/manageEpisodeEntries.php");
include_once("../../digital-logsheets-res/php/database/managePlaylistEntries.php");
include_once("../../digital-logsheets-res/php/database/manageSegmentEntries.php");
require_once("../../digital-logsheets-res/php/validator/EpisodeValidator.php");
require_once("../../digital-logsheets-res/php/objects/logsheetClasses.php");

$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$programId = intval($_POST['program']);

$programmer = $_POST['programmer'];
$prerecord = isset($_POST['prerecord']);
$prerecordDate = $_POST['prerecord_date'];

$episodeStartTime = $_POST['start_datetime'];
$episodeDurationHours = $_POST['episode_duration'];
$notes = $_POST['notes'];

session_start();

try {
    $db = connectToDatabase();

    $episodeObject = new Episode($db, null);

    $episodeObject->setProgram(new Program($db, $programId));
    $episodeObject->setProgrammer($programmer);

    $episodeStartTime = getDateTimeFromDateTimeString($episodeStartTime);
    $episodeObject->setStartTime($episodeStartTime);

    if ($episodeStartTime != null) {
        $episodeEndTime = computeEpisodeEndTime($episodeStartTime, $episodeDurationHours);
        $episodeObject->setEndTime($episodeEndTime);
    }

    $episodeObject->setIsPrerecord($prerecord);
    $prerecordDate = getDateTimeFromDateString($prerecordDate);
    $episodeObject->setPrerecordDate($prerecordDate);

    $episodeObject->setNotes($notes);

    $episodeValidator = new EpisodeValidator($episodeObject);
    $episodeErrors = $episodeValidator->checkDraftSaveValidity($episodeDurationHours);

    $doEpisodeErrorsExist = $episodeErrors->doErrorsExist();
    if ($doEpisodeErrorsExist) {
        error_log("Errors exist in episode: " . print_r($episodeErrors, true));
        $episodeErrorsAsQuery = http_build_query(array('formErrors' => $episodeErrors->getAllErrors()));
        header('Location: new-logsheet.php?' . $episodeErrorsAsQuery);
        exit();

    } else {
        error_log("Epsiode is valid!");
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
    $d = DateTime::createFromFormat('Y-m-d', $dateString);

    if ($d && $d->format('Y-m-d') === $dateString) {
        return new DateTime($dateString, new DateTimeZone('America/Montreal'));

    } else {
        return null;
    }
}

function getDateTimeFromDateTimeString($dateString) {
    $d = DateTime::createFromFormat('Y-m-d\TH:i', $dateString);

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