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
    }