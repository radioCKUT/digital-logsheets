<?php
    class Category extends LogsheetComponent{
        protected $name;
        
        public function __construct($db) {
            parent::__construct($db);
        }
        
        public function setId($category_id) {
            parent::setId($category_id);
            
            //set all the attributes for the object as soon as the id has been set
            $this->setAttributes(array("name"));
        }
        
        public function getName() {
            return $this->name;
        }
    }
?>