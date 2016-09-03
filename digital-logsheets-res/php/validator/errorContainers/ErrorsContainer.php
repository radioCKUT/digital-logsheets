<?php

    class ErrorsContainer {
        protected $errors = [];

        public function getAllErrors() {
            return $this->errors;
        }

        public function doErrorsExist() {
            return in_array(true, $this->errors);
        }

    }

