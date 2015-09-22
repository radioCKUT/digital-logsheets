<?php
    class Programmer extends LogsheetComponent {
        
        private $first_name, $last_name;
        
        //a list of fields used to insert date into the associated table in database
        protected $active_fields = array(
                    "first_name",
                    "last_name"
                );
        
        public function __construct($db, $first_name, $last_name) {
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            
            //insert data into database and set the ID
            $this->id = $this->insertData(
                $db,
                "programmer",
                $this->active_fields,
                array($first_name, $last_name)
            );
        }
        
        public function getFirstName() {
            return $this->first_name;
        }
        
        public function getLastName() {
            return $this->last_name;
        }
        
        public function getFullName() {
            return $this->first_name . " " . $this->last_name;
        }
    }
?>