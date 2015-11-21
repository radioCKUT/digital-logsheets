<?php

    include_once("readFromDatabase.php");
    include_once("writeToDatabase.php");
    class managePlaylistEntries {

        private static $playlistSegmentsTableName = "playlist_segments";
        private static $playlistTableName = "playlist";

        private static $segmentColumnName = "segment";
        private static $playlistColumnName = "playlist";

        public static function getPlaylistSegmentsFromDatabase($db_connection, $playlist_id) {
            $segment_ids = readFromDatabase::readFilteredColumnFromTable($db_connection, array(self::$segmentColumnName),
                self::$playlistSegmentsTableName, array(self::$playlistColumnName), array($playlist_id));

            $segments = array();

            //make Segments for each segment id and store in an array (segments)
            if (count($segment_ids)) {
                foreach ($segment_ids as $segment_id) {
                    $segments[$segment_id[self::$segmentColumnName]] =
                        new Segment($db_connection, $segment_id[self::$segmentColumnName]);
                }
            }

            return $segments;
        }

        public static function createNewPlaylist($db_conn){
            return writeToDatabase::writeEntryToDatabase($db_conn, self::$playlistTableName, array(), array());
        }

        public static function addSegmentToDatabasePlaylist($db_conn, $playlist_id, $segment_id) {
            $column_names = array(self::$playlistColumnName, self::$segmentColumnName);
            $values = array($playlist_id, $segment_id);

            return writeToDatabase::writeEntryToDatabase($db_conn, self::$playlistSegmentsTableName, $column_names, $values);
        }
    }