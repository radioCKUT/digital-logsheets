<?php
    class Archive extends LogsheetComponent {
        
        //an array of Episode objects
        private $episodes;
        
        public function __construct($db) {
            parent::__construct($db);
            
            $this->episodes = array();
            $this->createArchive();
        }
        
        //return an array holding each row from the episode table in the database
        public function getArchive() {
            return $this->episodes;
        }
        
        //create an array to hold Episode objects
        //used to retrieve a history of all episodes for display
        private function createArchive() {
            //prepare and execute the SQL statement
            $sql = "SELECT id FROM episode";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            //get all the rows (episodes) in a 2D array and store
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            //iterate through each row in the result and store in an array
            if(count($result)) {
                foreach($result as $episode_row) {
                    //create a new episode object
                    $episode = new Episode($this->db);

                    $episode->setId($episode_row["id"]);
                    
                    //each episode is stored in $episodes and reference by artist
                    $this->episodes[$episode->getId()] = $episode;
                }
            }
        }
        
    }
?>