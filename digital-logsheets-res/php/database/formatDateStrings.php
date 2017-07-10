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

/**
 * @param DateTime $dateTimeObject
 * @return String
 */
function formatDateStringForDatabaseWrite($dateTimeObject) {
    if ($dateTimeObject) {
        return $dateTimeObject->format("Y-m-d");

    } else {
        return null;
    }
}
/**
 * @param DateTime $dateTimeObject
 * @return String
 */
function formatDatetimeStringForDatabaseWrite($dateTimeObject) {
    if (is_null($dateTimeObject)) {
        return null;

    } else if ($dateTimeObject) {
        $dateTimeObject->setTimezone(new DateTimeZone('UTC'));
        return $dateTimeObject->format("Y-m-d H:i:s");

    } else {
        return null;
    }
}

/**
 * @param string $dateTimeString
 * @return DateTime
 */
function formatDateTimeStringFromDatabase($dateTimeString) {
    $NULL_DATETIME = getNullDatetimeString();

    if (is_null($dateTimeString) || $dateTimeString == $NULL_DATETIME) {
        return null;

    } else {
        $startDateTime = new DateTime($dateTimeString, new DateTimeZone('UTC'));
        $startDateTime->setTimezone(new DateTimeZone('America/Montreal'));

        return $startDateTime;
    }
}

function getNullDatetimeString() {
    return "0000-00-00 00:00:00";
}