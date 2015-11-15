<?php

    //TODO: Error checking...

    class Episode extends LogsheetComponent {

        public function __construct($db, $component_id) {
            parent::__construct($db, $component_id);

            $this->setAttributes(array("program", "playlist", "programmer", "start_time", "end_time"));
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