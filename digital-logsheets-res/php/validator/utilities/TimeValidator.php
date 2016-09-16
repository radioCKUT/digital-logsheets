<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2016  Evan Vassallo
 * Copyright (C) 2016  James Wang
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
            $segmentDateTime = null;

            if ($segmentTime instanceof DateTime) {
                $segmentDateTime = $segmentTime;

            } else {
                $segmentDateTime = new DateTime("January 1, " . $segmentTime);
            }

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