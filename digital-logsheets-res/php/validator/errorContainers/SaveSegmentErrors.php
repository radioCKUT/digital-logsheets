<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.    
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2017  Evan Vassallo
 * Copyright (C) 2016-2017  James Wang
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once('ErrorsContainer.php');

    class SaveSegmentErrors extends ErrorsContainer {

        public function __constructor() {
            $this->errors = array(
                'missingCategory' => false,
                'categoryInvalidFormat' => false,
                'missingAlbum' => false,
                'missingAuthor' => false,
                'missingName' => false,
                'missingAdNumber' => false,
                'missingStartTime' => false,
                'startTimeInvalidFormat' => false,
                'outOfEpisodeBounds' => false,
                'invalidAdNumber' => false
            );
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

        public function markAdNubmerInvalid() {
            $this->errors['invalidAdNumber'] = true;
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