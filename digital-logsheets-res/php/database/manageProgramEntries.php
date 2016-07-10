<?php

    include_once("readFromDatabase.php");
    class manageProgramEntries {

        const TABLE_NAME = "program";

        const ID_COLUMN_NAME = "id";
        const PROGRAM_NAME_COLUMN_NAME = "name";

        public static function getProgramNameFromDatabase($dbConn, $programId) {
            return readFromDatabase::readFirstMatchingEntryFromTable($dbConn, array(self::PROGRAM_NAME_COLUMN_NAME),
                self::TABLE_NAME, array(self::ID_COLUMN_NAME), array($programId));
        }

        public static function getAllProgramsFromDatabase($dbConn) {
            $programIds = readFromDatabase::readEntireColumnFromTable($dbConn, array(self::ID_COLUMN_NAME), self::TABLE_NAME);

            $programs = array();
            foreach($programIds as $programId) {
                $program = new Program($dbConn, $programId[self::ID_COLUMN_NAME]);
                $programs[$program->getId()] = $program->getName();
            }

            return $programs;
        }
    }