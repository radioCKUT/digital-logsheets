<?php
    include_once(__DIR__ . "/../database/manageSegmentEntries.php");

    class Segment extends LogsheetComponent implements JsonSerializable{

        private $name;
        private $author;
        private $album;

        private $start_time;
        private $duration;

        public function __construct($db, $component_id) {
            parent::__construct($db, $component_id);

            manageSegmentEntries::getSegmentAttributesFromDatabase($db, $component_id, $this);
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

        public function setStartTime($start_time) {
            $this->start_time = $start_time;
        }

        public function setDuration($duration) {
            $this->duration = $duration;
        }

        public function jsonSerialize() {
            return [
                'start_time' => $this->getStartTime(),
                'name' => $this->getName(),
                'album' => $this->getAlbum(),
                'author' => $this->getAuthor()
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
            return $this->start_time;
        }

        public function getDuration() {
            return $this->duration;
        }
        
    }
?>