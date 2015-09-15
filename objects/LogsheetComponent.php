<?php
    class LogsheetComponent {
        protected $db;
        protected $id;
        
        public function __construct($db) {
            $this->db = $db;
        }
        
        public function setId($component_id) {
            $this->id = $component_id;
        }
        
        public function getId() {
            return $this->id;
        }
        
        protected function checkForId() {
            if(!empty($this->id)) {
                $result = TRUE;
            } else {
                throw new Exception("Error: No ID assigned to object");
            }
            
            return $result;
        }
    }
?>