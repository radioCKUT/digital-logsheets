<?php
    include_once(__DIR__ . "/../database/manageSegmentEntries.php");

    class Segment extends LogsheetComponent implements JsonSerializable{

        private $name;
        private $author;
        private $album;

        private $start_time;
        private $duration = 0;

        private $category;

        private $is_can_con;
        private $is_new_release;
        private $is_french_vocal_music;

        private $ad_number;
        private $playlist_id;

        public function __construct($db, $component_id) {
            parent::__construct($db, $component_id);

            if ($component_id != null) {
                manageSegmentEntries::getSegmentAttributesFromDatabase($db, $component_id, $this);
            }
        }


        public function setName($name) {
            $this->name = $name;
        }

        public function setAlbum($album) {
            $this->album = $album;
        }

        public function setAuthor($author) {
            $this->author = $author;
        }

        public function setStartTime($start_time) {
            $this->start_time = $start_time;
        }

        public function setDuration($duration) {
            $this->duration = $duration;
        }

        public function setCategory($category) {
            $this->category = $category;
        }

        public function setIsCanCon($is_can_con) {
            $can_con_value_to_set = $is_can_con;

            if ($is_can_con == 1) {
                $can_con_value_to_set = true;
            } else if ($is_can_con == 0) {
                $can_con_value_to_set = false;
            }

            $this->is_can_con = $can_con_value_to_set;
        }

        public function setIsNewRelease($is_new_release) {
            $this->is_new_release = $is_new_release;
        }

        public function setIsFrenchVocalMusic($is_french_vocal_music) {
            $this->is_french_vocal_music = $is_french_vocal_music;
        }

        public function setAdNumber($ad_number) {
            $this->ad_number = $ad_number;
        }

        public function setPlaylistId($playlist_id) {
            $this->playlist_id = $playlist_id;
        }

        public function jsonSerialize() {
            $startDateTime = $this->getStartTime();
            $startTimeString = $startDateTime->format('H:i');

            return [
                'id' => $this->getId(),
                'start_time' => $startTimeString,
                'name' => $this->getName(),
                'album' => $this->getAlbum(),
                'author' => $this->getAuthor(),
                'duration' => $this->getDuration(),
                'category' => $this->getCategory(),
                'can_con' => $this->isCanCon(),
                'new_release' => $this->isNewRelease(),
                'french_vocal_music' => $this->isFrenchVocalMusic(),
                'ad_number' => $this->getAdNumber(),
                'playlist_id' => $this->getPlaylistId()
            ];
        }

        public function getObjectAsArray() {
            return $this->jsonSerialize();
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

        public function getStartTime() {
            return $this->start_time;
        }

        public function getDuration() {
            return $this->duration;
        }

        public function getCategory() {
            return $this->category;
        }

        public function isCanCon() {
            return $this->is_can_con;
        }

        public function isNewRelease() {
            return $this->is_new_release;
        }

        public function isFrenchVocalMusic() {
            return $this->is_french_vocal_music;
        }

        public function getAdNumber() {
            return $this->ad_number;
        }

        public function getPlaylistId() {
            return $this->playlist_id;
        }
        
    }
