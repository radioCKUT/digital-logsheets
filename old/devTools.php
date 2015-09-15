<?php
    //error reporting for development
    error_reporting(E_ALL);
    ini_set("display_errors", "On");
    
    //showing array contents in nice format
    function printArray($data) {
        print "<pre>";
        print_r($data);
        print "</pre>";
    }
?>