<?php

function formatDateStringForDatabaseWrite($dateTimeObject) {

    $dateTimeObject->setTimezone(new DateTimeZone('UTC'));
    $dateTimeObject = $dateTimeObject->format("Y-m-d H:i:s");

    return $dateTimeObject;
}

function formatDateStringFromDatabase($dateString) {

    $StartDateTime = new DateTime($dateString, new DateTimeZone('UTC'));
    $StartDateTime->setTimezone(new DateTimeZone('America/Montreal'));

    return $StartDateTime;
}