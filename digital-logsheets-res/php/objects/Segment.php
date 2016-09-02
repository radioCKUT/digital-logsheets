<?php
    include_once(__DIR__ . "/../database/manageSegmentEntries.php");

    class Segment extends LogsheetComponent implements JsonSerializable{

        private $name;
        private $author;
        private $album;

        /**
         * @var DateTime
         */
        private $startTime;
        private $duration = 0;

        private $category;

        private $isCanCon;
        private $isNewRelease;
        private $isFrenchVocalMusic;

        private $adNumber;
        private $playlistId;

        public function __construct($db, $componentId) {
            parent::__construct($db, $componentId);

            if ($componentId != null) {
                manageSegmentEntries::getSegmentAttributesFromDatabase($db, $componentId, $this);
            }
        }

        public function validate() {

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

        public function setStartTime($startTime) {
            $this->startTime = $startTime;
        }

        public function setDuration($duration) {
            $this->duration = $duration;
        }

        public function setCategory($category) {
            $this->category = $category;
        }

        public function setIsCanCon($isCanCon) {
            if (!$isCanCon) {
                $this->isCanCon = false;
            } else {
                $this->isCanCon = true;
            }
        }

        public function setIsNewRelease($isNewRelease) {
            if (!$isNewRelease) {
                $this->isNewRelease = false;
            } else {
                $this->isNewRelease = true;
            }
        }

        public function setIsFrenchVocalMusic($isFrenchVocalMusic) {
            if (!$isFrenchVocalMusic) {
                $this->isFrenchVocalMusic = false;
            } else {
                $this->isFrenchVocalMusic = true;
            }
        }

        public function setAdNumber($adNumber) {
            $this->adNumber = $adNumber;
        }

        public function setPlaylistId($playlistId) {
            $this->playlistId = $playlistId;
        }

        public function jsonSerialize() {
            $startDateTime = $this->getStartTime();
            $startTimeString = $startDateTime->format('H:i');

            return [
                'id' => $this->getId(),
                'startTime' => $startTimeString,
                'name' => $this->getName(),
                'album' => $this->getAlbum(),
                'author' => $this->getAuthor(),
                'duration' => $this->getDuration(),
                'category' => $this->getCategory(),
                'canCon' => $this->isCanCon(),
                'newRelease' => $this->isNewRelease(),
                'frenchVocalMusic' => $this->isFrenchVocalMusic(),
                'adNumber' => $this->getAdNumber(),
                'playlistId' => $this->getPlaylistId()
            ];
        }

        public function getObjectAsArray() {
            $startDateTime = $this->getStartTime();
            $startTimeString = $startDateTime->format('H:i');

            return [
                'id' => $this->getId(),
                'startTime' => $startTimeString,
                'name' => $this->getName(),
                'album' => $this->getAlbum(),
                'author' => $this->getAuthor(),
                'duration' => $this->getDuration(),
                'category' => $this->getCategory(),
                'canCon' => $this->isCanCon() ? "Yes" : "No",
                'newRelease' => $this->isNewRelease() ? "Yes" : "No",
                'frenchVocalMusic' => $this->isFrenchVocalMusic() ? "Yes" : "No",
                'adNumber' => $this->getAdNumber(),
                'playlistId' => $this->getPlaylistId()
            ];
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
            return $this->startTime;
        }

        public function getDuration() {
            return $this->duration;
        }

        /**
         * @return Category
         */
        public function getCategory() {
            return $this->category;
        }

        public function isCanCon() {
            return $this->isCanCon;
        }

        public function isNewRelease() {
            return $this->isNewRelease;
        }

        public function isFrenchVocalMusic() {
            return $this->isFrenchVocalMusic;
        }

        public function getAdNumber() {
            return $this->adNumber;
        }

        public function getPlaylistId() {
            return $this->playlistId;
        }
        
    }
