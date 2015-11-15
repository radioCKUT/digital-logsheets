<?php
    require_once(__DIR__ . "/../database/readFromDatabase.php");

    class Playlist extends LogsheetComponent {
        private $segments;

        public function __construct($db, $component_id) {
            parent::__construct($db, $component_id);

            $this->segments = getPlaylistSegmentsFromDatabase($db, $component_id);
        }

        public function getSegments() {
            return $this->segments;
        }
        
    }
?>