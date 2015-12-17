<?php

    include_once("readFromDatabase.php");
    include_once("writeToDatabase.php");
    include_once("managePlaylistEntries.php");
    class manageSegmentEntries {

        private static $segmentTableName = "segment";

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

        public static function getSegmentAttributesFromDatabase($db_conn, $segment_id, $segment_object) {
            $database_result = readFromDatabase::readFilteredColumnFromTable($db_conn, array(self::$segmentNameColumnName,
                self::$albumColumnName, self::$authorColumnName), self::$segmentTableName, array(self::$idColumnName), array($segment_id));

            $segment_object->setName($database_result[0][self::$segmentNameColumnName]);
            $segment_object->setAlbum($database_result[0][self::$albumColumnName]);
            $segment_object->setAuthor($database_result[0][self::$authorColumnName]);
        }

        public static function saveNewSegmentToDatabase($db_conn, $start_time, $duration, $name, $author, $album, $category,
                                                        $is_can_con, $is_new_release, $is_french_vocal_music, $playlistId) {

            switch ($category) {
                case 2:
                case 3:
                    $values = self::prepareMusicSegmentEntryValues($start_time, $duration, $name, $author, $album, $category,
                        $is_can_con, $is_new_release, $is_french_vocal_music);
                    break;

                case 5:
                    $values = self::prepareAdSegmentEntryValues($start_time, $duration, $name, 0); //TODO: add ad number
                    break;

                case 1:
                case 4:
                default:
                    $values = self::prepareOtherSegmentEntryValues($start_time, $duration, $name, $category, false, false); //TODO: add hide from listener, add station ID given
                    break;
            }

            $column_names = array(self::$startTimeColumnName, self::$durationColumnName, self::$segmentNameColumnName,
                self::$authorColumnName, self::$albumColumnName, self::$categoryColumnName, self::$canConColumnName, self::$newReleaseColumnName, self::$frenchVocalColumnName);

            $segmentId = writeToDatabase::writeEntryToDatabase($db_conn, self::$segmentTableName, $column_names, $values);
            error_log("playlistId passed: " . $playlistId);
            managePlaylistEntries::addSegmentToDatabasePlaylist($db_conn, $playlistId, $segmentId);

            return $segmentId;
        }

        private static function prepareMusicSegmentEntryValues($start_time, $duration, $name, $author, $album, $category,
                                                               $is_can_con, $is_new_release, $is_french_vocal_music) {

            return array($start_time, $duration, $name, $author, $album, $category,
                $is_can_con, $is_new_release, $is_french_vocal_music);
        }

        private static function prepareAdSegmentEntryValues($start_time, $duration, $name, $ad_number) {
            return array($start_time, $duration, $name, null, null, 5, false, false, false);
        }

        private static function prepareOtherSegmentEntryValues($start_time, $duration, $name, $category, $station_id_given, $hide_from_listener) {
            return array($start_time, $duration, $name, null, null, $category,
                false, false, false);
        }

    }