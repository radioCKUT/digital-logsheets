<?php
    class Segment extends LogsheetComponent{
        protected $name, $album, $author;
        
        public function __construct($db) {
            parent::__construct($db);
        }
        
        public function setId($segment_id) {
            parent::setId($segment_id);
            
            //set all the attributes for the object as soon as the id has been set
            $this->setAttributes(array("name","album","author"));
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