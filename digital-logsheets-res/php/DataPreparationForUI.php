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

include_once("database/manageProgramEntries.php");
include_once("objects/logsheetClasses.php");

function getSelect2ProgramsList($db) {
    $programs = manageProgramEntries::getAllProgramsFromDatabase($db);

    $programsArrayForSelect2 = array();
    $programIndex = 0;

    while ($programIndex < count($programs)) {
        while (is_null($programs[$programIndex])) {
            $programIndex++;
        }

        $program = $programs[$programIndex];

        $programsArrayForSelect2[$programIndex] = array("id" => $program->getId(), "text" => $program->getName());
        $programIndex++;
    }

    $programs = json_encode(array_values($programsArrayForSelect2));
    return $programs;
}

/**
 * @param Episode $episode
 * @return array
 */
function getFormSubmissionArray($episode) {

    $program = $episode->getProgram();
    $programId = null;
    $programName = null;

    if ($program) {
        $programId = $program->getId();
        $programName = $program->getName();
    }

    return array(
        'programmer' => $episode->getProgrammer(),
        'programId' => $programId,
        'programName' => $programName,
        'startDatetime' => formatDatetimeForHTML($episode->getStartTime()),
        'endDatetime' => formatDatetimeForHTML($episode->getEndTime()),
        'prerecord' => $episode->isPrerecord(),
        'prerecordDate' => formatDateForHTML($episode->getPrerecordDate()),
        'notes' => $episode->getNotes()
    );
}

/**
 * @param Episode $episode
 * @return String
 */
function getSegmentListWithErrors($episode) {
    $segments = $episode->getSegments();
    $segmentsWithErrorContainers = array();

    foreach ($segments as $segment) {
        $validator = new SegmentValidator($segment, $episode);
        $errors = $validator->isSegmentValidForFinalSave();

        $segmentWithError = array(
            'segment' => $segment->getObjectAsArray(),
            'errors' => $errors->getAllErrors()
        );

        $segmentsWithErrorContainers[] = $segmentWithError;
    }

    return json_encode($segmentsWithErrorContainers);
}

/**
 * @param DateTime $datetime
 * @return String
 */
function formatDatetimeForHTML($datetime) {
    if (!is_null($datetime)) {
        return $datetime->format('Y-m-d\TH:i');
    }
}

/**
 * @param DateTime $datetime
 * @return String
 */
function formatDateForHTML($datetime) {
    if (!is_null($datetime)) {
        return $datetime->format('Y-m-d');
    }
}