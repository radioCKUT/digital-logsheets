<?php

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

    $StartDateTime = new DateTime($dateString, new DateTimeZone('UTC'));
    $StartDateTime->setTimezone(new DateTimeZone('America/Montreal'));

    return $StartDateTime;
}