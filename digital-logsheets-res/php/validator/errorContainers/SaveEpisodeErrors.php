<?php

require('ErrorsContainer.php');

class SaveEpisodeErrors extends ErrorsContainer {

    public function __constructor() {
        $this->errors = [
            'tooLong' => false,
            'tooShort' => false,
            'airDateTooFarInPast' => false,
            'airDateTooFarInFuture' => false,
            'prerecordDateInFuture' => false,
            'prerecordDateTooFarInPast' => false
        ];
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

    public function markPrerecordDateInFuture() {
        $this->errors['prerecordDateInFuture'] = true;
    }

    public function markPrerecordDateTooFarInPast() {
        $this->errors['prerecordDateTooFarInPast'] = true;
    }

}