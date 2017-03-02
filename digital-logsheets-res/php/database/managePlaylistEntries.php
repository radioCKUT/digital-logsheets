<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2017  Evan Vassallo
 * Copyright (C) 2016-2017  James Wang
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
    include_once(dirname(__FILE__) . "/../objects/logsheetClasses.php");

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

            usort($segments, "sortSegmentsByStartTime");

            return $segments;
        }

        public static function sortSegmentsByStartTime($a, $b) {
            return ($a->getStartTime() > $b->getStartTime());
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