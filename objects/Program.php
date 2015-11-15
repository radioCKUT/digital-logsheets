<?php
    class Program extends LogsheetComponent{

        public function __construct($db, $component_id) {
            parent::__construct($db, $component_id);

            $this->setAttributes(array("name"));
        }
        
        public function getName() {
            return $this->attributes["name"];
        }
    }
?>