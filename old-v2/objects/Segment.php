<?php
    /* to define new fields
     *  - a new variable must be created
     *  - add to the available_fields array
     *  - add a column in the database
     */
    class Segment extends LogsheetComponent {
        protected $name, $album, $author, $length, $category;
        protected $can_con, $new_release, $french_vocal_music, $request;
        
        public function __construct($db, $active_fields, $field_data) {
            parent::__construct($db, $active_fields, $field_data, "segment");
        }
    }
?>