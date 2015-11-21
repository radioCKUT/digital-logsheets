<?php
    include_once(__DIR__ . "/../database/manageSegmentEntries.php");
    class Segment extends LogsheetComponent{


        private $name;
        private $author;
        private $album;

        public function __construct($db, $component_id) {
            parent::__construct($db, $component_id);

            $this->name = manageSegmentEntries::getSegmentNameFromDatabase($db, $component_id);
            $this->author = manageSegmentEntries::getSegmentAuthorFromDatabase($db, $component_id);
            $this->album = manageSegmentEntries::getSegmentAlbumFromDatabase($db, $component_id);
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

        
        public function getName() {
            return $this->name;
        }
        
        public function getAlbum() {
            return $this->album;
        }
        
        public function getAuthor() {
            return $this->author;
        }
        
    }
?>