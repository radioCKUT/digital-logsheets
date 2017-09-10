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

    //----INCLUDE FILES----
    include('../digital-logsheets-res/smarty/libs/Smarty.class.php');
    include("../digital-logsheets-res/php/database/connectToDatabase.php");
    require_once("../digital-logsheets-res/php/objects/logsheetClasses.php");
    require_once("../digital-logsheets-res/php/DataPreparationForUI.php");
    include('../digital-logsheets-res/php/objects/User.php');
    include('../digital-logsheets-res/php/loginSession.php');


// create object
    $smarty = new Smarty;
    
    //database interactions
    try {
        //open database connection
        $db = connectToDatabase();

        $archive = new Archive($db);
        $episodesArchive = $archive->getArchive();

        $episodeSubmissions = array();
        $episodeDrafts = array();

        foreach($episodesArchive as $episode) {
            $playlist = array();
            $segments = $episode->getPlaylist()->getSegments();

            //create the playlist for each episode
            if (is_array($segments) || is_object($segments)) {
                foreach ($segments as $segment) {
                    $playlist[$segment->getId()] = $segment->getObjectAsArray();
                }
            }

            $episodeProgramName = $episode->getProgram()->getName();
             //create an array to store each episode's data
            if ($loginProgram == NULL || $episodeProgramName == $loginProgram) {
                $results = sortEpisodeByDraftStatus($episode, $episodeSubmissions, $episodeDrafts);
                $episodeSubmissions = $results[0];
                $episodeDrafts = $results[1];
            }
        }
        error_log("episodeDrafts " . print_r($episodeDrafts, true));

        $programs = getSelect2ProgramsList($db);
        
        //close database connection
        $db = NULL;


        $smarty->assign("episodeSubmissions", $episodeSubmissions);
        $smarty->assign("episodeDrafts", $episodeDrafts);
        $smarty->assign("programs", $programs);
        //add program_id
        $smarty->assign("login_program", $loginProgram);
        $smarty->assign("login_username", $loginUsername);

        $smarty->assign("admin_const", "admin");
        $smarty->assign("music_const", "music");

        $smarty->assign("confirm_save", isset($_GET["confirmSave"]));


        // display it
        echo $smarty->fetch('../digital-logsheets-res/templates/index.tpl');

    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

/**
 * @param Episode $episode
 */
function sortEpisodeByDraftStatus($episode, $episodeSubmissions, $episodeDrafts) {
    if (!$episode->isDraft()) {
        $episodeSubmissions[$episode->getId()] = $episode->getObjectAsArray();
    } else {
        $episodeDrafts[$episode->getId()] = $episode->getObjectAsArray();
    }

    return array($episodeSubmissions, $episodeDrafts);
}