<?php
    class LogsheetComponent {
        protected $db;
        protected $id;
        
        //TODO: change to protected after testing
        public $attributes;
        
        public function __construct($db, $component_id) {
            $this->db = $db;
            $this->setId($component_id);
            $this->attributes = array();
        }
        
        //TODO put error checking here to make sure id is an integer
        public function setId($component_id) {
            $this->id = $component_id;
        }
        
        //this method requires that all Objects that correspond to a table
        //  must have the same name! table is all in lowercase
        protected function setAttributes($attributesToAssign) {
            //get the table name from the Class name
            $table_name = strtolower(get_class($this));
            
            //make the attributes a comma-separated list
            $attributes_list = implode (",", $attributesToAssign);
            
            try {
                if($this->checkForId()) {
                    //set all the attributes for a Program at once
                    $sql = "SELECT " . $attributes_list . " FROM " . $table_name .
                            " WHERE id=:id";
                    
                    //fetch the tuple and assign each attribute to the object
                    $stmt = $this->db->prepare($sql);
                    $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
                    $stmt->execute();
                    $attrs_from_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if(count($attrs_from_db)) {
                        foreach($attrs_from_db as $attr_from_db) {
                            $this->fillAttributeArrayWithDatabaseValues($attributesToAssign, $attr_from_db);
                        }
                    }
                }
            } catch (Exception $error) {
                echo $error;
            }
        }

        public function fillAttributeArrayWithDatabaseValues($attributesToAssign, $attr_from_db) {

            foreach($attributesToAssign as $attribute) {
                switch ($attribute) {
                    case "program":
                        $this->attributes[$attribute] = new Program($this->db, $attr_from_db[$attribute]);
                        break;
                    case "playlist":
                        $this->attributes[$attribute] = new Playlist($this->db, $attr_from_db[$attribute]);
                        break;
                    case "programmer":
                        $this->attributes[$attribute] = new Programmer($this->db, $attr_from_db[$attribute]);
                        break;
                    default:
                        $this->attributes[$attribute] = $attr_from_db[$attribute];
                        break;
                }
            }
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