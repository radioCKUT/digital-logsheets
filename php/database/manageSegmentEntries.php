<?php

    include_once("readFromDatabase.php");
    include_once("writeToDatabase.php");
    include_once("managePlaylistEntries.php");
    class manageSegmentEntries {

        private static $tableName = "segment";

        private static $idColumnName = "id";
        private static $segmentNameColumnName = "name";
        private static $albumColumnName = "album";
        private static $authorColumnName = "author";

        private static $startTimeColumnName = "start_time";
        private static $durationColumnName = "duration";
        private static $categoryColumnName = "category";

        private static $canConColumnName = "can_con";
        private static $newReleaseColumnName = "new_release";
        private static $frenchVocalColumnName = "french_vocal_music";


        public static function getSegmentAttributesFromDatabase($db_connection, $segment_id, $segment_object) {
            $database_result = readFromDatabase::readFilteredColumnFromTable($db_connection, array(self::$segmentNameColumnName,
                self::$albumColumnName, self::$authorColumnName), self::$tableName, array(self::$idColumnName), array($segment_id));

            $segment_object->setName($database_result[0][self::$segmentNameColumnName]);
            $segment_object->setAlbum($database_result[0][self::$albumColumnName]);
            $segment_object->setAuthor($database_result[0][self::$authorColumnName]);
        }

        public static function saveNewSegmentToDatabase($db_conn, $start_time, $duration, $name, $author, $category,
                                                        $is_can_con, $is_new_release, $is_french_vocal_music, $playlistId) {

            $column_names = array(self::$startTimeColumnName, self::$durationColumnName, self::$segmentNameColumnName,
                self::$authorColumnName, self::$categoryColumnName, self::$canConColumnName, self::$newReleaseColumnName, self::$frenchVocalColumnName);
            $values = array($start_time, $duration, $name, $author, $category,
                $is_can_con, $is_new_release, $is_french_vocal_music);

            $segmentId = writeToDatabase::writeEntryToDatabase($db_conn, self::$tableName, $column_names, $values);

            managePlaylistEntries::addSegmentToDatabasePlaylist($db_conn, $playlistId, $segmentId);

            return $segmentId;
        }

    }