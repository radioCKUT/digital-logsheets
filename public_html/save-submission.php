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

require_once("../digital-logsheets-res/smarty/libs/Smarty.class.php");
require_once("../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../digital-logsheets-res/php/database/manageEpisodeEntries.php");
require_once("../digital-logsheets-res/php/database/manageSegmentEntries.php");
require_once("../digital-logsheets-res/php/objects/Episode.php");

session_start();

try {
    //connect to database
    $db = connectToDatabase();

    $episodeId = $_SESSION['episodeId'];
    $episode = new Episode($db, $episodeId);

    manageEpisodeEntries::turnOffEpisodeDraftStatus($db, $episode);

    unset($_SESSION['episodeId']);

    header("Location: index.php?confirmSave");

} catch (PDOException $e) {
    echo $e->getMessage();
}

