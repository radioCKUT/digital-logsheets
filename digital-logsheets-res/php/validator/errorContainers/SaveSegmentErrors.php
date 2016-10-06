<?php

require('ErrorsContainer.php');

    class SaveSegmentErrors extends ErrorsContainer {

        public function __constructor() {
            $this->errors = [
                'missingCategory' => false,
                'categoryInvalidFormat' => false,
                'missingAlbum' => false,
                'missingAuthor' => false,
                'missingName' => false,
                'missingAdNumber' => false,
                'missingStartTime' => false,
                'startTimeInvalidFormat' => false,
                'outOfEpisodeBounds' => false
            ];
        }

        public function markCategoryMissing() {
            $this->errors['missingCategory'] = true;
        }

        public function markCategoryInvalidFormat() {
            $this->errors['categoryInvalidFormat'] = true;
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

        public function markStartTimeInvalidFormat() {
            $this->errors['startTimeInvalidFormat'] = true;
        }

        public function markStartTimeOutOfEpisodeBounds() {
            $this->errors['outOfEpisodeBounds'] = true;
        }
    }