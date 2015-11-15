<?php
    class LogsheetComponent {
        protected $db;
        protected $id;

        
        public function __construct($db, $component_id) {
            $this->db = $db;
            $this->setId($component_id);
        }
        
        //TODO put error checking here to make sure id is an integer
        public function setId($component_id) {
            $this->id = $component_id;
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