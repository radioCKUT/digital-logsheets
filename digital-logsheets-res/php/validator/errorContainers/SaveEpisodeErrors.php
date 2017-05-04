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

class SaveEpisodeErrors extends ErrorsContainer {

    public function __constructor() {
        $this->errors = array(
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
        );
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