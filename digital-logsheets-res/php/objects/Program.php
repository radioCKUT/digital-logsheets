<?php
    include_once(__DIR__ . "/../database/manageProgramEntries.php");
    class Program extends LogsheetComponent{

        private $name;

        public function __construct($db, $component_id) {
            parent::__construct($db, $component_id);

            $this->name = manageProgramEntries::getProgramNameFromDatabase($db, $component_id);
        }
        
        public function getName() {
            return $this->name;
        }
    }
?>