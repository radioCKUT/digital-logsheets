<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2017  Evan Vassallo
 * Copyright (C) 2017 Donghee Baik
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

require_once('errorContainers/SaveEpisodeErrors.php');
require_once('utilities/ValidatorUtility.php');

class EpisodeValidator {


    const EPISODE_MAX_LENGTH_HOURS = 24;
    const EPISODE_MIN_LENGTH_HOURS = 0.25;
    const AIR_BEFORE_CURRENT_DATE_LIMIT_DAYS = 31;
    const AIR_AFTER_CURRENT_DATE_LIMIT_DAYS = 31;

    const PRERECORD_BEFORE_CURRENT_DATE_LIMIT_DAYS = 62;
    const PRERECORD_AFTER_CURRENT_DATE_LIMIT_DAYS = 0;

    /**
     * @var Episode
     */
    private $episode;

    public function __construct($episode) {
        $this->episode = $episode;
    }

    public function checkDraftSaveValidity() {
        $errorsContainer = new SaveEpisodeErrors();

        $this->areRequiredFieldsPresent($errorsContainer);
        $this->isEpisodeLengthValid($errorsContainer);
        $this->isEpisodeAirDateValid($errorsContainer);
        $this->isEpisodePrerecordDateValid($errorsContainer);

        return $errorsContainer;
    }

    public function checkFinalSaveValidity() {
        $errorsContainer = new SaveEpisodeErrors();

        $this->areRequiredFieldsPresent($errorsContainer);
        $this->isEpisodeLengthValid($errorsContainer);
        $this->isEpisodeAirDateValid($errorsContainer);
        $this->isEpisodePrerecordDateValid($errorsContainer);

        return $errorsContainer;
    }

    public static function getEpisodeEarlyLimit() {
        $episodeEarlyLimit = new DateTime('now', new DateTimeZone('America/Montreal'));
        $episodeEarlyLimit->modify('-' . self::AIR_AFTER_CURRENT_DATE_LIMIT_DAYS . ' days');

        return $episodeEarlyLimit;
    }

    public static function getEpisodeLateLimit() {
        $episodeLateLimit = new DateTime('now', new DateTimeZone('America/Montreal'));
        $episodeLateLimit->modify('+' . self::AIR_AFTER_CURRENT_DATE_LIMIT_DAYS . ' days');

        return $episodeLateLimit;
    }

    public static function getPrerecordDateEarlyDaysLimit() {
        return self::PRERECORD_BEFORE_CURRENT_DATE_LIMIT_DAYS;
    }

    public static function getPrerecordDateLateDaysLimit() {
        return self::PRERECORD_AFTER_CURRENT_DATE_LIMIT_DAYS;
    }

    public static function getMinEpisodeLengthInHours() {
        return self::EPISODE_MIN_LENGTH_HOURS;
    }

    public static function getMaxEpisodeLengthInHours() {
        return self::EPISODE_MAX_LENGTH_HOURS;
    }




    /**
     * @param SaveEpisodeErrors $errorsContainer
     */
    private function areRequiredFieldsPresent($errorsContainer) {

        $this->isProgramPresent($errorsContainer);

        $programmer = $this->episode->getProgrammer();
        if (!ValidatorUtility::doesFieldExist($programmer)) {
            $errorsContainer->markProgrammerMissing();
        }

        $startTime = $this->episode->getStartTime();
        if (!ValidatorUtility::doesFieldExist($startTime)) {
            $errorsContainer->markStartTimeMissing();

        }

        $endTime = $this->episode->getEndTime();
        if (!ValidatorUtility::doesFieldExist($endTime)) {
            $errorsContainer->markEndTimeMissing();
        }
    }

    /**
     * @param SaveEpisodeErrors $errorsContainer
     */
    private function isProgramPresent($errorsContainer) {
        $program = $this->episode->getProgram();

        if (!ValidatorUtility::doesFieldExist($program->getName())) {
            $errorsContainer->markProgramMissing();
        }
    }

    /**
     * @param SaveEpisodeErrors $errorsContainer
     */
    private function isEpisodeLengthValid($errorsContainer) {
        $startTime = $this->episode->getStartTime();
        $endTime = $this->episode->getEndTime();

        if ($startTime == null || $endTime == null) {
            return;
        }

        $startTime = $startTime->format('U');
        $endTime = $endTime->format('U');
        $episodeLengthInHours = ($endTime - $startTime) / (60*60);

        if ($episodeLengthInHours > self::EPISODE_MAX_LENGTH_HOURS) {
            $errorsContainer->markTooLong();

        } else if ($episodeLengthInHours < self::EPISODE_MIN_LENGTH_HOURS) {
            $errorsContainer->markTooShort();
        };
    }

    /**
     * @param SaveEpisodeErrors $errorsContainer
     */
    private function isEpisodeAirDateValid($errorsContainer) {
        $startTime = $this->episode->getStartTime();

        if ($startTime == null) {
            return;
        }

        $daysSinceAirDate = $this->getDayDifferenceFromCurrentDate($startTime);

        if ($daysSinceAirDate > self::AIR_AFTER_CURRENT_DATE_LIMIT_DAYS) {
            $errorsContainer->markAirDateTooFarInFuture();

        } else if ($daysSinceAirDate < (self::AIR_BEFORE_CURRENT_DATE_LIMIT_DAYS * -1)) {
            $errorsContainer->markAirDateTooFarInPast();
        }
    }


    /**
     * @param SaveEpisodeErrors $errorsContainer
     */
    private function isEpisodePrerecordDateValid($errorsContainer) {
        $prerecord = $this->episode->isPrerecord();

        if ($prerecord) {
            $prerecordDate = $this->episode->getPrerecordDate();
            $episodeStartDate = $this->episode->getStartTime();

            if (is_null($episodeStartDate)) {
                return;
            }

            if (is_null($prerecordDate)) {
                $errorsContainer->markPrerecordDateMissing();

            } else {
                $daysSincePrerecordDate = $this->getDayDifferenceFromDate($episodeStartDate, $prerecordDate);

                if ($daysSincePrerecordDate > self::PRERECORD_AFTER_CURRENT_DATE_LIMIT_DAYS) {
                    $errorsContainer->markPrerecordDateTooFarInFuture();

                } else if ($daysSincePrerecordDate < (self::PRERECORD_BEFORE_CURRENT_DATE_LIMIT_DAYS * -1)) {
                    $errorsContainer->markPrerecordDateTooFarInPast();
                }
            }
        }
    }

    /**
     * @param DateTime $fromDate
     * @param DateTime $toDate
     * @return int
     */
    private function getDayDifferenceFromDate($fromDate, $toDate) {
        $fromDateInMillisecs = $fromDate->format('U');
        $toDateInMillisecs = $toDate->format('U');

        $daysSinceFromDate = ($toDateInMillisecs - $fromDateInMillisecs) / (60*60*24);

        return $daysSinceFromDate;
    }


    /**
     * @param DateTime $comparisonDate
     * @return int
     */
    private function getDayDifferenceFromCurrentDate($comparisonDate) {
        $currentTime = new DateTime('now', new DateTimeZone('America/Montreal'));
        return $this->getDayDifferenceFromDate($currentTime, $comparisonDate);

    }

}