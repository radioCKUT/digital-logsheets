<?php
    class LogsheetComponent {
        protected $id;
        protected $active_fields, $available_fields;
        
        public function __construct($db, $active_fields, $field_data, $table_name) {
            try {
                //verify that the fields provided by the user are available
                if(!$this->verifyFields($active_fields, $field_data)) {
                    //there are a different number of data elements than fields
                    throw new Exception("Data does not correspond to the active fields.");
                }
                
                //set the active fields to those provided by the user
                if(!$this->setActiveFields($active_fields)) { 
                    //field is invalid. reject creation of segment
                    throw new Exception("Fields provided are not valid.");
                }
                
                //assign the data provided by the user to the Object's variables
                $this->assignData($field_data);

            } catch(Exception $error) {
                //user tried to activate fields that weren't valid, or data and fields do not correspond
                echo "ERROR: Could not create segment. " . $error->getMessage();
            }
            
            //save the segment in the database and set the ID
            $this->id = $this->insertData(
                $db,
                $table_name,
                $this->active_fields,
                $field_data
            );
        }
        
        private function assignData($data) {
            //assign data associate with each field to the Object's variables
            foreach($this->active_fields as $i=>$field) {
                //assign the data to the associated object variables
                $this->{$field} = $data[$i];
            }
        }
    
        /*
         * Input:           PDO object, table name (string), fields (array), data (array)
         * Output:          ID number created by the database, or NULL if fails
         * Side-Effects:    Data is added to the associated table in database
         * Assumptions:     Data array should correspond to the fields provided.
         */
    	protected function insertData($db, $table_name, $fields, $data) {
    	    //initialize id value to be returned
    	    $id = NULL;
    	    
            //insert segment into the database and get its auto incremented ID
            //generate dynamic SQL string for inserting segments into database
            $insertSql = "INSERT INTO " . $table_name . " (" . $this->formatFields($fields) . 
                                ") VALUES (" . $this->formatFields($fields,":") . ")";
            
            //execute the mysql command with the bound variables
            $insert = $db->prepare($insertSql);
            $insert->execute($data);
            
            //return id if the table auto_increments the id column
            //assumes id is the only column auto_incremented in a table
            if($this->checkAutoIncrement($db, $table_name)) {
                $id = $db->lastInsertId();
            }
            
            return $id;
    	}
    	
        //if an argument is given, prepend fields with the string provided
        protected function formatFields($fields,$character = "") {
            $fieldsString = "";
            
            //prepend first field with the character provided
            if($character !== "") {   
                $fieldsString = $character;
            }
            
            foreach($fields as $i=>$field) {
                //dont prepend with a comma, space or $character if first in the list
                if($i<1) {
                    $fieldsString = $fieldsString . $field;
                    continue;
                } else {   
                    //prepend the field with comma and space characters
                    $fieldsString = $fieldsString . ", ";
                    
                    //prepend field with the optional character, if provided
                    if($character !== "") {
                         $fieldsString = $fieldsString . $character;
                    }
    
                    //append the field
                    $fieldsString = $fieldsString . $field;
                }
            }//end foreach
            
            return $fieldsString;
            
        } //end formatFields
        
        protected function setActiveFields($fields) {
            //verify that each field provided is available in $active_fields
            foreach($fields as $field) {
                //check that the field can be found in active_fields
                if(!in_array($field,$this->available_fields)) {
                    return FALSE;
                }
            }
            
            //set the provided fields as the active fields
            $this->active_fields = $fields;
            
            return TRUE;
        }
        
        protected function verifyFields($fields, $data) {
            //check that provided data has same number of elements as the active fields
            if(count($fields) == count($data)) {
                return TRUE;
            }
            
            return FALSE;
        }
        
        protected function checkAutoIncrement($db, $table_name) {
            //sql to query database if $table_name contains an auto_incremented column
            $sql = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS 
                    WHERE table_name = '" . $table_name ."' 
                    AND EXTRA LIKE '%auto_increment%'";
            
            //execute prepared SQL query and get the result
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            //return true if table contains an auto_incremented column
            if (!empty($result)) {
                return TRUE;
            }
            
            //return false if table does not contain an auto_incremented column
            return FALSE;
        }
        
        public function getId() {
            return $this->id;
        }  
    }
?>