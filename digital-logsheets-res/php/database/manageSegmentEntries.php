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
        private static $durationColumnName = "duration";
        private static $categoryColumnName = "category";

        private static $canConColumnName = "can_con";
        private static $newReleaseColumnName = "new_release";
        private static $frenchVocalColumnName = "french_vocal_music";

        public static function getSegmentAttributesFromDatabase($db_conn, $segment_id, $segment_object) {
            $database_result = readFromDatabase::readFilteredColumnFromTable($db_conn, array(self::$startTimeColumnName, self::$segmentNameColumnName,
                self::$albumColumnName, self::$authorColumnName), self::$segmentTableName, array(self::$idColumnName), array($segment_id));

            $segment_object->setName($database_result[0][self::$segmentNameColumnName]);
            $segment_object->setAlbum($database_result[0][self::$albumColumnName]);
            $segment_object->setAuthor($database_result[0][self::$authorColumnName]);

            $segment_object->setStartTime($database_result[0][self::$startTimeColumnName]);
        }

        public static function editExistingSegmentDuration($db_conn, $segment_object) {
            $column_names = array(self::$durationColumnName);
            $values = array($segment_object->getDuration());

            writeToDatabase::editDatabaseEntry($db_conn, $segment_object->getId(), self::$segmentTableName, $column_names, $values);
        }

        public static function saveNewSegmentToDatabase($db_conn, $start_time, $duration, $name, $author, $album, $category,
                                                        $is_can_con, $is_new_release, $is_french_vocal_music, $ad_number, $playlistId) {

            switch ($category) {
                case 2:
                case 3:
                    $values = self::prepareMusicSegmentEntryValues($start_time, $duration, $name, $author, $album, $category,
                        $is_can_con, $is_new_release, $is_french_vocal_music);
                    break;

                case 5:
                    $values = self::prepareAdSegmentEntryValues($start_time, $duration, $ad_number);
                    break;

                case 4:
                    $values = self::prepareMusicProductionSegmentEntryValues($start_time, $duration, $name, $category, false); //TODO: add hide from listener, add station ID given
                case 1:
                default:
                $values = self::prepareSpokenWordSegmentEntryValues($start_time, $duration, $name, $author, $album, $category, false, false); //TODO: add hide from listener, add station ID given
                    break;
            }

            $column_names = array(self::$startTimeColumnName, self::$durationColumnName, self::$segmentNameColumnName,
                self::$authorColumnName, self::$albumColumnName, self::$categoryColumnName, self::$canConColumnName, self::$newReleaseColumnName, self::$frenchVocalColumnName);

            $segmentId = writeToDatabase::writeEntryToDatabase($db_conn, self::$segmentTableName, $column_names, $values);

            managePlaylistEntries::addSegmentToDatabasePlaylist($db_conn, $playlistId, $segmentId);

            return $segmentId;
        }

        private static function prepareMusicSegmentEntryValues($start_time, $duration, $name, $author, $album, $category,
                                                               $is_can_con, $is_new_release, $is_french_vocal_music) {
            return array($start_time, $duration, $name, $author, $album, $category,
                $is_can_con, $is_new_release, $is_french_vocal_music);
        }

        private static function prepareAdSegmentEntryValues($start_time, $duration, $ad_number) {
            return array($start_time, $duration, $ad_number, null, null, 5, false, false, false);
        }

        private static function prepareMusicProductionSegmentEntryValues($start_time, $duration, $name, $category, $station_id_given) {
            return array($start_time, $duration, $name, null, null, $category,
                false, false, false);
        }

        private static function prepareSpokenWordSegmentEntryValues($start_time, $duration, $name, $author, $album, $category, $station_id_given, $hide_from_listener) {
            return array($start_time, $duration, $name, $author, $album, $category,
                false, false, false);
        }

    }