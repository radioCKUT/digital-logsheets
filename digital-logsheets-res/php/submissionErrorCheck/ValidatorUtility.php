<?php

    class ValidatorUtility {

        public static function isInteger($value) {
            return filter_var($value, FILTER_VALIDATE_INT) !== false;
        }

        public static function doesFieldExist($field) {
            return ($field != null && $field != '');
        }

    }