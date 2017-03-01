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

include_once(__DIR__ . "/../database/manageSegmentEntries.php");
    include_once(__DIR__ . "/../validator/SegmentValidator.php");

    class Segment extends LogsheetComponent implements JsonSerializable{

        private $name;
        private $author;
        private $album;

        /**
         * @var DateTime
         */
        private $startTime;
        private $duration = 0;

        private $category;

        private $stationIdGiven;
        private $isCanCon;
        private $isNewRelease;
        private $isFrenchVocalMusic;

        private $adNumber;
        private $playlistId;

        public function __construct($db, $componentId) {
            parent::__construct($db, $componentId);

            if ($this->id != null) {
                manageSegmentEntries::getSegmentAttributesFromDatabase($db, $this->id, $this);
            }
        }


        public function setName($name) {
            $this->name = $name;
        }

        public function setAlbum($album) {
            $this->album = $album;
        }

        public function setAuthor($author) {
            $this->author = $author;
        }

        public function setStartTime($startTime) {
            $this->startTime = $startTime;
        }

        public function setDuration($duration) {
            $this->duration = $duration;
        }

        public function setCategory($category) {
            $this->category = $category;
        }
        
        
        
        public function setStationIdGiven($stationIdGiven) {
            $this->stationIdGiven = $this->getBooleanToSet($stationIdGiven);
        }

        public function setIsCanCon($isCanCon) {
            $this->isCanCon = $this->getBooleanToSet($isCanCon);
        }

        public function setIsNewRelease($isNewRelease) {
            $this->isNewRelease = $this->getBooleanToSet($isNewRelease);
        }

        public function setIsFrenchVocalMusic($isFrenchVocalMusic) {
            $this->isFrenchVocalMusic = $this->getBooleanToSet($isFrenchVocalMusic);
        }

        private function getBooleanToSet($boolean) {
            if (!$boolean) {
                return false;
            } else {
                return true;
            }
        }

        public function setAdNumber($adNumber) {
            $this->adNumber = $adNumber;
        }

        public function setPlaylistId($playlistId) {
            $this->playlistId = $playlistId;
        }

        public function jsonSerialize() {
            $startDateTime = $this->getStartTime();
            $startTimeString = $startDateTime->format('H:i');

            return [
                'id' => $this->getId(),
                'startTime' => $startTimeString,
                'name' => $this->getName(),
                'album' => $this->getAlbum(),
                'author' => $this->getAuthor(),
                'duration' => $this->getDuration(),
                'category' => $this->getCategory(),
                'canCon' => $this->isCanCon(),
                'newRelease' => $this->isNewRelease(),
                'frenchVocalMusic' => $this->isFrenchVocalMusic(),
                'adNumber' => $this->getAdNumber(),
                'playlistId' => $this->getPlaylistId(),
                'stationIdGiven' => $this->wasStationIdGiven()
            ];
        }

        public function getObjectAsArray() {
            $startDateTime = $this->getStartTime();
            $startTimeString = $startDateTime->format('H:i');

            return [
                'id' => $this->getId(),
                'startTime' => $startTimeString,
                'name' => $this->getName(),
                'album' => $this->getAlbum(),
                'author' => $this->getAuthor(),
                'duration' => $this->getDuration(),
                'category' => $this->getCategory(),
                'canCon' => $this->isCanCon() ? "Yes" : "No",
                'newRelease' => $this->isNewRelease() ? "Yes" : "No",
                'frenchVocalMusic' => $this->isFrenchVocalMusic() ? "Yes" : "No",
                'adNumber' => $this->getAdNumber(),
                'playlistId' => $this->getPlaylistId(),
                'stationIdGiven' => $this->wasStationIdGiven() ? "Yes" : "No"
            ];
        }

        
        public function getName() {
            return $this->name;
        }
        
        public function getAlbum() {
            return $this->album;
        }
        
        public function getAuthor() {
            return $this->author;
        }

        public function getStartTime() {
            return $this->startTime;
        }

        public function getDuration() {
            return $this->duration;
        }

        public function getEndTime() {

        }

        /**
         * @return Category
         */
        public function getCategory() {
            return $this->category;
        }

        public function wasStationIdGiven() {
            return $this->stationIdGiven;
        }

        public function isCanCon() {
            return $this->isCanCon;
        }

        public function isNewRelease() {
            return $this->isNewRelease;
        }

        public function isFrenchVocalMusic() {
            return $this->isFrenchVocalMusic;
        }

        public function getAdNumber() {
            return $this->adNumber;
        }

        public function getPlaylistId() {
            return $this->playlistId;
        }
        
    }
