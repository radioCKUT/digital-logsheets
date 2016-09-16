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

/**
 * @param DateTime $dateTimeObject
 * @return DateTime
 */
function formatDateStringForDatabaseWrite($dateTimeObject) {

    $dateTimeObject->setTimezone(new DateTimeZone('UTC'));
    $dateTimeObject = $dateTimeObject->format("Y-m-d H:i:s");

    return $dateTimeObject;
}

/**
 * @param string $dateString
 * @return DateTime
 */
function formatDateStringFromDatabase($dateString) {

    $startDateTime = new DateTime($dateString, new DateTimeZone('UTC'));
    $startDateTime->setTimezone(new DateTimeZone('America/Montreal'));

    return $startDateTime;
}