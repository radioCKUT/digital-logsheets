<?php

    class addSegmentsErrors {

        private $errors = [
            'missingAlbum' => false,
            'missingAuthor' => false,
            'missingName' => false,
            'missingAdNumber' => false,
            'missingStartTime' => false,
            'outOfEpisodeBounds' => false
        ];

        public function getAllErrors() {
            return $this->errors;
        }

        public function markAlbumMissing() {
            $this->errors['missingAlbum'] = true;
        }

        public function markAuthorMissing() {
            $this->errors['missingAuthor'] = true;
        }

        public function markNameMissing() {
            $this->errors['missingName'] = true;
        }

        public function markAdNumberMissing() {
            $this->errors['missingAdNumber'] = true;
        }

        public function markStartTimeMissing() {
            $this->errors['missingStartTime'] = true;
        }

        public function markStartTimeOutOfEpisodeBounds() {
            $this->errors['outOfEpisodeBounds'] = true;
        }
    }