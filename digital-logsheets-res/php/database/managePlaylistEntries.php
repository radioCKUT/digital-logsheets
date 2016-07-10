<?php

    include_once("readFromDatabase.php");
    include_once("writeToDatabase.php");
    include_once(__DIR__ . "/../objects/logsheetClasses.php");

    class managePlaylistEntries {

        const PLAYLIST_SEGMENTS_TABLE_NAME = "playlist_segments";
        const PLAYLIST_TABLE_NAME = "playlist";

        const SEGMENT_COLUMN_NAME = "segment";
        const PLAYLIST_COLUMN_NAME = "playlist";

        public static function getPlaylistSegmentsFromDatabase($dbConn, $playlistId) {
            $segmentIds = readFromDatabase::readFilteredColumnFromTable($dbConn, array(self::SEGMENT_COLUMN_NAME),
                self::PLAYLIST_SEGMENTS_TABLE_NAME, array(self::PLAYLIST_COLUMN_NAME), array($playlistId));

            $segments = array();
            $count = 0;

            //make Segments for each segment id and store in an array (segments)
            if (count($segmentIds)) {
                foreach ($segmentIds as $segmentId) {
                    $segments[$count++] =
                        new Segment($dbConn, $segmentId[self::SEGMENT_COLUMN_NAME]);
                }
            }

            usort($segments, function ($a, $b) {
                return ($a->getStartTime() > $b->getStartTime());
            });

            return $segments;
        }

        public static function createNewPlaylist($dbConn){
            return writeToDatabase::writeEntryToDatabase($dbConn, self::PLAYLIST_TABLE_NAME, array(), array());
        }

        public static function addSegmentToDatabasePlaylist($dbConn, $playlistId, $segmentId) {
            $columnNames = array(self::PLAYLIST_COLUMN_NAME, self::SEGMENT_COLUMN_NAME);
            $values = array($playlistId, $segmentId);

            return writeToDatabase::writeEntryToDatabase($dbConn, self::PLAYLIST_SEGMENTS_TABLE_NAME, $columnNames, $values);
        }
    }