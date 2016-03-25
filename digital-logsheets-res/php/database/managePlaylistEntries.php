<?php

    include_once("readFromDatabase.php");
    include_once("writeToDatabase.php");
    include_once(__DIR__ . "/../objects/logsheet-classes.php");

    class managePlaylistEntries {

        const PLAYLIST_SEGMENTS_TABLE_NAME = "playlist_segments";
        const PLAYLIST_TABLE_NAME = "playlist";

        const SEGMENT_COLUMN_NAME = "segment";
        const PLAYLIST_COLUMN_NAME = "playlist";

        public static function getPlaylistSegmentsFromDatabase($db_conn, $playlist_id) {
            $segment_ids = readFromDatabase::readFilteredColumnFromTable($db_conn, array(self::SEGMENT_COLUMN_NAME),
                self::PLAYLIST_SEGMENTS_TABLE_NAME, array(self::PLAYLIST_COLUMN_NAME), array($playlist_id));

            $segments = array();
            $count = 0;

            //make Segments for each segment id and store in an array (segments)
            if (count($segment_ids)) {
                foreach ($segment_ids as $segment_id) {
                    $segments[$count++] =
                        new Segment($db_conn, $segment_id[self::SEGMENT_COLUMN_NAME]);
                }
            }

            usort($segments, function ($a, $b) {
                return ($a->getStartTime() > $b->getStartTime());
            });

            return $segments;
        }

        public static function createNewPlaylist($db_conn){
            return writeToDatabase::writeEntryToDatabase($db_conn, self::PLAYLIST_TABLE_NAME, array(), array());
        }

        public static function addSegmentToDatabasePlaylist($db_conn, $playlist_id, $segment_id) {
            $column_names = array(self::PLAYLIST_COLUMN_NAME, self::SEGMENT_COLUMN_NAME);
            $values = array($playlist_id, $segment_id);

            error_log("adding segment to playlist: " . $playlist_id);

            return writeToDatabase::writeEntryToDatabase($db_conn, self::TABLE_NAME, $column_names, $values);
        }
    }