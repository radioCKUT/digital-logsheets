<?php

    class TimeValidator {
        public static function isTimeInValidFormat($time) {
            $dateTime = DateTime::createFromFormat('H:i', $time);
            if (!$dateTime) {
                return false;
            }

            $errors = DateTime::getLastErrors();
            if (!empty($errors['warning_count'])) {
                return false;
            }

            return true;
        }


        /**
         * @param $segmentTime
         * @param Episode $episode
         * @return bool
         */
        public static function isSegmentWithinEpisodeBounds($segmentTime, $episode) {
            $segmentDateTime = new DateTime("January 1, " . $segmentTime);
            $segmentStartTimeInMinutes = self::getTimeInMinutesSinceMidnight($segmentDateTime);

            $episodeStartTime = $episode->getStartTime();
            $episodeStartTimeInMinutes = self::getTimeInMinutesSinceMidnight($episodeStartTime);
            $episodeStartDay = $episodeStartTime->format('N');

            $episodeEndTime = $episode->getEndTime();
            $episodeEndTimeInMinutes = self::getTimeInMinutesSinceMidnight($episodeEndTime);
            $episodeEndDay = $episodeEndTime->format('N');

            if ($episodeStartDay === $episodeEndDay) {
                if (($segmentStartTimeInMinutes >= $episodeStartTimeInMinutes)
                    && ($segmentStartTimeInMinutes <= $episodeEndTimeInMinutes)) {
                    return true;
                }

            } else if (($segmentStartTimeInMinutes + MINUTES_IN_DAY >= $episodeStartTimeInMinutes
                    && $segmentStartTimeInMinutes <= $episodeEndTimeInMinutes)
                || ($segmentStartTimeInMinutes >= $episodeStartTimeInMinutes
                    && $segmentStartTimeInMinutes <= $episodeEndTimeInMinutes + MINUTES_IN_DAY)) {
                return true;
            }

            return false;
        }

        /**
         * @param DateTime $dateTime
         * @return int mixed
         */
        private static function getTimeInMinutesSinceMidnight($dateTime) {
            //TODO: error handling
            return (((int)$dateTime->format('H')) * 60) + (int)$dateTime->format('i');
        }
    }