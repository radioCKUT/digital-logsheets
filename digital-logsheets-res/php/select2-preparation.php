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

include_once("database/manageProgramEntries.php");

function getSelect2ProgramsList($db) {
    $programs = manageProgramEntries::getAllProgramsFromDatabase($db);

    $programsArrayForSelect2 = array();
    $programsCounter = 0;
    for ($i = 1; $i < count($programs); $i++) {

        while (is_null($programs[$programsCounter])) {
            $programsCounter++;
        }

        $programsArrayForSelect2[$i] = array("id" => $i, "text" => $programs[$programsCounter]);
        $programsCounter++;
    }

    $programs = json_encode(array_values($programsArrayForSelect2));
    return $programs;
}
