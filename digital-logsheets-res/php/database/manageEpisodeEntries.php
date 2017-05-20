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
    include_once("formatDateStrings.php");
    include_once(dirname(__FILE__) . "/../objects/logsheetClasses.php");


    class manageEpisodeEntries {

        const TABLE_NAME = "episode";

        const ID_COLUMN_NAME = "id";
        const ID_PARAMETER = ":id";

        const PROGRAM_COLUMN_NAME = "program";
        const PROGRAM_PARAMETER = ":program";

        const PLAYLIST_COLUMN_NAME = "playlist";
        const PLAYLIST_PARAMETER = ":playlist";

        const PROGRAMMER_COLUMN_NAME = "programmer";
        const PROGRAMMER_PARAMETER = ":programmer";

        const START_TIME_COLUMN_NAME = "start_time";
        const START_TIME_PARAMETER = ":start_time";

        const END_TIME_COLUMN_NAME = "end_time";
        const END_TIME_PARAMETER = ":end_time";

        const IS_PRERECORD_COLUMN_NAME = "prerecord";
        const IS_PRERECORD_PARAMETER = ":prerecord";

        const PRERECORD_DATE_COLUMN_NAME = "prerecord_date";
        const PRERECORD_DATE_PARAMETER = ":prerecord_date";


        const IS_DRAFT_COLUMN_NAME = "draft";
        const IS_DRAFT_PARAMETER = ":draft";

        const NOTES_COLUMN_NAME = "comment";
        const NOTES_PARAMETER = ":comment";

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

            $prerecordDate = $databaseResults[self::PRERECORD_DATE_COLUMN_NAME];
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
         * @return int
         */
        public static function saveNewEpisode($dbConn, $episodeObject) {
            $query = "INSERT INTO " . self::TABLE_NAME . " " . self::getEpisodeColumnsSection() .
                " VALUES " . self::getEpisodeValuesSection() . ";";

            $stmt = $dbConn->prepare($query);
            $stmt = self::bindEpisodeParams($stmt, $episodeObject);
            $stmt->execute();

            return $dbConn->lastInsertId();
        }

        /**
         * @param PDO $dbConn
         * @param Episode $episodeObject
         * @return null
         */
        public static function editEpisode($dbConn, $episodeObject) {
            $query = "UPDATE " . self::TABLE_NAME . " SET " .
                self::PLAYLIST_COLUMN_NAME . "=" . self::PLAYLIST_PARAMETER . ", " .
                self::PROGRAM_COLUMN_NAME . "=" . self::PROGRAM_PARAMETER . ", " .
                self::PROGRAMMER_COLUMN_NAME . "=" . self::PROGRAMMER_PARAMETER . ", " .
                self::START_TIME_COLUMN_NAME . "=" . self::START_TIME_PARAMETER . ", " .
                self::END_TIME_COLUMN_NAME . "=" . self::END_TIME_PARAMETER . ", " .
                self::IS_PRERECORD_COLUMN_NAME . "=" . self::IS_PRERECORD_PARAMETER . ", " .
                self::PRERECORD_DATE_COLUMN_NAME . "=" . self::PRERECORD_DATE_PARAMETER . ", " .
                self::NOTES_COLUMN_NAME . "=" . self::NOTES_PARAMETER . ", " .
                self::IS_DRAFT_COLUMN_NAME . "=" . self::IS_DRAFT_PARAMETER .
                " WHERE " . self::ID_COLUMN_NAME . "=" . self::ID_PARAMETER . ";";

            $stmt = $dbConn->prepare($query);

            $stmt = self::bindEpisodeParams($stmt, $episodeObject);
            $id = $episodeObject->getId();
            $stmt->bindParam(self::ID_PARAMETER, $id);

            $stmt->execute();

            return $dbConn->lastInsertId();
        }


        /**
         * @param PDO $dbConn
         * @param Episode $episodeObject
         * @return null
         */
        public static function turnOffEpisodeDraftStatus($dbConn, $episodeObject) {
            $query = "UPDATE " . self::TABLE_NAME . " SET " .
                self::IS_DRAFT_COLUMN_NAME . "=" . self::IS_DRAFT_PARAMETER .
                " WHERE " . self::ID_COLUMN_NAME . "=" . self::ID_PARAMETER . ";";

            $stmt = $dbConn->prepare($query);

            $stmt->bindValue(self::IS_DRAFT_PARAMETER, false);
            $episodeId = $episodeObject->getId();
            $stmt->bindValue(self::ID_PARAMETER, $episodeId);

            $stmt->execute();

            return $dbConn->lastInsertId();
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



        private static function getEpisodeColumnsSection() {
            return "(" .
                self::PLAYLIST_COLUMN_NAME . ", " .
                self::PROGRAM_COLUMN_NAME . ", " .
                self::PROGRAMMER_COLUMN_NAME . ", " .
                self::START_TIME_COLUMN_NAME . ", " .
                self::END_TIME_COLUMN_NAME . ", " .
                self::IS_PRERECORD_COLUMN_NAME . ", " .
                self::PRERECORD_DATE_COLUMN_NAME . ", " .
                self::NOTES_COLUMN_NAME . ", " .
                self::IS_DRAFT_COLUMN_NAME . ")";
        }

        private static function getEpisodeValuesSection() {
            return "(" .
                self::PLAYLIST_PARAMETER . ", " .
                self::PROGRAM_PARAMETER . ", " .
                self::PROGRAMMER_PARAMETER . ", " .
                self::START_TIME_PARAMETER . ", " .
                self::END_TIME_PARAMETER . ", " .
                self::IS_PRERECORD_PARAMETER . ", " .
                self::PRERECORD_DATE_PARAMETER . ", " .
                self::NOTES_PARAMETER . ", " .
                self::IS_DRAFT_PARAMETER . ")";
        }

        /**
         * @param PDOStatement $stmt
         * @param Episode $episodeObject
         * @return PDOStatement
         */
        private static function bindEpisodeParams($stmt, $episodeObject) {
            $playlist = $episodeObject->getPlaylistId();
            $stmt->bindParam(self::PLAYLIST_PARAMETER, $playlist);

            $program = $episodeObject->getProgram();
            if ($program != null) {
                $program = $program->getId();
            }
            $stmt->bindParam(self::PROGRAM_PARAMETER, $program);

            $programmer = $episodeObject->getProgrammer();
            $stmt->bindParam(self::PROGRAMMER_PARAMETER, $programmer);

            $startTime = $episodeObject->getStartTime();
            $startTime = formatDatetimeStringForDatabaseWrite($startTime);
            $stmt->bindParam(self::START_TIME_PARAMETER, $startTime);

            $endTime = $episodeObject->getEndTime();
            $endTime = formatDatetimeStringForDatabaseWrite($endTime);
            $stmt->bindParam(self::END_TIME_PARAMETER, $endTime);

            $isPrerecord = $episodeObject->isPrerecord();
            $stmt->bindParam(self::IS_PRERECORD_PARAMETER, $isPrerecord);

            $prerecordDate = $episodeObject->getPrerecordDate();
            $prerecordDate = formatDateStringForDatabaseWrite($prerecordDate);
            $stmt->bindParam(self::PRERECORD_DATE_PARAMETER, $prerecordDate);

            $notes = $episodeObject->getNotes();
            $stmt->bindParam(self::NOTES_PARAMETER, $notes);

            $isDraft = $episodeObject->isDraft();
            $stmt->bindParam(self::IS_DRAFT_PARAMETER, $isDraft);

            return $stmt;
        }

    }