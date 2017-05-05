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

            return self::buildProgramObjectsFromIds($dbConn, $programIds);
        }

        public static function getProgramFromDatabase($dbConn, $programId) {
            $programIds = readFromDatabase::readFilteredColumnFromTable($dbConn, array(self::ID_COLUMN_NAME),
                self::TABLE_NAME, array(self::ID_COLUMN_NAME), $programId);

            return self::buildProgramObjectsFromIds($dbConn, $programIds);
        }

        /**
         * @param $dbConn
         * @param $programIds
         * @return array
         */
        private static function buildProgramObjectsFromIds($dbConn, $programIds) {
            $programs = array();
            foreach ($programIds as $programId) {
                $program = new Program($dbConn, $programId[self::ID_COLUMN_NAME]);
                $programs[$program->getId()] = $program->getName();
            }

            return $programs;
        }
    }