<?php

    include_once("readFromDatabase.php");
    class managePlaylistEntries {

        private static $tableName = "playlist_segments";

        private static $segmentColumnName = "segment";
        private static $playlistColumnName = "playlist";

        public static function getPlaylistSegmentsFromDatabase($db_connection, $playlist_id)
        {
            $segment_ids = readFromDatabase::readFilteredColumnFromTable($db_connection, array(self::$segmentColumnName),
                self::$tableName, array(self::$playlistColumnName), array($playlist_id));

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
    }