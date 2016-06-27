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

        private $episode_start_time;
        private $episode_end_time;

        private $is_prerecord;
        private $prerecord_date;

        private $comment;



        public function __construct($db, $component_id) {
            parent::__construct($db, $component_id);

            if ($component_id != null) {
                manageEpisodeEntries::getEpisodeAttributesFromDatabase($db, $component_id, $this);
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

        public function setStartTime($start_time) {
            $this->episode_start_time = $start_time;
        }

        public function setEndTime($end_time) {
            $this->episode_end_time = $end_time;
        }

        public function setIsPrerecord($is_prerecord) {

            if (!$is_prerecord) {
                $this->prerecord_date = null;
                $this->is_prerecord = false;
            } else {
                $this->is_prerecord = true;
            }
        }

        public function setPrerecordDate($prerecord_date) {
            $this->prerecord_date = $prerecord_date;
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
                'episode_id' => $this->getId(),
                'program' => $this->getProgram() != null ? $this->getProgram()->getName() : "",
                'playlist' => $this->getPlaylistId(),
                'start_date' => $startDateString,
                'start_time' => $startTimeString,
                'end_time' => $endTimeString,
                'start_datetime' => $startDatetimeString,
                'end_datetime' => $endDatetimeString,
                'prerecorded' => $this->isPrerecord() ? "Yes" : "No",
                'prerecord_date' => $prerecordDateString,
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
            return $this->episode_start_time;
        }
        
        public function getEndTime() {
            return $this->episode_end_time;
        }

        public function isPrerecord() {
            return $this->is_prerecord;
        }

        public function getPrerecordDate() {
            return $this->prerecord_date;
        }

        /**
         * @return mixed
         */
        public function getComment()
        {
            return $this->comment;
        }
    }