<?php

require_once('errorContainers/SaveEpisodeErrors.php');
require_once('utilities/ValidatorUtility.php');

class EpisodeValidator {


    const EPISODE_MAX_LENGTH_HOURS = 24;
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

    public function isEpisodeValidForDraftSave() {
        $errorsContainer = new SaveEpisodeErrors();

        $this->areRequiredFieldsPresent($errorsContainer);
        $this->isEpisodeLengthValid($errorsContainer);
        $this->isEpisodeAirDateValid($errorsContainer);
        $this->isEpisodePrerecordDateValid($errorsContainer);
    }


    /**
     * @param SaveEpisodeErrors $errorsContainer
     */
    private function areRequiredFieldsPresent($errorsContainer) {

        $program = $this->episode->getProgram();
        if (ValidatorUtility::doesFieldExist($program)) {
            $errorsContainer->markProgramMissing();
        }

        $programmer = $this->episode->getProgrammer();
        if (ValidatorUtility::doesFieldExist($programmer)) {
            $errorsContainer->markProgrammerMissing();
        }

        $startTime = $this->episode->getStartTime();
        if (ValidatorUtility::doesFieldExist($startTime)) {
            $errorsContainer->markStartTimeMissing();
        }

        $endTime = $this->episode->getEndTime();
        if (ValidatorUtility::doesFieldExist($endTime)) {
            //TODO: is it enough to check end time as proxy for duration?
            $errorsContainer->markDurationMissing();
        }
    }

    /**
     * @param SaveEpisodeErrors $errorsContainer
     */
    private function isEpisodeLengthValid($errorsContainer) {
        $startTime = $this->episode->getStartTime();
        $endTime = $this->episode->getEndTime();

        $episodeInterval = $endTime->diff($startTime);

        $episodeLengthInHours = null;
        $episodeIntervalDaysComponent = $episodeInterval->days;

        if ($episodeIntervalDaysComponent != false && $episodeIntervalDaysComponent > 0) {
            $episodeLengthInHours = $episodeInterval->h + ($episodeIntervalDaysComponent * 24);

        } else {
            $episodeLengthInHours = $episodeInterval->h;
        }

        if ($episodeLengthInHours > self::EPISODE_MAX_LENGTH_HOURS) {
            $errorsContainer->markTooLong();

        } else if ($episodeLengthInHours < 0) {
            $errorsContainer->markTooShort();
        };
    }

    /**
     * @param SaveEpisodeErrors $errorsContainer
     */
    private function isEpisodeAirDateValid($errorsContainer) {
        $startTime = $this->episode->getStartTime();
        $daysSinceAirDate = $this->getDayDifferenceFromCurrentDate($startTime);

        if ($daysSinceAirDate > self::AIR_AFTER_CURRENT_DATE_LIMIT_DAYS) {
            $errorsContainer->markAirDateTooFarInFuture();

        } else if ($daysSinceAirDate < self::AIR_BEFORE_CURRENT_DATE_LIMIT_DAYS) {
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

            if (is_null($prerecordDate)) {
                $errorsContainer->markPrerecordDateMissing();

            } else {
                $daysSincePrerecordDate = $this->getDayDifferenceFromCurrentDate($prerecordDate);

                if ($daysSincePrerecordDate > self::PRERECORD_AFTER_CURRENT_DATE_LIMIT_DAYS) {
                    $errorsContainer->markPrerecordDateInFuture();

                } else if ($daysSincePrerecordDate < self::PRERECORD_BEFORE_CURRENT_DATE_LIMIT_DAYS) {
                    $errorsContainer->markPrerecordDateTooFarInPast();
                }
            }
        }
    }


    /**
     * @param DateTime $comparisonDate
     * @return int
     */
    private function getDayDifferenceFromCurrentDate($comparisonDate) {
        $currentTime = new DateTime();

        $timeSinceComparisonDateInterval = $currentTime->diff($comparisonDate);
        $daysSinceComparisonDate = $timeSinceComparisonDateInterval->format('%R%a');
        return intval($daysSinceComparisonDate);
    }

}