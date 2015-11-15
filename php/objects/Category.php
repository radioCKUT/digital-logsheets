<?php
    include_once(__DIR__ . "/../database/readFromDatabase.php");
    class Category extends LogsheetComponent{

        private $name;

        public function __construct($db, $component_id) {
            parent::__construct($db, $component_id);

            $this->name = getCategoryNameFromDatabase($db, $component_id);
        }
        
        public function getName() {
            return $this->name;
        }
    }
?>