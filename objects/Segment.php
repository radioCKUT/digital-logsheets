<?php
    class Segment extends LogsheetComponent{
        public function __construct($db) {
            parent::__construct($db);
        }
        
        public function setId($segment_id) {
            parent::setId($segment_id);
            
            //set all the attributes for the object as soon as the id has been set
            $this->setAttributes(array("name","album","author"));
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