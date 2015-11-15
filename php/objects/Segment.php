<?php
    include_once("../database/readFromDatabase.php");
    class Segment extends LogsheetComponent{


        private $name;
        private $author;
        private $album;

        public function __construct($db, $component_id) {
            parent::__construct($db, $component_id);

            /*$this->setAttributes(array("category","name","album","author","start_time","ad_number",
                "station_id", "can_con", "new_release", "french_vocal_music"));*/

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