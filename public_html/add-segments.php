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

    //----INCLUDE FILES----
    include_once("../digital-logsheets-res/smarty/libs/Smarty.class.php");
    include_once("../digital-logsheets-res/php/database/connectToDatabase.php");
    include_once("../digital-logsheets-res/php/database/manageCategoryEntries.php");
    include_once("../digital-logsheets-res/php/database/manageProgramEntries.php");
    require_once("../digital-logsheets-res/php/objects/logsheetClasses.php");
    include('session.php');

    // create object
    $smarty = new Smarty;

    $formErrors = $_GET['formErrors'];

    //database interactions
    try {
        //connect to database
        $db = connectToDatabase();

        $categories = manageCategoryEntries::getAllCategoriesFromDatabase($db);
        $smarty->assign("categories", $categories);

        $programs = manageProgramEntries::getAllProgramsFromDatabase($db);
        $smarty->assign("programs", $programs);

        $episodeId = $_SESSION['episodeId'];
        $episode = new Episode($db, $episodeId);
        $episodeArray = $episode->getObjectAsArray();
        $smarty->assign("episode", $episodeArray);

        if (isset($formErrors)) {
            $smarty->assign("formErrors", $formErrors);
        }

        //close database connection
        $db = NULL;

        echo $smarty->fetch('../digital-logsheets-res/templates/add-segments.tpl');
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }