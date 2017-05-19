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
    include_once("managePlaylistEntries.php");
    include_once(dirname(__FILE__) . "/../objects/Segment.php");

    class manageSegmentEntries {

        const TABLE_NAME = "segment";

        const ID_COLUMN_NAME = "id";

        const SEGMENT_NAME_COLUMN_NAME = "name";
        const SEGMENT_NAME_PARAMETER = ":name";

        const ALBUM_COLUMN_NAME = "album";
        const ALBUM_PARAMETER = ":album";

        const AUTHOR_COLUMN_NAME = "author";
        const AUTHOR_PARAMETER = ":author";

        const START_TIME_COLUMN_NAME = "start_time";
        const START_TIME_PARAMETER = ":startTime";

        const DURATION_COLUMN_NAME = "approx_duration_mins";
        const DURATION_PARAMETER = ":duration";

        const CATEGORY_COLUMN_NAME = "category";
        const CATEGORY_PARAMETER = ":category";

        const STATION_ID_COLUMN_NAME = "station_id";
        const STATION_ID_PARAMETER = ":stationId";


        const AD_NUMBER_COLUMN_NAME = "ad_number";
        const AD_NUMBER_PARAMETER = ":adNumber";

        const CAN_CON_COLUMN_NAME = "can_con";
        const CAN_CON_PARAMETER = ":canCon";

        const NEW_RELEASE_COLUMN_NAME = "new_release";
        const NEW_RELEASE_PARAMETER = ":newRelease";

        const FRENCH_VOCAL_MUSIC_COLUMN_NAME = "french_vocal_music";
        const FRENCH_VOCAL_MUSIC_PARAMETER = ":frenchVocalMusic";




        /**
         * @param PDO $dbConn
         *
         * @param int $segmentId
         *
         * @param Segment $segmentObject
         *
         * @return Segment
         *
         */
        public static function getSegmentAttributesFromDatabase($dbConn, $segmentId, $segmentObject) {
            $dbResult = readFromDatabase::readFilteredColumnFromTable($dbConn, null, self::TABLE_NAME, array(self::ID_COLUMN_NAME), array($segmentId));
            $dbResult = $dbResult[0];

            return self::populateSegmentObject($dbResult, $segmentObject);
        }

        /**
         * @param PDO $dbConn
         * @param DateTime $earliestDateTime
         * @param DateTime $latestDateTime
         * @return array
         */
        public static function getAllSegmentsBetweenTwoStartDateTimes($dbConn, $earliestDateTime, $latestDateTime) {
            $earliestDateTimeString = formatDateStringForDatabaseWrite($earliestDateTime);
            $latestDateTimeString = formatDateStringForDatabaseWrite($latestDateTime);

            $dbResults = readFromDatabase::readAllColumnsBetweenTwoValues(
                $dbConn, self::TABLE_NAME, self::START_TIME_COLUMN_NAME, $earliestDateTimeString, $latestDateTimeString);

            return self::getSegmentsFromDbResults($dbConn, $dbResults);
        }

        public static function getAllSegmentsWithAdNumber($dbConn, $adNumber) {
            $dbResults = readFromDatabase::readFilteredColumnFromTable($dbConn, null, self::TABLE_NAME, array(self::AD_NUMBER_COLUMN_NAME), array($adNumber));

            return self::getSegmentsFromDbResults($dbConn, $dbResults);
        }

        public static function getAllSegmentsWithAlbumName($dbConn, $albumName) {
            $dbResults = readFromDatabase::readFilteredColumnFromTable($dbConn, null, self::TABLE_NAME, array(self::ALBUM_COLUMN_NAME), array($albumName));

            return self::getSegmentsFromDbResults($dbConn, $dbResults);
        }


        /**
         * @param $dbResult
         * @param Segment $segmentObject
         * @return mixed
         */
        private static function populateSegmentObject($dbResult, $segmentObject) {
            $segmentName = $dbResult[self::SEGMENT_NAME_COLUMN_NAME];
            if (is_null($segmentName)) {
                $segmentName = '';
            }
            $segmentObject->setName($segmentName);

            $segmentAlbum = $dbResult[self::ALBUM_COLUMN_NAME];
            if (is_null($segmentAlbum)) {
                $segmentAlbum = '';
            }
            $segmentObject->setAlbum($segmentAlbum);

            $segmentAuthor = $dbResult[self::AUTHOR_COLUMN_NAME];
            if (is_null($segmentAuthor)) {
                $segmentAuthor = '';
            }
            $segmentObject->setAuthor($segmentAuthor);

            $segmentCategory = $dbResult[self::CATEGORY_COLUMN_NAME];
            $segmentObject->setCategory($segmentCategory);

            $segmentDuration = $dbResult[self::DURATION_COLUMN_NAME];
            $segmentObject->setDuration($segmentDuration);

            $segmentAdNumber = $dbResult[self::AD_NUMBER_COLUMN_NAME];
            $segmentObject->setAdNumber($segmentAdNumber);

            $segmentStationIdGiven = $dbResult[self::STATION_ID_COLUMN_NAME];
            $segmentObject->setStationIdGiven($segmentStationIdGiven);

            $segmentCanCon = $dbResult[self::CAN_CON_COLUMN_NAME];
            $segmentObject->setIsCanCon($segmentCanCon);

            $segmentNewRelease = $dbResult[self::NEW_RELEASE_COLUMN_NAME];
            $segmentObject->setIsNewRelease($segmentNewRelease);

            $segmentFrenchVocalMusic = $dbResult[self::FRENCH_VOCAL_MUSIC_COLUMN_NAME];
            $segmentObject->setIsFrenchVocalMusic($segmentFrenchVocalMusic);

            $dbStartTimeString = $dbResult[self::START_TIME_COLUMN_NAME];
            $startDateTime = formatDateTimeStringFromDatabase($dbStartTimeString);
            $segmentObject->setStartTime($startDateTime);

            return $segmentObject;
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
            $query = "INSERT INTO " . self::TABLE_NAME . " " . self::getColumnsQuerySection() . " VALUES " . self::getValuesQuerySection() . ";";
            $stmt = $dbConn->prepare($query);

            $stmt = self::bindParams($stmt, $segmentObject);
            $stmt->execute();
            $segmentId = $dbConn->lastInsertId("id");

            managePlaylistEntries::addSegmentToDatabasePlaylist($dbConn, $segmentObject->getPlaylistId(), $segmentId);

            return $stmt->queryString;
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

        private static function getColumnsQuerySection() {
            return "(" .
                self::START_TIME_COLUMN_NAME . ", " .
                self::DURATION_COLUMN_NAME . ", " .
                self::SEGMENT_NAME_COLUMN_NAME . ", " .
                self::AUTHOR_COLUMN_NAME . ", " .
                self::ALBUM_COLUMN_NAME . ", " .
                self::CATEGORY_COLUMN_NAME . ", " .
                self::AD_NUMBER_COLUMN_NAME . ", " .
                self::STATION_ID_COLUMN_NAME . ", " .
                self::CAN_CON_COLUMN_NAME . ", " .
                self::NEW_RELEASE_COLUMN_NAME . ", " .
                self::FRENCH_VOCAL_MUSIC_COLUMN_NAME . ")";
        }

        private static function getValuesQuerySection() {
            return "(" .
                self::START_TIME_PARAMETER . ", " .
                self::DURATION_PARAMETER . ", " .
                self::SEGMENT_NAME_PARAMETER . ", " .
                self::AUTHOR_PARAMETER . ", " .
                self::ALBUM_PARAMETER . ", " .
                self::CATEGORY_PARAMETER . ", " .
                self::AD_NUMBER_PARAMETER . ", " .
                self::STATION_ID_PARAMETER . ", " .
                self::CAN_CON_PARAMETER . ", " .
                self::NEW_RELEASE_PARAMETER . ", " .
                self::FRENCH_VOCAL_MUSIC_PARAMETER . ")";
        }


        /**
         * @param PDOStatement $stmt
         * @param Segment $segmentObject
         * @return PDOStatement $stmt
         */
        private static function bindParams($stmt, $segmentObject) {
            $startTime = $segmentObject->getStartTime();
            $startTime = formatDateTimeStringForDatabaseWrite($startTime);
            $stmt->bindParam(self::START_TIME_PARAMETER, $startTime);

            $duration = $segmentObject->getDuration();
            $stmt->bindParam(self::DURATION_PARAMETER, $duration);

            $name = $segmentObject->getName();
            $stmt->bindParam(self::SEGMENT_NAME_PARAMETER, $name);

            $author = $segmentObject->getAuthor();
            $stmt->bindParam(self::AUTHOR_PARAMETER, $author);

            $album = $segmentObject->getAlbum();
            $stmt->bindParam(self::ALBUM_PARAMETER, $album);

            $category = $segmentObject->getCategory();
            $stmt->bindParam(self::CATEGORY_PARAMETER, $category);

            $adNumber = $segmentObject->getAdNumber();
            $stmt->bindParam(self::AD_NUMBER_PARAMETER, $adNumber);

            $stationIDGiven = $segmentObject->wasStationIdGiven();
            $stmt->bindParam(self::STATION_ID_PARAMETER, $stationIDGiven);

            $canCon = $segmentObject->isCanCon();
            $stmt->bindParam(self::CAN_CON_PARAMETER, $canCon);

            $newRelease = $segmentObject->isNewRelease();
            $stmt->bindParam(self::NEW_RELEASE_PARAMETER, $newRelease);

            $frenchVocalMusic = $segmentObject->isFrenchVocalMusic();
            $stmt->bindParam(self::FRENCH_VOCAL_MUSIC_PARAMETER, $frenchVocalMusic);

            return $stmt;
        }

        /**
         * @param Segment $segmentObject
         * @return array
         */
        private static function processSegmentForWrite($segmentObject) {

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



            $startDateString = formatDatetimeStringForDatabaseWrite($segmentObject->getStartTime());

            $adNumber = $segmentObject->getAdNumber();
            if ($adNumber == '') {
                $adNumber = null;
            }



            $values = array($startDateString,
                $segmentObject->getDuration(),
                $segmentObject->getName(),
                $segmentObject->getAuthor(),
                $segmentObject->getAlbum(),
                $segmentObject->getCategory(),
                $adNumber,
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

        /**
         * @param $dbConn
         * @param $dbResults
         * @return array
         */
        private static function getSegmentsFromDbResults($dbConn, $dbResults) {
            $segments = array();

            foreach ($dbResults as $dbResult) {
                $segmentFromDbResult = self::populateSegmentObject($dbResult, new Segment($dbConn, null));
                array_push($segments, $segmentFromDbResult);
            }

            return $segments;
        }

    }