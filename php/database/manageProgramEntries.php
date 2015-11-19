<?php

    include_once("readFromDatabase.php");
    class manageProgramEntries {

        private static $tableName = "program";

        private static $idColumnName = "id";
        private static $nameColumnName = "name";

        public static function getProgramNameFromDatabase($db_connection, $program_id) {
            return readFromDatabase::readFirstMatchingEntryFromTable($db_connection, self::$nameColumnName,
                self::$tableName, array(self::$idColumnName), array($program_id));
        }

        public static function getAllProgramsFromDatabase($db_connection) {
            $program_ids = readFromDatabase::readEntireColumnFromTable($db_connection, self::$idColumnName, self::$tableName);

            $programs = array();
            foreach($program_ids as $program_id) {
                $program = new Program($db_connection, $program_id[self::$idColumnName]);
                $programs[$program->getId()] = $program->getName();
            }

            return $programs;
        }
    }