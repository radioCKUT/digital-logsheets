<?php
include_once("database/manageProgramEntries.php");

function getSelect2ProgramsList($db) {
    $programs = manageProgramEntries::getAllProgramsFromDatabase($db);

    $programsArrayForSelect2 = array();
    for ($i = 1; $i < count($programs); $i++) {
        $programsArrayForSelect2[$i] = array("id" => $i, "text" => $programs[$i]);
    }

    $programs = json_encode(array_values($programsArrayForSelect2));
    return $programs;
}
