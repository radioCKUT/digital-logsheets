<?php
    class Program extends LogsheetComponent{
        private $playlist;
        
        private $name, $genres, $active;
        
        public function __construct($db) {
            parent::__construct($db);
        }
        
        public function getName() {
            try {
                if($this->checkForId()) {
                    if(empty($this->name)) {
                        $sql = "SELECT name FROM program WHERE id=" . $this->id;
                        
                        //execute prepared SQL query and get the result
                        $stmt = $this->db->prepare($sql);
                        $stmt->execute();
                        $name = $stmt->fetch(PDO::FETCH_OBJ)->name;
                    } else {
                        $name = $this->name;
                    } //end if
                } //end if
                
                return $name;
            } catch (Exception $error) {
                echo $error;
            }
        }
    }
?>