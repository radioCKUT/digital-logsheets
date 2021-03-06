<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2017  Evan Vassallo
 * Copyright (C) 2017 Donghee Baik
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

require_once(dirname(__FILE__) . "/../database/managePlaylistEntries.php");

    class Playlist extends LogsheetComponent {
        /**
         * @var Segment[]
         */
        private $segments;

        public function __construct($db, $componentId) {
            parent::__construct($db, $componentId);

            if ($this->id != null) {
                $this->segments = managePlaylistEntries::getPlaylistSegmentsFromDatabase($db, $this->id);
            }
        }


        public function getSegments() {
            return $this->segments;
        }

        /**
         * @return String $jsonSegmentsArray
         */
        public function getSegmentsAsJSON() {

            $jsonSegmentsArray = array();

            foreach ($this->segments as $segment) {
                $jsonSegment = $segment->getObjectAsArray();
                $jsonSegmentsArray[] = $jsonSegment;
            }

            return json_encode($jsonSegmentsArray);
        }

    }
?>