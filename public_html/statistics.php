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
include('../digital-logsheets-res/php/objects/statistics/Statistic.php');
include('../digital-logsheets-res/php/objects/statistics/CountStatistic.php');
include('../digital-logsheets-res/php/objects/statistics/CanConStatistic.php');

include('../digital-logsheets-res/php/loginSession.php');


require_once("../digital-logsheets-res/php/database/getStatistics.php");

require_once("../digital-logsheets-res/smarty/libs/Smarty.class.php");

/*
//logout
echo "<div class='row'>
                <div class='container-fluid'>
                    <h5 class='col-sm-7'><a href='logout.php'>Logout</a></h5>
                </div>
               </div>";

if ($loginProgram == null) {
    echo "<div class='row'>
                    <div class='container-fluid'> 
                    <div class='col-sm-2'><h3>Admin</h3></div></div></div>";
} else {
    // user information
    echo "<div class='row'>
                    <div class='container-fluid'>";
    echo "<h4 class='col-sm-7'>Show  name :" . $loginId . "</h4> ";
    echo "</div></div>";
}*/

$startDate = "";
$endDate = "";

$smarty = new Smarty;

if(isset($_GET['searchSubmit'])) {
    $errMsg = '';
    $startDate = $_GET['startDateFilter'];
    $endDate = $_GET['endDateFilter'];

    $category = '';

    if ($startDate == 0 || $endDate == 0) {
        $errMsg .= 'Select the date<br>';

    } else if ($startDate != 0 && $endDate != 0 && $startDate >= $endDate) {
        $errMsg .= 'Select the start date earlier than end date <br>';

    } else {
        $db = connectToDatabase();

        prepareCanConStats($db, $startDate, $endDate, 2, "general", $smarty);
        prepareCanConStats($db, $startDate, $endDate, 3, "jazz", $smarty);

        prepareAlbumStats($db, $startDate, $endDate, $smarty);

        prepareAdStats($db, $startDate, $endDate, $smarty);
    }
}





$smarty->assign("err_msg", $errMsg);
$smarty->assign("tab_id", $_GET['tab_id']);
$smarty->assign("search_submit", $_GET['searchSubmit']);

$smarty->assign("start_date", $startDate);
$smarty->assign("end_date", $endDate);

echo $smarty->fetch("../digital-logsheets-res/templates/view-statistics.tpl");

/**
 * @param $db
 * @param $startDate
 * @param $endDate
 * @param $category
 * @param $prefix
 * @param Smarty $smarty
 */
function prepareCanConStats($db, $startDate, $endDate, $category, $prefix, $smarty) {
    $canConStats = getStatistics::getAllCanCon($db, $startDate, $endDate, $category);

    $canConDuration = $canConStats->getCanConDuration();
    $smarty->assign($prefix . "_can_con_duration", $canConDuration);

    $totalDuration = $canConStats->getTotalDuration();
    $smarty->assign($prefix . "_total_duration", $totalDuration);

    $percentage = round(100 * $canConDuration / $totalDuration, 1);
    $smarty->assign($prefix . "_percentage", $percentage);
}

/**
 * @param $db
 * @param $startDate
 * @param $endDate
 * @param Smarty $smarty
 */
function prepareAlbumStats($db, $startDate, $endDate, $smarty) {
    $mostPlayedAlbums = getStatistics::getMostPlayedAlbum($db, $startDate, $endDate);
    $mostPlayedAlbumsSmarty = array();

    foreach ($mostPlayedAlbums as $album) {
        $smartyVar = $album->getAsArray();
        array_push($mostPlayedAlbumsSmarty, $smartyVar);
    }

    $smarty->assign("albums", $mostPlayedAlbumsSmarty);
}

/**
 * @param $db
 * @param $startDate
 * @param $endDate
 * @param Smarty $smarty
 */
function prepareAdStats($db, $startDate, $endDate, $smarty) {
    $ads = getStatistics::getAdFrequency($db, $startDate, $endDate);
    $adsSmarty = array();

    foreach ($ads as $ad) {
        $smartyVar = $ad->getAsArray();
        array_push($adsSmarty, $smartyVar);
    }

    $smarty->assign("ads", $adsSmarty);
}