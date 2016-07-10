<?php

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
        private $programmer;

        private $episodeStartTime;
        private $episodeEndTime;

        private $isPrerecord;
        private $prerecordDate;

        private $comment;
        
        public function __construct($db, $componentId) {
            parent::__construct($db, $componentId);

            if ($componentId != null) {
                manageEpisodeEntries::getEpisodeAttributesFromDatabase($db, $componentId, $this);
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
         * @param mixed $comment
         */
        public function setComment($comment)
        {
            $this->comment = $comment;
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

        /**
         * @return Playlist
         */
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
        public function getComment()
        {
            return $this->comment;
        }
    }