<?php
    class Playlist extends LogsheetComponent {
        private $segments;
        
        public function __construct($db) {
            parent::__construct($db);
        }
        
        public function getSegments() {
            try {
                if($this->checkForId()) {
                    //get an array of segment ids associated with the playlist id
                    $sql = "SELECT segment FROM playlist_segments 
                                WHERE playlist=" . $this->id;
                        
                    //execute prepared SQL query and get the result
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute();
                    $segment_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    $segments = array();
                    
                    //make segment objects for each segment id
                    if(count($segment_ids)) {
                        foreach($segment_ids as $segment_id) {
                            $segments[$segment_id["segment"]] = new Segment($this->db);
                            $segments[$segment_id["segment"]]->setId($segment_id["segment"]);
                        }
                    }
                    
                    //return an array of segment object
                    $this->segments = $segments;
                    return $this->segments;
                }
            } catch (Exception $error) {
                echo $error;
            }
        }
        
    }
?>