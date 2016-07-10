<?php
    require_once(__DIR__ . "/../database/managePlaylistEntries.php");

    class Playlist extends LogsheetComponent {
        /**
         * @var Segment[]
         */
        private $segments;

        public function __construct($db, $componentId) {
            parent::__construct($db, $componentId);

            $this->segments = managePlaylistEntries::getPlaylistSegmentsFromDatabase($db, $componentId);
        }


        public function getSegments() {
            return $this->segments;
        }
        
    }
?>