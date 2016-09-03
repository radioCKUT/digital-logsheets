<?php

    class ValidatorUtility {

        public static function isInteger($value) {
            return filter_var($value, FILTER_VALIDATE_INT) !== false;
        }

        public static function doesFieldExist($field) {
            if (is_null($field)) {
                return false;
            }

            if (gettype($field) == 'string' && $field === '') {
                return false;
            }

            return true;
        }

    }