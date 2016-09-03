<?php

require_once('ValidatorUtility.php');
require('CategoryValidator.php');
require('TimeValidator.php');
require('AddSegmentsErrors.php');

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
     * @return AddSegmentsErrors
     */
    public function isSegmentValidForDraftSave() {
        $errors = new AddSegmentsErrors();

        $this->isStartTimeDataAValidTime($errors);
        $this->isStartTimeWithinEpisodeBounds($errors);
        $this->areRequiredCategoryFieldsPresent($errors);

        return $errors;
    }

    public function isSegmentValidForFinalSave() {
        $errors = $this->isSegmentValidForDraftSave();

        // TODO: check for Segment duration, playlist ID

        return $errors;

    }

    private function areRequiredMetadataFieldsPresent($errors) {

    }

    /**
     * @param AddSegmentsErrors $errors
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
     * @param AddSegmentsErrors $errors
     */
    private function isStartTimeWithinEpisodeBounds($errors) {
        $startTime = $this->segment->getStartTime();

        if (!TimeValidator::isSegmentWithinEpisodeBounds($startTime, $this->episode)) {
            $errors->markStartTimeOutOfEpisodeBounds();
        }
    }



    /**
     * @param AddSegmentsErrors $errors
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
     * @param AddSegmentsErrors $errors
     */
    private function isAdNumberValid($errors) {
        $adNumber = $this->segment->getAdNumber();

        if (!ValidatorUtility::doesFieldExist($adNumber) ||
            !ValidatorUtility::isInteger($adNumber)) {

            $errors->markAdNumberMissing();
        }
    }

}