<?php
    require_once(__DIR__ . "/../database/manageEpisodeEntries.php");
    class Archive {

        private $db;
        /**
         * @var Episode[]
         */
        private $episodes = array();

        public function __construct($db) {
            $this->db = $db;
            $this->episodes = manageEpisodeEntries::getAllEpisodesFromDatabase($db);
        }
        
        //return an array holding each row from the episode table in the database
        public function getArchive() {
            return $this->episodes;
        }
        
    }
?>