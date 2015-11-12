<?php
    class Segment extends LogsheetComponent{
        public function __construct($db) {
            parent::__construct($db);
        }
        
        public function setId($segment_id) {
            parent::setId($segment_id);
            
            //set all the attributes for the object as soon as the id has been set
            $this->setAttributes(array("category","name","album","author","start_time","ad_number",
                "station_id", "can_con", "new_release", "french_vocal_music"));
        }

        public function getCategory() {
            return $this->attributes["category"];
        }

        public function getAdNumber() {
            if ($this->attributes["ad_number"] == null) {
                return -1;
            } else {
                $this->attributes["ad_number"];
            };
        }

        public function isStationId() {
            return !($this->attributes["station_id"] == 0);
        }

        public function isCanCon() {
            return !($this->attributes["can_con"] == 0);
        }

        public function isFrenchVocal() {
            return !($this->attributes["french_vocal_music"] == 0);
        }

        public function isNewRelease() {
            return !($this->attributes["new_release"] == 0);
        }

        public function getStartTime() {
            return $this->attributes["start_time"];
        }
        
        public function getName() {
            return $this->attributes["name"];
        }
        
        public function getAlbum() {
            return $this->attributes["album"];
        }
        
        public function getAuthor() {
            return $this->attributes["author"];
        }
        
    }
?>