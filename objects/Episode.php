<?php

    //TODO: Error checking...

    class Episode extends LogsheetComponent {

        public function __construct($db) {
            parent::__construct($db);
        }

        public function setId($component_id) {
            parent::setId($component_id);

            $this->setAttributes(array("program", "playlist", "programmer", "start_time", "end_time"));

            $this->setProgram($this->attributes["program"]);
            $this->setPlaylist($this->attributes["playlist"]);
            $this->setProgrammer($this->attributes["programmer"]);
            $this->setDateTime($this->attributes["start_time"], $this->attributes["end_time"]);
        }
        
        public function setProgram($program_id) {
            $this->attributes["program"] = new Program($this->db);
            $this->attributes["program"]->setId($program_id);
        }
        
        //TODO: verify a program has been created
        public function setPlaylist($playlist_id) {
            $this->attributes["playlist"] = new Playlist($this->db);
            $this->attributes["playlist"]->setId($playlist_id);
        }
        
        public function setProgrammer($programmer_id) {
            $this->attributes["programmer"] = new Programmer($this->db);
            $this->attributes["programmer"]->setId($programmer_id);
        }
        
        public function setDateTime($start_time,$end_time) {
            $this->attributes["start_time"] = $start_time;
            $this->attributes["end_time"] = $end_time;
        }
        
        public function getProgramName() {
            try {
                if($this->checkForId()) {
                    return $this->attributes["program"]->getName();
                }
            } catch (Exception $error) {
                echo $error;
            }
        }
        
        //returns an array of segment objects
        public function getPlaylist() {
            return $this->attributes["playlist"]->getSegments();
        }
        
        public function getStartDate() {
            return $this->getStartTime();
        }
        
        public function getStartTime() {
            try {
                if($this->checkForId()) {
                    return $this->attributes["start_time"];
                }
            } catch (Exception $error) {
                echo $error;
            }
        }
        
        public function getEndTime() {
            try {
                if($this->checkForId()) {
                    return $this->attributes["end_time"];
                }
            } catch (Exception $error) {
                echo $error;
            }
        }
    }
?>