<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2016  Evan Vassallo
 * Copyright (C) 2016  James Wang
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

    //TODO: Error checking...
    require_once(__DIR__ . "/../database/manageEpisodeEntries.php");
    require_once(__DIR__ . "/LogsheetComponent.php");

    class Episode extends LogsheetComponent {

        /**
         * @var Program
         */
        private $program;
        /**
         * @var Playlist
         */
        private $playlist;

        /**
         * @var String
         */
        private $programmer;

        /**
         * @var DateTime
         */
        private $episodeStartTime;
        /**
         * @var DateTime
         */
        private $episodeEndTime;

        private $isPrerecord;
        private $prerecordDate;

        private $notes;
        
        public function __construct($db, $componentId) {
            parent::__construct($db, $componentId);

            if ($this->id != null) {
                manageEpisodeEntries::getEpisodeAttributesFromDatabase($db, $this->id, $this);
            }
        }

        public function setProgram($program) {
            $this->program = $program;
        }

        public function setPlaylist($playlist) {
            $this->playlist = $playlist;
        }

        public function setProgrammer($programmer) {
            $this->programmer = $programmer;
        }

        public function setStartTime($startTime) {
            $this->episodeStartTime = $startTime;
        }

        public function setEndTime($endTime) {
            $this->episodeEndTime = $endTime;
        }

        public function setIsPrerecord($isPrerecord) {

            if (!$isPrerecord) {
                $this->prerecordDate = null;
                $this->isPrerecord = false;
            } else {
                $this->isPrerecord = true;
            }
        }

        public function setPrerecordDate($prerecordDate) {
            $this->prerecordDate = $prerecordDate;
        }

        /**
         * @param mixed $notes
         */
        public function setNotes($notes)
        {
            $this->notes = $notes;
        }

        public function jsonSerialize() {
            $startDate = $this->getStartTime();
            $startDateString = $this->prepareDateForSerialize($startDate);
            $startTimeString = $this->prepareTimeForSerialize($startDate);
            $startDatetimeString = $this->prepareDateTimeForSerialize($startDate);

            $endDate = $this->getEndTime();
            $endTimeString = $this->prepareTimeForSerialize($endDate);
            $endDatetimeString = $this->prepareDateTimeForSerialize($endDate);

            $prerecordDate = $this->getPrerecordDate();
            $prerecordDateString = $this->prepareDateForSerialize($prerecordDate);

            return [
                'id' => $this->getId(),
                'program' => $this->getProgram() != null ? $this->getProgram()->getName() : "",
                'playlist' => $this->getPlaylistId(),
                'startDate' => $startDateString,
                'startTime' => $startTimeString,
                'endTime' => $endTimeString,
                'startDatetime' => $startDatetimeString,
                'endDatetime' => $endDatetimeString,
                'prerecorded' => $this->isPrerecord() ? "Yes" : "No",
                'prerecordDate' => $prerecordDateString,
                'segments' => $this->getSegments()
            ];
        }

        /**
         * @param DateTime $date
         * @return mixed
         */
        private function prepareDateForSerialize($date) {
            if ($date != null) {
                return $date->format('D, M j, Y');
            } else {
                return "";
            }
        }

        private function prepareTimeForSerialize($date) {
            if ($date != null) {
                return $date->format('H:i');
            } else {
                return "";
            }
        }

        private function prepareDateTimeForSerialize($date) {
            if ($date != null) {
                return $date->format('D, M j, Y H:i');
            } else {
                return "";
            }
        }

        public function getObjectAsArray() {
            return $this->jsonSerialize();
        }

        /**
         * @return Programmer
         */
        public function getProgrammer() {
            return $this->programmer;
        }

        /**
         * @return Program
         */
        public function getProgram() {
            return $this->program;
        }

        /**
         * @return string
         */
        public function getProgramName() {

            return $this->program != null ? $this->program->getName() : "";
        }
        
        //returns an array of segment objects
        /**
         * @return Segment[]
         */
        public function getSegments() {
            return $this->playlist != null ? $this->playlist->getSegments() : null;
        }

        public function getPlaylistId() {
            return $this->playlist != null ? $this->playlist->getId() : null;
        }


        public function getPlaylist() {
            return $this->playlist;
        }
        
        public function getStartTime() {
            return $this->episodeStartTime;
        }

        public function getEndTime() {
            return $this->episodeEndTime;
        }

        public function isPrerecord() {
            return $this->isPrerecord;
        }

        public function getPrerecordDate() {
            return $this->prerecordDate;
        }

        /**
         * @return mixed
         */
        public function getNotes()
        {
            return $this->notes;
        }
    }