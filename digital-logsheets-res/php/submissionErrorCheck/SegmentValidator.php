<?php

require('./ValidatorUtility.php');
require('./CategoryValidator.php');

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

    private function resetErrors() {
        $this->errors = [
            'missingAlbum' => false,
            'missingAuthor' => false,
            'missingName' => false,
            'missingAdNumber' => false,
            'missingStartTime' => false,
            'outOfBoundsStartTime' => false
        ];
    }

    public function isSegmentValidForDraftSave() {
        $this->resetErrors();

        $this->isTimePresent();
        $this->isAdNumberValid();
        $this->areRequiredCategoryFieldsPresent();
    }

    public function isSegmentValidForFinalSave() {
        $this->resetErrors();
    }


    private function isTimePresent() {
        $startTime = $this->segment->getStartTime();

        if (!ValidatorUtility::doesFieldExist($startTime)) {
            $this->errors['missingStartTime'] = true;
        }
    }

    private function isAdNumberValid() {
        $adNumber = $this->segment->getAdNumber();

        if (!ValidatorUtility::doesFieldExist($adNumber) ||
            ValidatorUtility::isInteger($adNumber)) {

            $this->errors['missingAdNumber'] = true;
        }
    }

    /**
     * @return array
     */
    private function areRequiredCategoryFieldsPresent() {
        $category = $this->segment->getCategory();

        $author = $this->segment->getAuthor();
        $album = $this->segment->getAlbum();
        $name = $this->segment->getName();

        switch ($category) {
            case 1:
            case 2:
                if (!ValidatorUtility::doesFieldExist($author)) {
                    $this->errors['missingAuthor'] = true;
                }

                if (!ValidatorUtility::doesFieldExist($album)) {
                    $this->errors['missingAlbum'] = true;
                }
            case 3:
            case 4:
                if (!ValidatorUtility::doesFieldExist($name)) {
                    $this->errors['missingName'] = true;
                }
            case 5:
                self::isAdNumberValid();
        }

        return $this->errors;
    }

}