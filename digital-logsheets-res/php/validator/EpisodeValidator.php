<?php

require('errorContainers/SaveEpisodeErrors.php');

class EpisodeValidator {


    const EPISODE_MAX_LENGTH_HOURS = 24;
    const AIR_BEFORE_CURRENT_DATE_LIMIT_DAYS = 31;
    const AIR_AFTER_CURRENT_DATE_LIMIT_DAYS = 31;

    const PRERECORD_BEFORE_CURRENT_DATE_LIMIT_DAYS = 62;

    /**
     * @var Episode
     */
    private $episode;

    public function __construct($episode) {
        $this->episode = $episode;
    }

    public function isEpisodeValidForDraftSave() {
        $errorsContainer = new SaveEpisodeErrors();

        $this->isEpisodeLengthValid($errorsContainer);
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

    private function isEpisodeAirDateValid() {

    }

}