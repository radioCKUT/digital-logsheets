<?php

require_once('ErrorsContainer.php');

class SaveEpisodeErrors extends ErrorsContainer {

    public function __constructor() {
        $this->errors = [
            'missingProgram' => false,
            'missingProgrammer' => false,
            'missingStartTime' => false,
            'missingEndTime' => false,
            'tooLong' => false,
            'tooShort' => false,
            'airDateTooFarInPast' => false,
            'airDateTooFarInFuture' => false,
            'missingPrerecordDate' => false,
            'prerecordDateInFuture' => false,
            'prerecordDateTooFarInPast' => false
        ];
    }

    public function markProgramMissing() {
        $this->errors['missingProgram'] = true;
    }

    public function markProgrammerMissing() {
        $this->errors['missingProgrammer'] = true;
    }

    public function markStartTimeMissing() {
        $this->errors['missingStartTime'] = true;
    }

    public function markEndTimeMissing() {
        $this->errors['missingEndTime'] = true;
    }

    public function markTooLong() {
        $this->errors['tooLong'] = true;
    }

    public function markTooShort() {
        $this->errors['tooShort'] = true;
    }

    public function markAirDateTooFarInPast() {
        $this->errors['airDateTooFarInPast'] = true;
    }

    public function markAirDateTooFarInFuture() {
        $this->errors['airDateTooFarInFuture'] = true;
    }

    public function markPrerecordDateMissing() {
        $this->errors['missingPrerecordDate'] = true;
    }

    public function markPrerecordDateTooFarInFuture() {
        $this->errors['prerecordDateInFuture'] = true;
    }

    public function markPrerecordDateTooFarInPast() {
        $this->errors['prerecordDateTooFarInPast'] = true;
    }

}