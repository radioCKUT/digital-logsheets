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
    include_once("writeToDatabase.php");
    include_once("formatDateStrings.php");
    include_once(dirname(__FILE__) . "/../objects/logsheetClasses.php");


    class manageEpisodeEntries {

        const TABLE_NAME = "episode";

        const ID_COLUMN_NAME = "id";
        const PROGRAM_COLUMN_NAME = "program";
        const PLAYLIST_COLUMN_NAME = "playlist";
        const PROGRAMMER_COLUMN_NAME = "programmer";
        const START_TIME_COLUMN_NAME = "start_time";
        const END_TIME_COLUMN_NAME = "end_time";

        const IS_PRERECORD_COLUMN_NAME = "prerecord";
        const PRERECORD_COLUMN_NAME = "prerecord_date";
        const IS_DRAFT_COLUMN_NAME = "draft";
        const NOTES_COLUMN_NAME = "comment";

        /**
         * @param PDO $dbConn
         * @param int $episodeId
         * @param Episode $episodeObject
         */
        public static function getEpisodeAttributesFromDatabase($dbConn, $episodeId, $episodeObject) {
            $databaseResults = readFromDatabase::readFilteredColumnFromTable($dbConn, null, self::TABLE_NAME, array(self::ID_COLUMN_NAME), array($episodeId));
            $databaseResults = $databaseResults[0];

            $programId = $databaseResults[self::PROGRAM_COLUMN_NAME];
            $episodeObject->setProgram(new Program($dbConn, $programId));

            $playlistId = $databaseResults[self::PLAYLIST_COLUMN_NAME];
            $episodeObject->setPlaylist(new Playlist($dbConn, $playlistId));

            $programmer = $databaseResults[self::PROGRAMMER_COLUMN_NAME];
            $episodeObject->setProgrammer($programmer);

            $startTimeString = $databaseResults[self::START_TIME_COLUMN_NAME];
            $startDateTime = formatDateTimeStringFromDatabase($startTimeString);
            $episodeObject->setStartTime($startDateTime);

            $endTimeString = $databaseResults[self::END_TIME_COLUMN_NAME];
            $endDateTime = formatDateTimeStringFromDatabase($endTimeString);
            $episodeObject->setEndTime($endDateTime);

            $prerecordDate = $databaseResults[self::PRERECORD_COLUMN_NAME];
            $prerecordDate = new DateTime($prerecordDate);
            $episodeObject->setPrerecordDate($prerecordDate);

            $isPrerecord = $databaseResults[self::IS_PRERECORD_COLUMN_NAME];
            $episodeObject->setIsPrerecord($isPrerecord);

            $notes = $databaseResults[self::NOTES_COLUMN_NAME];
            $episodeObject->setNotes($notes);

            $isDraft = $databaseResults[self::IS_DRAFT_COLUMN_NAME];
            $episodeObject->setIsDraft($isDraft);
        }

        public static function getAllEpisodesFromDatabase($dbConn) {
            $episodeIds = readFromDatabase::readEntireColumnFromTable($dbConn, array(self::ID_COLUMN_NAME), self::TABLE_NAME);

            return self::buildEpisodeObjectsFromIds($dbConn, $episodeIds);
        }

        public static function getAllDraftEpisodesFromDatabase($dbConn) {
            $episodeIds = readFromDatabase::readFilteredColumnFromTable($dbConn, array(self::ID_COLUMN_NAME),
                self::TABLE_NAME, array(self::IS_DRAFT_COLUMN_NAME), array(1));

            return self::buildEpisodeObjectsFromIds($dbConn, $episodeIds);
        }

        /**
         * @param PDO $dbConn
         * @param Episode $episodeObject
         * @return null
         */
        public static function saveNewEpisode($dbConn, $episodeObject) {

            list($columnNames, $values) = self::processEpisodeForWrite($episodeObject);

            return writeToDatabase::writeEntryToDatabase($dbConn, self::TABLE_NAME, $columnNames, $values);
        }

        /**
         * @param PDO $dbConn
         * @param Episode $episodeObject
         * @return null
         */
        public static function editEpisode($dbConn, $episodeObject) {

            list($columnNames, $values) = self::processEpisodeForWrite($episodeObject);

            return writeToDatabase::editDatabaseEntry($dbConn, $episodeObject->getId(), self::TABLE_NAME, $columnNames, $values);
        }






        public static function turnOffEpisodeDraftStatus($dbConn, $episodeObject) {
            $columnNames = array(self::IS_DRAFT_COLUMN_NAME);
            $values = array("false");

            return writeToDatabase::editDatabaseEntry($dbConn, $episodeObject->getId(), self::TABLE_NAME, $columnNames, $values);
        }

        /**
         * @param $dbConn
         * @param $episodeIds
         * @return array
         */
        private static function buildEpisodeObjectsFromIds($dbConn, $episodeIds) {
            $episodes = array();

            if (count($episodeIds)) {
                foreach ($episodeIds as $episodeRow) {
                    $episode = new Episode($dbConn, $episodeRow[self::ID_COLUMN_NAME]);
                    $episodes[$episode->getId()] = $episode;
                }
            }

            return $episodes;
        }

        /**
         * @param $episodeObject
         * @return array
         */
        private static function processEpisodeForWrite($episodeObject) {
            $columnNames = array(self::PLAYLIST_COLUMN_NAME,
                self::PROGRAM_COLUMN_NAME,
                self::PROGRAMMER_COLUMN_NAME,
                self::START_TIME_COLUMN_NAME,
                self::END_TIME_COLUMN_NAME,
                self::IS_PRERECORD_COLUMN_NAME,
                self::PRERECORD_COLUMN_NAME,
                self::NOTES_COLUMN_NAME,
                self::IS_DRAFT_COLUMN_NAME);

            $startDateTimeObject = formatDatetimeStringForDatabaseWrite($episodeObject->getStartTime());
            $endDateTimeObject = formatDatetimeStringForDatabaseWrite($episodeObject->getEndTime());
            $prerecordDateTimeObject = formatDateStringForDatabaseWrite($episodeObject->getPrerecordDate());

            $values = array($episodeObject->getPlaylist()->getId(),
                $episodeObject->getProgram()->getId(),
                $episodeObject->getProgrammer(),
                $startDateTimeObject,
                $endDateTimeObject,
                $episodeObject->isPrerecord(),
                $prerecordDateTimeObject,
                $episodeObject->getNotes(),
                true);
            return array($columnNames, $values);
        }

    }