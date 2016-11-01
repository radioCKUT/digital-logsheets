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
    require_once("../../digital-logsheets-res/smarty/libs/Smarty.class.php");
    require_once("../../digital-logsheets-res/php/database/connectToDatabase.php");
    require_once("../../digital-logsheets-res/php/database/manageCategoryEntries.php");
    require_once("../../digital-logsheets-res/php/objects/logsheetClasses.php");
    require_once("../../digital-logsheets-res/php/select2-preparation.php");
require_once("../../digital-logsheets-res/php/validator/EpisodeValidator.php");
    
    // create object
    $smarty = new Smarty;

    session_start();

$formErrors = $_GET['formErrors'];

    
    //database interactions
    try {
        //connect to database
        $db = connectToDatabase();

        $categories = manageCategoryEntries::getAllCategoriesFromDatabase($db);
        $smarty->assign("categories", $categories);

        $programs = getSelect2ProgramsList($db);
        $smarty->assign("programs", $programs);
        
        //close database connection
        $db = NULL;

        $episodeStartEarlyLimitDatetime = EpisodeValidator::getEpisodeEarlyLimit();
        $episodeStartEarlyLimit = $episodeStartEarlyLimitDatetime->format("Y-m-d H:i:s");
        $smarty->assign("episodeStartEarlyLimit", $episodeStartEarlyLimit);

        $episodeStartLateLimitDatetime = EpisodeValidator::getEpisodeLateLimit();
        $episodeStartLateLimit = $episodeStartLateLimitDatetime->format("Y-m-d H:i:s");
        $smarty->assign("episodeStartLateLimit", $episodeStartLateLimit);

        $prerecordDateEarlyDaysLimit = EpisodeValidator::getPrerecordDateEarlyDaysLimit();
        $smarty->assign("prerecordDateEarlyDaysLimit", $prerecordDateEarlyDaysLimit);
        $prerecordDateLateDaysLimit = EpisodeValidator::getPrerecordDateLateDaysLimit();
        $smarty->assign("prerecordDateLateDaysLimit", $prerecordDateLateDaysLimit);

        $minimumEpisodeLength = EpisodeValidator::getMinEpisodeLengthInHours();
        $smarty->assign("minDuration", $minimumEpisodeLength);
        $maximumEpisodeLength = EpisodeValidator::getMaxEpisodeLengthInHours();
        $smarty->assign("maxDuration", $maximumEpisodeLength);

        if (isset($formErrors)) {
            $smarty->assign("formErrors", $formErrors);
        }

        echo $smarty->fetch('../../digital-logsheets-res/templates/new-logsheet.tpl');

    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
?>