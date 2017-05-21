<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2017  Evan Vassallo
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
    include_once(dirname(__FILE__) . "/../objects/logsheetClasses.php");

    class managePlaylistEntries {

        const PLAYLIST_SEGMENTS_TABLE_NAME = "playlist_segments";
        const PLAYLIST_TABLE_NAME = "playlist";

        const SEGMENT_COLUMN_NAME = "segment";
        const SEGMENT_PARAMETER = ":segment";

        const PLAYLIST_COLUMN_NAME = "playlist";
        const PLAYLIST_PARAMETER = ":playlist";

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

            usort($segments, array("managePlaylistEntries", "sortSegmentsByStartTime"));

            return $segments;
        }

        /**
         * @param Segment $a
         * @param Segment $b
         * @return bool
         */
        public static function sortSegmentsByStartTime($a, $b) {
            $aStartTime = $a->getStartTime();
            $bStartTime = $b->getStartTime();

            if (($aStartTime == null && $bStartTime == null) || $aStartTime == $bStartTime) {
                return ($a->getId() > $b->getId());

            } else {
                return ($aStartTime > $bStartTime);
            }

        }

        /**
         * @param PDO $dbConn
         * @return null
         */
        public static function createNewPlaylist($dbConn){
            $query = "INSERT INTO " . self::PLAYLIST_TABLE_NAME . " () VALUES ();";
            $stmt = $dbConn->prepare($query);

            $stmt->execute();
            return $dbConn->lastInsertId();
        }

        /**
         * @param PDO $dbConn
         * @param int $playlistId
         * @param int $segmentId
         * @return int
         */
        public static function addSegmentToDatabasePlaylist($dbConn, $playlistId, $segmentId) {
            $query = "INSERT INTO " . self::PLAYLIST_SEGMENTS_TABLE_NAME . " " . self::getAddSegmentColumnsString() . " VALUES " . self::getAddSegmentValuesString();
            $stmt = $dbConn->prepare($query);

            $stmt->bindParam(self::PLAYLIST_PARAMETER, $playlistId);
            $stmt->bindParam(self::SEGMENT_PARAMETER, $segmentId);

            $stmt->execute();

            return $dbConn->lastInsertId();
        }



        private static function getAddSegmentColumnsString() {
            return "(" .
                self::PLAYLIST_COLUMN_NAME . ", " .
                self::SEGMENT_COLUMN_NAME . ")";
        }

        private static function getAddSegmentValuesString() {
            return "(" .
                self::PLAYLIST_PARAMETER . ", " .
                self::SEGMENT_PARAMETER . ")";

        }
    }