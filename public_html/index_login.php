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

/**
 * Created by PhpStorm.
 * User: baikdonghee
 * Date: 2017-05-21
 * Time: 11:48 PM
 */

//----INCLUDE FILES----
include('../digital-logsheets-res/smarty/libs/Smarty.class.php');
include("../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../digital-logsheets-res/php/objects/logsheetClasses.php");
require_once("../digital-logsheets-res/php/DataPreparationForUI.php");
include('../digital-logsheets-res/php/objects/User.php');
include('session.php');
/*/cookie
 if(!isset($_COOKIE['username'])) {
     echo "<meta http-equiv='refresh' content='0;url=login_logsheet.php'>";
     exit;
 }
 $username = $_COOKIE['username'];
 echo 'Welcome '.$_COOKIE['username'].'</br>';
 */


//echo 'user id : '.$session_uid.'<br/>';
//echo 'program id : '.$session_program.'<br/>';
//echo 'program username : '.$session_programName.'<br/>';


$userClass = new User();
$userDetails = $userClass->userDetails($session_uid); // get user details

if ($session_program == null) {
    echo "<div class='row'>
                <div class='container-fluid'> 
                <div class='col-sm-2'><h3>Admin</h3></div></div></div>";
} else {
    // user information
    echo "<div class='row'>
                <div class='container-fluid'>";
    echo "<h4 class='col-sm-7'>Show  name :" . $userDetails->name . "</h4> ";
    echo "</div></div>";
}
//logout
echo "<div class='row'><div class='container-fluid'><h4 class='col-sm-7'><a href='logout.php'>Logout</a></h4></div></div>";


// create object
$smarty = new Smarty;

//database interactions
try {
    //open database connection
    $db = connectToDatabase();

    $archive = new Archive($db);
    $episodesArchive = $archive->getArchive();

    $episodes = array();

    foreach ($episodesArchive as $episode) {
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

    $programs = getSelect2ProgramsList($db); //program list

    //close database connection
    $db = NULL;

    $smarty->assign("episodes", $episodes);
    $smarty->assign("programs", $programs);
    //add program_id
    $smarty->assign("program_id", $session_program);

    // display it
    echo $smarty->fetch('../digital-logsheets-res/templates/index_login.tpl');
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

?>

