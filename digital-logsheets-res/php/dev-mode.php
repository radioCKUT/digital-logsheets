<?php

	//globally controlled error reporting (for development)
	$dev_mode = TRUE;
	
	if($GLOBALS["dev_mode"]) {
	    error_reporting(E_ALL);
	    ini_set("display_errors", "1");
	}
?>