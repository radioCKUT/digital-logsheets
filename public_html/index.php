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
    include('session.php');

    $userClass = new User();
    $userDetails = $userClass->userDetails($session_uid); // get user details
    //logout
    echo "<div class='row'>
                <div class='container-fluid'>
                    <h5 class='col-sm-7'><a href='logout.php'>Logout</a></h5>
                </div>
               </div>";

    if ($session_program == null) {
        echo "<div class='row'>
                    <div class='container-fluid'> 
                    <div class='col-sm-2'><h3>Admin</h3></div></div></div>";

        //statistic
        echo "<div class='row'>
            <div class='container-fluid'>
                <h4 class='col-sm-7'><a href='View_Statistics.php'>View Logsheets Statistic</a></h4>
            </div>
           </div>";
    } else {
        // user information
        echo "<div class='row'>
                    <div class='container-fluid'>";
        echo "<h4 class='col-sm-7'>Show  name :" . $userDetails->name . "</h4> ";
        echo "</div></div>";
    }



// create object
    $smarty = new Smarty;
    
    //database interactions
    try {
        //open database connection
        $db = connectToDatabase();

        $archive = new Archive($db);
        $episodesArchive = $archive->getArchive();

        $episodes = array();

        foreach($episodesArchive as $episode) {
            $playlist = array();
            $segments = $episode->getPlaylist()->getSegments();

            //create the playlist for each episode
            if (is_array($segments) || is_object($segments)) {
                foreach ($segments as $segment) {
                    $playlist[$segment->getId()] = $segment->getObjectAsArray();
                }
            }

             //create an array to store each episode's data
            if ($session_program == NULL) {
                $episodes[$episode->getId()] = $episode->getObjectAsArray();
            } elseif ($episode->getProgram()->getId() == $session_program) {
                $episodes[$episode->getId()] = $episode->getObjectAsArray();
            }
        }

        $programs = getSelect2ProgramsList($db);
        
        //close database connection
        $db = NULL;
        
        $smarty->assign("episodes", $episodes);
        $smarty->assign("programs", $programs);
        //add program_id
        $smarty->assign("program_id", $session_program);


        // display it
        echo $smarty->fetch('../digital-logsheets-res/templates/index.tpl');
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }