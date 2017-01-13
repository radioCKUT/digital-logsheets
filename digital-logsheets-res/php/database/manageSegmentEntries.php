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

include_once("readFromDatabase.php");
    include_once("writeToDatabase.php");
    include_once("managePlaylistEntries.php");
    include_once(__DIR__ . "/../objects/Segment.php");

    class manageSegmentEntries {

        const TABLE_NAME = "segment";

        const ID_COLUMN_NAME = "id";
        const SEGMENT_NAME_COLUMN_NAME = "name";
        const ALBUM_COLUMN_NAME = "album";
        const AUTHOR_COLUMN_NAME = "author";

        const START_TIME_COLUMN_NAME = "start_time";
        const DURATION_COLUMN_NAME = "approx_duration_mins";
        const CATEGORY_COLUMN_NAME = "category";

        const STATION_ID_COLUMN_NAME = "station_id";
        const AD_NUMBER_COLUMN_NAME = "ad_number";
        const CAN_CON_COLUMN_NAME = "can_con";
        const NEW_RELEASE_COLUMN_NAME = "new_release";
        const FRENCH_VOCAL_MUSIC_COLUMN_NAME = "french_vocal_music";

        /**
         * @param PDO $dbConn
         *
         * @param int $segmentId
         *
         * @param Segment $segmentObject
         *
         */
        public static function getSegmentAttributesFromDatabase($dbConn, $segmentId, $segmentObject) {
            $databaseResult = readFromDatabase::readFilteredColumnFromTable($dbConn, null, self::TABLE_NAME, array(self::ID_COLUMN_NAME), array($segmentId));
            $databaseResult = $databaseResult[0];

            $segmentName = $databaseResult[self::SEGMENT_NAME_COLUMN_NAME];
            $segmentObject->setName($segmentName);

            $segmentAlbum = $databaseResult[self::ALBUM_COLUMN_NAME];
            $segmentObject->setAlbum($segmentAlbum);

            $segmentAuthor = $databaseResult[self::AUTHOR_COLUMN_NAME];
            $segmentObject->setAuthor($segmentAuthor);

            $segmentCategory = $databaseResult[self::CATEGORY_COLUMN_NAME];
            $segmentObject->setCategory($segmentCategory);

            $segmentDuration = $databaseResult[self::DURATION_COLUMN_NAME];
            $segmentObject->setDuration($segmentDuration);

            $segmentAdNumber = $databaseResult[self::AD_NUMBER_COLUMN_NAME];
            $segmentObject->setAdNumber($segmentAdNumber);

            $segmentStationIdGiven = $databaseResult[self::STATION_ID_COLUMN_NAME];
            $segmentObject->setStationIdGiven($segmentStationIdGiven);

            $segmentCanCon = $databaseResult[self::CAN_CON_COLUMN_NAME];
            $segmentObject->setIsCanCon($segmentCanCon);

            $segmentNewRelease = $databaseResult[self::NEW_RELEASE_COLUMN_NAME];
            $segmentObject->setIsNewRelease($segmentNewRelease);

            $segmentFrenchVocalMusic = $databaseResult[self::FRENCH_VOCAL_MUSIC_COLUMN_NAME];
            $segmentObject->setIsFrenchVocalMusic($segmentFrenchVocalMusic);

            $dbStartTimeString = $databaseResult[self::START_TIME_COLUMN_NAME];
            $startDateTime = formatDateTimeStringFromDatabase($dbStartTimeString);
            $segmentObject->setStartTime($startDateTime);
        }

        /**
         * @param PDO $dbConn
         *
         * @param Segment $segmentObject
         *
         */
        public static function editExistingSegmentDuration($dbConn, $segmentObject) {
            $columnNames = array(self::DURATION_COLUMN_NAME);
            $values = array($segmentObject->getDuration());

            writeToDatabase::editDatabaseEntry($dbConn, $segmentObject->getId(), self::TABLE_NAME, $columnNames, $values);
        }

        /**
         * @param PDO $dbConn
         *
         * @param Segment $segmentObject
         *
         * @return int
         */
        public static function saveNewSegmentToDatabase($dbConn, $segmentObject) {
            list($columnNames, $values) = self::processSegmentForWrite($segmentObject);
            $segmentId = writeToDatabase::writeEntryToDatabase($dbConn, self::TABLE_NAME, $columnNames, $values);

            managePlaylistEntries::addSegmentToDatabasePlaylist($dbConn, $segmentObject->getPlaylistId(), $segmentId);

            return $segmentId;
        }

        /**
         * @param PDO $dbConn
         * @param Segment $segmentObject
         */
        public static function editSegmentInDatabase($dbConn, $segmentObject)
        {
            list($columnNames, $values) = self::processSegmentForWrite($segmentObject);

            writeToDatabase::editDatabaseEntry($dbConn, $segmentObject->getId(), self::TABLE_NAME, $columnNames, $values);
        }

        /**
         * @param Segment $segmentObject
         * @return array
         */
        private static function processSegmentForWrite($segmentObject) {
            $startDateString = formatDatetimeStringForDatabaseWrite($segmentObject->getStartTime());

            $columnNames = array(self::START_TIME_COLUMN_NAME,
                self::DURATION_COLUMN_NAME,
                self::SEGMENT_NAME_COLUMN_NAME,
                self::AUTHOR_COLUMN_NAME,
                self::ALBUM_COLUMN_NAME,
                self::CATEGORY_COLUMN_NAME,
                self::AD_NUMBER_COLUMN_NAME,
                self::STATION_ID_COLUMN_NAME,
                self::CAN_CON_COLUMN_NAME,
                self::NEW_RELEASE_COLUMN_NAME,
                self::FRENCH_VOCAL_MUSIC_COLUMN_NAME);

            $values = array($startDateString,
                $segmentObject->getDuration(),
                $segmentObject->getName(),
                $segmentObject->getAuthor(),
                $segmentObject->getAlbum(),
                $segmentObject->getCategory(),
                $segmentObject->getAdNumber(),
                $segmentObject->wasStationIdGiven(),
                $segmentObject->isCanCon(),
                $segmentObject->isNewRelease(),
                $segmentObject->isFrenchVocalMusic());

            return array($columnNames, $values);
        }

        public static function deleteSegmentFromDatabase($dbConn, $segmentId) {
            writeToDatabase::deleteDatabaseEntry($dbConn, $segmentId, self::TABLE_NAME);
        }

        /**
         * @param $dbConn
         * @param $episodeId
         * @return Segment[]
         */
        public static function getAllSegmentsForEpisodeId($dbConn, $episodeId) {
            $episode = new Episode($dbConn, $episodeId);
            $playlistId = $episode->getPlaylistId();

            $segments = managePlaylistEntries::getPlaylistSegmentsFromDatabase($dbConn, $playlistId);

            return $segments;
        }

    }