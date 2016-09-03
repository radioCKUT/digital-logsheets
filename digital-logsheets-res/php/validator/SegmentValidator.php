<?php

require('./ValidatorUtility.php');
require('./CategoryValidator.php');
require('./TimeValidator.php');
require('../addSegmentsErrors.php');

class SegmentValidator {

    private $errors;

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

    public function isSegmentValidForDraftSave() {
        $errors = new addSegmentsErrors();

        $this->isStartTimeDataAValidTime($errors);
        $this->areRequiredCategoryFieldsPresent($errors);

        return $errors;
    }

    public function isSegmentValidForFinalSave() {

    }


    /**
     * @param addSegmentsErrors $errors
     */
    private function isStartTimeDataAValidTime($errors) {
        $this->isTimePresent($errors);

        $startTime = $this->segment->getStartTime();
        if (!TimeValidator::isTimeInValidFormat($startTime)){
            $errors->markStartTimeMissing();
        };
    }


    /**
     * @param addSegmentsErrors $errors
     */
    private function isTimePresent($errors) {
        $startTime = $this->segment->getStartTime();

        if (!ValidatorUtility::doesFieldExist($startTime)) {
            $errors->markStartTimeMissing();
        }
    }




    /**
     * @param addSegmentsErrors $errors
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
            case 5:
                self::isAdNumberValid($errors);
        }

        return $this->errors;
    }

    /**
     * @param addSegmentsErrors $errors
     */
    private function isAdNumberValid($errors) {
        $adNumber = $this->segment->getAdNumber();

        if (!ValidatorUtility::doesFieldExist($adNumber) ||
            !ValidatorUtility::isInteger($adNumber)) {

            $errors->markAdNumberMissing();
        }
    }

}