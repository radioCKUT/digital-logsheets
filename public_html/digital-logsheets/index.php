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

    //----INCLUDE FILES----
    include('../../digital-logsheets-res/smarty/libs/Smarty.class.php');
    include("../../digital-logsheets-res/php/database/connectToDatabase.php");
    require_once("../../digital-logsheets-res/php/objects/logsheetClasses.php");
    require_once("../../digital-logsheets-res/php/DataPreparationForUI.php");
    
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
            foreach($segments as $segment) {
                $playlist[$segment->getId()] = $segment->getObjectAsArray();
            }
            
            //create an array to store each episode's data
            $episodes[$episode->getId()] = $episode->getObjectAsArray();
        }

        $programs = getSelect2ProgramsList($db);
        
        //close database connection
        $db = NULL;
        
        $smarty->assign("episodes", $episodes);
        $smarty->assign("programs", $programs);

        // display it
        echo $smarty->fetch('../../digital-logsheets-res/templates/index.tpl');
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }