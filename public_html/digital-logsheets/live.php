<?php
include_once("../../digital-logsheets-res/php/database/connectToDatabase.php");
include_once("../../digital-logsheets-res/php/database/manageSegmentEntries.php");
?>


<!DOCTYPE html>
<html>
<head>
    <title>
	Statistics
    </title>
    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="http://getbootstrap.com/dist/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Select2 -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
    <link href="css/select2-bootstrap.css" rel="stylesheet"/>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Boostrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>

    <script src="js/filterLogsheetList.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
	<script type="text/javascript">
	 
		var time;
	 
		function set_interval() {  
			get_live();
			time = setInterval(function(){get_live();},5000);
		}

        function get_live() { 
		
            if (window.XMLHttpRequest)
			  {
			  xmlhttp_login=new XMLHttpRequest();
			  }
			else
			  {
			  xmlhttp_login=new ActiveXObject("Microsoft.XMLHTTP");
			  }
			xmlhttp_login.onreadystatechange=function()
			  {
			  if (xmlhttp_login.readyState==4 && xmlhttp_login.status==200)
			    {
					document.getElementById("segments").innerHTML = xmlhttp_login.responseText;
			    }
			  }
			xmlhttp_login.open("GET","server-get-live.php",true);
			xmlhttp_login.send();
        }

    </script>
</head>

<body onload="set_interval()">	
<div class="container-fluid">
<?php   
		echo "<div class='logsheets'><table class='table' id='segments' >";
		echo "</table></div>";
?>
</div>
</body>
</html>