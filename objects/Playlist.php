<?php
    class Playlist extends LogsheetComponent {
        private $segments;
        
        public function __construct($db) {
            parent::__construct($db);
        }
        
        //Function will query the database for all the segment ids that are
        //  associated with the current playlist. For each segment id, a new
        //  Segment object is created, and its id is set (for the object)
        public function getSegments() {
            try {
                if($this->checkForId()) {
                    //find all the segments for a given playlist
                    $sql = "SELECT segment FROM playlist_segments 
                                WHERE playlist=" . $this->id;
                        
                    //get a list of all the segment ids for the current Playlist
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute();
                    $segment_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    //make new Segment objects for each id and store them
                    $segments = array();
                    
                    //make Segments for each segment id and store in an array (segments)
                    //  assigned to this Playlist object.
                    if(count($segment_ids)) {
                        foreach($segment_ids as $segment_id) {
                            
                            //create a new Segment object
                            $segments[$segment_id["segment"]] = new Segment($this->db);
                            
                            //assign the id number for each segment
                            //for Segment objects only, this also sets the Segment's
                            //  attributes like name, album and author
                            $segments[$segment_id["segment"]]->setId($segment_id["segment"]);
                            
                        } //end foreach
                        
                    } //end if
                    
                    //return an array of all the resulting Segment object
                    $this->segments = $segments;
                    return $this->segments;
                    
                } //end if
                
            } catch (Exception $error) {
                echo $error;
            } //end try/catch
        } //end getSegments()
        
    }
?>