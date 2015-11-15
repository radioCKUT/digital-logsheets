<?php

    //TODO: Error checking...
    require_once("../database/readFromDatabase.php");
    class Episode extends LogsheetComponent {

        private $program;
        private $playlist;
        private $programmer;

        private $episode_start_time;
        private $episode_end_time;

        public function __construct($db, $component_id) {
            parent::__construct($db, $component_id);

            $this->program = getProgramFromDatabase($db, $component_id);
            $this->playlist = getPlaylistFromDatabase($db, $component_id);
            $this->programmer = getProgrammerFromDatabase($db, $component_id);

            $this->episode_start_time = getEpisodeStartTimeFromDatabase($db, $component_id);
            $this->episode_end_time = getEpisodeEndTimeFromDatabase($db, $component_id);
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
        public function getPlaylist() {
            return $this->playlist->getSegments();
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