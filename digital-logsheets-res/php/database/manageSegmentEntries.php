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
            $database_result = readFromDatabase::readFilteredColumnFromTable($db_conn, array(self::$startTimeColumnName, self::$segmentNameColumnName,
                self::$albumColumnName, self::$authorColumnName), self::$segmentTableName, array(self::$idColumnName), array($segment_id));

            $segmentName = $database_result[0][self::$segmentNameColumnName];
            $segmentAlbum = $database_result[0][self::$albumColumnName];
            $segmentAuthor = $database_result[0][self::$authorColumnName];

            $segment_object->setName($segmentName);
            $segment_object->setAlbum($segmentAlbum);
            $segment_object->setAuthor($segmentAuthor);

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
            $startDateString = formatDateStringForDatabaseWrite($segment_object->getStartTime());

            $column_names = array(self::$startTimeColumnName, self::$durationColumnName, self::$segmentNameColumnName,
                self::$authorColumnName, self::$albumColumnName, self::$categoryColumnName, self::$canConColumnName, self::$newReleaseColumnName, self::$frenchVocalColumnName);

            $values = array($startDateString, $segment_object->getDuration(), $segment_object->getName(),
                $segment_object->getAuthor(), $segment_object->getAlbum(), $segment_object->getCategory(),
                $segment_object->isCanCon(), $segment_object->isNewRelease(), $segment_object->isFrenchVocalMusic());

            $segmentId = writeToDatabase::writeEntryToDatabase($db_conn, self::$segmentTableName, $column_names, $values);

            managePlaylistEntries::addSegmentToDatabasePlaylist($db_conn, $segment_object->getPlaylistId(), $segmentId);

            return $segmentId;
        }

        public static function deleteSegmentFromDatabase($db_conn, $segment_id)
        {
            writeToDatabase::deleteDatabaseEntry($db_conn, $segment_id, self::$segmentTableName);
        }

    }