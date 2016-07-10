<?php
    include_once(__DIR__ . "/../database/manageProgramEntries.php");
    class Program extends LogsheetComponent{

        private $name;

        public function __construct($db, $componentId) {
            parent::__construct($db, $componentId);

            $this->name = manageProgramEntries::getProgramNameFromDatabase($db, $componentId);
        }
        
        public function getName() {
            return $this->name;
        }
    }
?>