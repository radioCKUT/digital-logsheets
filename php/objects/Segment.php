<?php
    include_once(__DIR__ . "/../database/readFromDatabase.php");
    class Segment extends LogsheetComponent{


        private $name;
        private $author;
        private $album;

        public function __construct($db, $component_id) {
            parent::__construct($db, $component_id);

            $this->name = getSegmentNameFromDatabase($db, $component_id);
            $this->author = getSegmentAuthorFromDatabase($db, $component_id);
            $this->album = getSegmentAlbumFromDatabase($db, $component_id);
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