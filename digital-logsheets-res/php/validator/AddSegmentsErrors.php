<?php

require('ErrorsContainer.php');

    class AddSegmentsErrors extends ErrorsContainer {

        public function __constructor() {
            $this->errors = [
                'missingAlbum' => false,
                'missingAuthor' => false,
                'missingName' => false,
                'missingAdNumber' => false,
                'missingStartTime' => false,
                'startTimeInvalidFormat' => false,
                'outOfEpisodeBounds' => false
            ];
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