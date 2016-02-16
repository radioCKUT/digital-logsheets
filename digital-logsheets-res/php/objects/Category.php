<?php
    include_once(__DIR__ . "/../database/manageCategoryEntries.php");
    class Category extends LogsheetComponent{

        private $name;

        public function __construct($db, $component_id) {
            parent::__construct($db, $component_id);

            $this->name = manageCategoryEntries::getCategoryNameFromDatabase($db, $component_id);
        }
        
        public function getName() {
            return $this->name;
        }
    }
?>