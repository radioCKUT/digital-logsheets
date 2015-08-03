<?php
    class Episode extends LogsheetComponent {
        public function __construct($db, $active_fields, $field_data) {
            $table_name = "episode";
            
            $this->available_fields = array(
                "playlist",
                "program",
                "programmer",
                "start_time",
                "end_time"
            );
            
            parent::__construct($db, $active_fields, $field_data, $table_name);
        }
    }
?>