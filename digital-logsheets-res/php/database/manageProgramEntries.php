<?php

    include_once("readFromDatabase.php");
    class manageProgramEntries {

        private static $programTableName = "program";

        private static $idColumnName = "id";
        private static $nameColumnName = "name";

        public static function getProgramNameFromDatabase($db_conn, $program_id) {
            return readFromDatabase::readFirstMatchingEntryFromTable($db_conn, array(self::$nameColumnName),
                self::$programTableName, array(self::$idColumnName), array($program_id));
        }

        public static function getAllProgramsFromDatabase($db_conn) {
            $program_ids = readFromDatabase::readEntireColumnFromTable($db_conn, array(self::$idColumnName), self::$programTableName);

            $programs = array();
            foreach($program_ids as $program_id) {
                $program = new Program($db_conn, $program_id[self::$idColumnName]);
                $programs[$program->getId()] = $program->getName();
            }

            return $programs;
        }
    }