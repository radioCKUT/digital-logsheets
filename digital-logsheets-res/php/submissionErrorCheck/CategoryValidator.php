<?php

    require('./ValidatorUtility.php');

    class CategoryValidator {

        private $category;

        public function __construct($category) {
            $this->category = $category;
        }

        public function isCategoryValid() {
            if (ValidatorUtility::isInteger($this->category)) {
                switch ($this->category) {
                    case 1:
                    case 2:
                    case 3:
                    case 4:
                    case 5:
                        return true;
                    default:
                        return false;
                }
            }

            return false;
        }
    }