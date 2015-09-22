<?php
    class Playlist extends LogsheetComponent {
        private $segments = array();
        
        public function __construct($db) {
            try {
                //Create a new record for the playlist
                $db->exec("INSERT INTO playlist VALUES(NULL)");
                
                //retrieve auto incremented id number
                $this->id = $db->lastInsertId();
                
            } catch(PDOException $error) {
                echo "ERROR: New playlist could not be created. " . $error->getMessage();
            } //end try/catch statment
        }
        
        public function addSegment($db, $segment) {
            $segment_id = $segment->getId();
            $playlist_id = $this->getId();
            
            //check to make sure segment has an ID associated with it
            if(!is_null($segment_id)) {
                $columns = array("playlist", "segment");
                $data = array($playlist_id, $segment_id);
                
                //try to insert data, if successful, add to the Playlist's segments array
                try {
                    //add segment to playlist_segments table
                    $this->insertData($db, "playlist_segments", $columns, $data);
                    
                    //add segment to object's array of segments
                    array_push($this->segments, $segment_id);
                } catch(PDOException $error) {
                    echo "ERROR: Couldn't add segment to playlist.";
                }
            }
        }
        
        public function getSegments() {
            return $this->segments;
        }
    }
?>