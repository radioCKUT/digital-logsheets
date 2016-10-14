<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2016  Evan Vassallo
 * Copyright (C) 2016  James Wang
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

require_once('utilities/ValidatorUtility.php');
require('CategoryValidator.php');
require('utilities/TimeValidator.php');
require('errorContainers/SaveSegmentErrors.php');

class SegmentValidator {

    /**
     * @var Segment
     */
    private $segment;

    /**
     * @var Episode
     */
    private $episode;

    public function __construct($segment, $episode) {
        $this->segment = $segment;
        $this->episode = $episode;
    }

    /**
     * @return SaveSegmentErrors
     */
    public function isSegmentValidForDraftSave() {
        $errors = new SaveSegmentErrors();

        $this->isCategoryValid($errors);
        $this->isStartTimeDataAValidTime($errors);
        $this->isStartTimeWithinEpisodeBounds($errors);
        $this->areRequiredCategoryFieldsPresent($errors);

        return $errors;
    }

    public function isSegmentValidForEdit() {

    }

    public function isSegmentValidForFinalSave() {
        $errors = $this->isSegmentValidForDraftSave();

        // TODO: check for Segment duration

        return $errors;

    }

    /**
     * @param SaveSegmentErrors $errors
     */
    private function isCategoryValid($errors) {
        $category = $this->segment->getCategory();

        if (!ValidatorUtility::doesFieldExist($category)) {
            $errors->markCategoryMissing();
        }

        $categoryValidator = new CategoryValidator($category);
        
        if (!$categoryValidator->isCategoryValid()) {
            $errors->markCategoryInvalidFormat();
        }
    }

    /**
     * @param SaveSegmentErrors $errors
     */
    private function isStartTimeDataAValidTime($errors) {
        $startTime = $this->segment->getStartTime();

        if (!ValidatorUtility::doesFieldExist($startTime)) {
            $errors->markStartTimeMissing();
        }

        if (!($startTime instanceof DateTime)) {
            $errors->markStartTimeInvalidFormat();
        }
    }

    /**
     * @param SaveSegmentErrors $errors
     */
    private function isStartTimeWithinEpisodeBounds($errors) {
        $startTime = $this->segment->getStartTime();

        if (!TimeValidator::isSegmentWithinEpisodeBounds($startTime, $this->episode)) {
            $errors->markStartTimeOutOfEpisodeBounds();
        }
    }



    /**
     * @param SaveSegmentErrors $errors
     * @return array
     */
    private function areRequiredCategoryFieldsPresent($errors) {
        $category = $this->segment->getCategory();

        $author = $this->segment->getAuthor();
        $album = $this->segment->getAlbum();
        $name = $this->segment->getName();

        switch ($category) {
            case 1:
            case 2:
                if (!ValidatorUtility::doesFieldExist($author)) {
                    $errors->markAuthorMissing();
                }

                if (!ValidatorUtility::doesFieldExist($album)) {
                    $errors->markAlbumMissing();
                }
            case 3:
            case 4:
                if (!ValidatorUtility::doesFieldExist($name)) {
                    $errors->markNameMissing();
                }
                break;

            case 5:
                self::isAdNumberValid($errors);
        }
    }

    /**
     * @param SaveSegmentErrors $errors
     */
    private function isAdNumberValid($errors) {
        $adNumber = $this->segment->getAdNumber();

        if (!ValidatorUtility::doesFieldExist($adNumber) ||
            !ValidatorUtility::isInteger($adNumber)) {

            $errors->markAdNumberMissing();
        }
    }

}