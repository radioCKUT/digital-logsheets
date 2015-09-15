<?php

    //TODO: Error checking...

    class Episode extends LogsheetComponent {
        private $program, $programmer, $playlist;
        
        private $start_time, $end_time;
        
        public function __construct($db) {
            parent::__construct($db);
        }
        
        //TODO: need to verify that the correct fields are given
        public function setAttributes($fields) {
            //save data for episode object
            $this->setId($fields["id"]);
            $this->setProgram($fields["program"]);
            $this->setPlaylist($fields["playlist"]);
            $this->setProgrammer($fields["programmer"]);
            $this->setDateTime($fields["start_time"], $fields["end_time"]);
        }
        
        public function setProgram($program_id) {
            $this->program = new Program($this->db);
            $this->program->setId($program_id);
        }
        
        //TODO: verify a program has been created
        public function setPlaylist($playlist_id) {
            $this->playlist = new Playlist($this->db);
            $this->playlist->setId($playlist_id);
        }
        
        public function setProgrammer($programmer_id) {
            $this->programmer = new Programmer($this->db);
            $this->programmer->setId($programmer_id);
        }
        
        public function setDateTime($start_time,$end_time) {
            $this->start_time = $start_time;
            $this->end_time = $end_time;
        }
        
        public function getProgramName() {
            try {
                if($this->checkForId()) {
                    return $this->program->getName();
                }
            } catch (Exception $error) {
                echo $error;
            }
        }
    }
?>