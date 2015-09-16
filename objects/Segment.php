<?php
    class Segment extends LogsheetComponent{
        private $name, $album, $author;
        
        public function __construct($db) {
            parent::__construct($db);
        }
        
        public function setId($segment_id) {
            parent::setId($segment_id);
            
            //set all the attributes for the object as soon as the id has been set
            $this->assignAttributes();
        }
        
        public function getName() {
            return $this->name;
        }
        
        public function getAlbum() {
            return $this->album;
        }
        
        public function getAuthor() {
            return $this->author;
        }
        
        public function assignAttributes() {
            try {
                if($this->checkForId()) {
                    $sql = "SELECT name, album, author FROM segment
                            WHERE id=" . $this->id;
                        
                    //execute prepared SQL query and get the result
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute();
                    $segment_attributes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    //
                    if(count($segment_attributes)) {
                        foreach($segment_attributes as $segment_attribute) {
                            $this->name = $segment_attribute["name"];
                            $this->album = $segment_attribute["album"];
                            $this->author = $segment_attribute["author"];
                        }
                    }
                }
            } catch (Exception $error) {
                echo $error;
            }
        }
        
    }
?>