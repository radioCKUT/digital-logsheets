<?php

    include_once("readFromDatabase.php");
    class manageProgramEntries {

        const TABLE_NAME = "program";

        const ID_COLUMN_NAME = "id";
        const PROGRAM_NAME_COLUMN_NAME = "name";

        public static function getProgramNameFromDatabase($db_conn, $program_id) {
            return readFromDatabase::readFirstMatchingEntryFromTable($db_conn, array(self::PROGRAM_NAME_COLUMN_NAME),
                self::TABLE_NAME, array(self::ID_COLUMN_NAME), array($program_id));
        }

        public static function getAllProgramsFromDatabase($db_conn) {
            $program_ids = readFromDatabase::readEntireColumnFromTable($db_conn, array(self::ID_COLUMN_NAME), self::TABLE_NAME);

            $programs = array();
            foreach($program_ids as $program_id) {
                $program = new Program($db_conn, $program_id[self::ID_COLUMN_NAME]);
                $programs[$program->getId()] = $program->getName();
            }

            return $programs;
        }
    }