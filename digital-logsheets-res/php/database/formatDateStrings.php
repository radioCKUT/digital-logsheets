<?php

function formatDateString($dateTimeObject) {

    $dateTimeObject->setTimezone(new DateTimeZone('UTC'));
    $dateTimeObject = $dateTimeObject->format("Y-m-d H:i:s");

    return $dateTimeObject;
}