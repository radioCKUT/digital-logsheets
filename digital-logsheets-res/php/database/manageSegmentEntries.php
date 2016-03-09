<?php

    include_once("readFromDatabase.php");
    include_once("writeToDatabase.php");
    include_once("managePlaylistEntries.php");
    include_once(__DIR__ . "/../objects/Segment.php");

    class manageSegmentEntries {

        private static $segmentTableName = "segment";

        private static $idColumnName = "id";
        private static $segmentNameColumnName = "name";
        private static $albumColumnName = "album";
        private static $authorColumnName = "author";

        private static $startTimeColumnName = "start_time";
        private static $durationColumnName = "approx_duration_mins";
        private static $categoryColumnName = "category";

        private static $canConColumnName = "can_con";
        private static $newReleaseColumnName = "new_release";
        private static $frenchVocalColumnName = "french_vocal_music";

        /**
         * @param PDO $db_conn
         *
         * @param int $segment_id
         *
         * @param Segment $segment_object
         *
         */
        public static function getSegmentAttributesFromDatabase($db_conn, $segment_id, $segment_object) {
            $database_result = readFromDatabase::readFilteredColumnFromTable($db_conn, null, self::$segmentTableName, array(self::$idColumnName), array($segment_id));


            $segment_name = $database_result[0][self::$segmentNameColumnName];
            $segment_object->setName($segment_name);

            $segment_album = $database_result[0][self::$albumColumnName];
            $segment_object->setAlbum($segment_album);

            $segment_author = $database_result[0][self::$authorColumnName];
            $segment_object->setAuthor($segment_author);

            $segment_category = $database_result[0][self::$categoryColumnName];
            $segment_object->setCategory($segment_category);

            $segment_duration = $database_result[0][self::$durationColumnName];
            $segment_object->setDuration($segment_duration);

            $segment_can_con = $database_result[0][self::$canConColumnName];
            $segment_object->setIsCanCon($segment_can_con);

            $segment_new_release = $database_result[0][self::$newReleaseColumnName];
            $segment_object->setIsNewRelease($segment_new_release);

            $segment_french_vocal_music = $database_result[0][self::$frenchVocalColumnName];
            $segment_object->setIsFrenchVocalMusic($segment_french_vocal_music);

            $dbStartTimeString = $database_result[0][self::$startTimeColumnName];
            $startDateTime = formatDateStringFromDatabase($dbStartTimeString);
            $segment_object->setStartTime($startDateTime);
        }

        /**
         * @param PDO $db_conn
         *
         * @param Segment $segment_object
         *
         */
        public static function editExistingSegmentDuration($db_conn, $segment_object) {
            $column_names = array(self::$durationColumnName);
            $values = array($segment_object->getDuration());

            error_log("segment duration: " . $segment_object->getDuration());

            writeToDatabase::editDatabaseEntry($db_conn, $segment_object->getId(), self::$segmentTableName, $column_names, $values);
        }

        /**
         * @param PDO $db_conn
         *
         * @param Segment $segment_object
         *
         * @return int
         */
        public static function saveNewSegmentToDatabase($db_conn, $segment_object)
        {
            list($column_names, $values) = self::processSegmentForWrite($segment_object);
            $segmentId = writeToDatabase::writeEntryToDatabase($db_conn, self::$segmentTableName, $column_names, $values);

            managePlaylistEntries::addSegmentToDatabasePlaylist($db_conn, $segment_object->getPlaylistId(), $segmentId);

            return $segmentId;
        }

        /**
         * @param PDO $db_conn
         * @param Segment $segment_object
         */
        public static function editSegmentInDatabase($db_conn, $segment_object)
        {
            list($column_names, $values) = self::processSegmentForWrite($segment_object);

            writeToDatabase::editDatabaseEntry($db_conn, $segment_object->getId(), self::$segmentTableName, $column_names, $values);
        }

        /**
         * @param Segment $segment_object
         * @return array
         */
        private static function processSegmentForWrite($segment_object)
        {
            $startDateString = formatDateStringForDatabaseWrite($segment_object->getStartTime());

            $column_names = array(self::$startTimeColumnName, self::$durationColumnName, self::$segmentNameColumnName,
                self::$authorColumnName, self::$albumColumnName, self::$categoryColumnName, self::$canConColumnName, self::$newReleaseColumnName, self::$frenchVocalColumnName);

            $values = array($startDateString, $segment_object->getDuration(), $segment_object->getName(),
                $segment_object->getAuthor(), $segment_object->getAlbum(), $segment_object->getCategory(),
                $segment_object->isCanCon(), $segment_object->isNewRelease(), $segment_object->isFrenchVocalMusic());

            return array($column_names, $values);
        }

        public static function deleteSegmentFromDatabase($db_conn, $segment_id)
        {
            writeToDatabase::deleteDatabaseEntry($db_conn, $segment_id, self::$segmentTableName);
        }

    }