<?php
    /*
     * Description:
     * Stores credentials in a seperate file to allow easy modification and reuse.
     */
     
     //server settings
     $servername=getenv('IP');
     $port = "3306";
     
     //database settings
     $database="c9";
     $username=getenv('C9_USER');
     $password="";
?>