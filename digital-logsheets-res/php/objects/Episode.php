<?php

    //TODO: Error checking...
    require_once(__DIR__ . "/../database/manageEpisodeEntries.php");
    require_once(__DIR__ . "/LogsheetComponent.php");

    class Episode extends LogsheetComponent {

        private $program;
        private $playlist;
        private $programmer;

        private $episode_start_time;
        private $episode_end_time;

        public function __construct($db, $component_id) {
            parent::__construct($db, $component_id);

            manageEpisodeEntries::getEpisodeAttributesFromDatabase($db, $component_id, $this);
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

        public function getProgramName() {
            try {
                if($this->checkForId()) {
                    return $this->program->getName();
                }
            } catch (Exception $error) {
                echo $error;
            }
        }
        
        //returns an array of segment objects
        public function getSegments() {
            return $this->playlist->getSegments();
        }

        public function getPlaylistId() {
            error_log("getting playlist id:" . $this->playlist->getId());
            return $this->playlist->getId();
        }
        
        public function getStartDate() {
            return $this->getStartTime();
        }
        
        public function getStartTime() {
            try {
                if($this->checkForId()) {
                    return $this->episode_start_time;
                }
            } catch (Exception $error) {
                echo $error;
            }
        }
        
        public function getEndTime() {
            try {
                if($this->checkForId()) {
                    return $this->episode_end_time;
                }
            } catch (Exception $error) {
                echo $error;
            }
        }
    }
?>