<?php
    include_once(__DIR__ . "/../database/manageCategoryEntries.php");
    include_once(__DIR__ . "/../validator/CategoryValidator.php");
    class Category extends LogsheetComponent {

        private $name;

        public function __construct($db, $componentId) {
            parent::__construct($db, $componentId);

            $this->name = manageCategoryEntries::getCategoryNameFromDatabase($db, $componentId);
        }
        
        public function getName() {
            return $this->name;
        }

        public function isValid() {
            $categoryValidator = new CategoryValidator($this);
            return $categoryValidator->isCategoryValid();
        }
    }
?>