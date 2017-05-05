<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2017  Evan Vassallo
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

        const MINUTES_IN_DAY = 1440; // 24 * 60

        public static function isTimeInValidFormat($time) {
            $dateTime = new DateTime($time);

            return !$dateTime ? false : true;
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
                return self::isSegmentInEpisodeSpanningOneCalendarDay($segmentStartTimeInMinutes, $episodeStartTimeInMinutes, $episodeEndTimeInMinutes);

            } else {
                return self::isSegmentInEpisodeSpanningTwoCalendarDays($segmentStartTimeInMinutes, $episodeStartTimeInMinutes, $episodeEndTimeInMinutes);
            }
        }

        private static function isSegmentInEpisodeSpanningOneCalendarDay($segmentStartTimeInMinutes, $episodeStartTimeInMinutes, $episodeEndTimeInMinutes) {
            return (($segmentStartTimeInMinutes >= $episodeStartTimeInMinutes)
                && ($segmentStartTimeInMinutes <= $episodeEndTimeInMinutes));
        }

        private static function isSegmentInEpisodeSpanningTwoCalendarDays($segmentStartTimeInMinutes, $episodeStartTimeInMinutes, $episodeEndTimeInMinutes) {
            return (self::isSegmentInEpisodesFirstCalendarDay($segmentStartTimeInMinutes, $episodeStartTimeInMinutes, $episodeEndTimeInMinutes)
                || self::isSegmentInEpisodesSecondCalendarDay($segmentStartTimeInMinutes, $episodeStartTimeInMinutes, $episodeEndTimeInMinutes));
        }

        private static function isSegmentInEpisodesFirstCalendarDay($segmentStartTimeInMinutes, $episodeStartTimeInMinutes, $episodeEndTimeInMinutes) {
            return ($segmentStartTimeInMinutes >= $episodeStartTimeInMinutes
                && $segmentStartTimeInMinutes <= $episodeEndTimeInMinutes + self::MINUTES_IN_DAY);
        }

        private static function isSegmentInEpisodesSecondCalendarDay($segmentStartTimeInMinutes, $episodeStartTimeInMinutes, $episodeEndTimeInMinutes) {
            return ($segmentStartTimeInMinutes + self::MINUTES_IN_DAY >= $episodeStartTimeInMinutes
                && $segmentStartTimeInMinutes <= $episodeEndTimeInMinutes);
        }

        /**
         * @param DateTime $dateTime
         * @return int mixed
         */
        private static function getTimeInMinutesSinceMidnight($dateTime) {
            //TODO: error handling
            return (((int) $dateTime->format('H')) * 60) + (int) $dateTime->format('i');
        }
    }