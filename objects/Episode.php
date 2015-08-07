<?php
    class Episode extends LogsheetComponent {
        protected $playlist, $program, $programmer, $start_time, $end_time;
        
        public static function create($db, $active_fields, $field_data) {
            return new LogsheetComponent($db, $active_fields, $field_data, "episode");
        }
        
        public static function retrieve($db) {
            
        }
    }
?>