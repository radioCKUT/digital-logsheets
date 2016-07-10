<?php
    class LogsheetComponent {
        protected $db;
        protected $id;
        
        public function __construct($db, $componentId) {
            $this->db = $db;
            $this->setId($componentId);
        }
        
        public function setId($componentId) {
            $this->id = $componentId;
        }
        
        public function getId() {
            return $this->id;
        }
        
        //Make sure an Id has been set for an Object
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