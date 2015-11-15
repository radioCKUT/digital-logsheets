<?php
    class Playlist extends LogsheetComponent {
        private $segments;
        
        //Function will query the database for all the segment ids that are
        //  associated with the current playlist. For each segment id, a new
        //  Segment object is created, and its id is set (for the object)
        public function getSegments() {
            try {
                if($this->checkForId()) {
                    //find all the segments for a given playlist
                    $sql = "SELECT segment FROM playlist_segments 
                                WHERE playlist=:id";
                        
                    //get a list of all the segment ids for the current Playlist
                    $stmt = $this->db->prepare($sql);
                    $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
                    $stmt->execute();
                    $segment_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    //make new Segment objects for each id and store them
                    $segments = array();
                    
                    //make Segments for each segment id and store in an array (segments)
                    //  assigned to this Playlist object.
                    if(count($segment_ids)) {
                        foreach($segment_ids as $segment_id) {
                            //create a new Segment object
                            $segments[$segment_id["segment"]] = new Segment($this->db, $segment_id["segment"]);
                        }
                    }
                    
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