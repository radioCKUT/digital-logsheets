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

$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$programId = $_POST['program'];

$prerecord = isset($_POST['prerecord']);
$prerecordDate = $_POST['prerecord_date'];

$episodeStartTime = $_POST['start_datetime'];
$episodeDuration = $_POST['episode_duration'];
$comment = $_POST['comment'];

session_start();

try {
    $db = connectToDatabase();

    $programmerId = 1; //TODO change programmerId once settled how programmers will be stored
    $playlistId = managePlaylistEntries::createNewPlaylist($db);

    $episodeObject = new Episode($db, null);

    $episodeObject->setPlaylist(new Playlist($db, $playlistId));
    $episodeObject->setProgram(new Program($db, $programId));
    $episodeObject->setProgrammer(new Programmer($db, $programmerId));

    $episodeStartTime = new DateTime($episodeStartTime, new DateTimeZone('America/Montreal'));
    $episodeObject->setStartTime($episodeStartTime);

    $episodeEndTime = computeEpisodeEndTime($episodeStartTime, $episodeDuration);
    $episodeObject->setEndTime($episodeEndTime);

    $episodeObject->setIsPrerecord($prerecord);
    $prerecordDate = new DateTime($prerecordDate, new DateTimeZone('America/Montreal'));
    $episodeObject->setPrerecordDate($prerecordDate);

    $episodeObject->setComment($comment);

    $episodeValidator = new EpisodeValidator($episodeObject);
    $episodeErrors = $episodeValidator->checkDraftSaveValidity();

    $doEpisodeErrorsExist = $episodeErrors->doErrorsExist();
    if ($doEpisodeErrorsExist) {
        // TODO: handle episode errors present
    } else {
        $episodeId = manageEpisodeEntries::saveNewEpisode($db, $episodeObject);
        $_SESSION["episodeId"] = $episodeId;
    }

    header('Location: add-segments.php');

} catch(PDOException $e) {
    error_log('Error while saving an episode: ' . $e->getMessage());
    //TODO: error handling
}

function computeEpisodeEndTime($episodeStartTime, $episodeDuration) {
    $episodeEndTime = clone $episodeStartTime;
    $episodeDurationMins = ($episodeDuration * 60);
    $episodeDurationDateInterval = new DateInterval('PT' . $episodeDurationMins . 'M');
    $episodeEndTime->add($episodeDurationDateInterval);

    return $episodeEndTime;
}