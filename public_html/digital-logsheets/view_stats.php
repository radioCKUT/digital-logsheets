<?php
	include 'connect_to_mysql.php';
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

        function search_stats() {

            var date_start = $( "#date_start" ).val();
			var time_start = $( "#time_start" ).val();
			var date_end = $( "#date_end" ).val();
			var time_end = $( "#time_end" ).val();
			var ad_num = $( "#ad_num" ).val();
			
			if (date_start != "" && time_start != "" && date_end != "" && time_end != ""){
                            
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
			xmlhttp_login.open("GET","server_filter_stat.php?date_start="+date_start+"&time_start="+time_start+"&date_end="+date_end+"&time_end="+time_end+"&ad_num="+ad_num,true);
			xmlhttp_login.send();
            } else {
				alert("Please fill all required field.");
            }
        }

    </script>
</head>
<body>
	
<div class="container-fluid">
	<div class="row">
	<div class="col-lg-6" style="padding-top: 20px;">
    <div class="input-group">
      From <input type="date" id="date_start">
	  <input type="time" id="time_start">
	  To <input type="date" id="date_end">
	  <input type="time" id="time_end">
	  Advertisement number: <input type="text" name="ad_num" id="ad_num">
    </div><!-- /input-group -->
	</div><!-- /.col-lg-6 -->
	<span class="input-group-btn" style="float: left;">
        <button class="btn btn-default" type="button" onclick="search_stats()">Search</button>
    </span>
	</div>
	
<?php   
		echo "<div class='logsheets'><table class='table' id='segments' >";
		$draft = mysql_query("SELECT * FROM segment");
		while ($draft_row = mysql_fetch_array($draft)){
			
			$start_time = date("Y-m-d\TH:i", strtotime($draft_row['start_time']));
			if ($draft_row['start_time']==''){
				$start_time = 0;
			}
			
			$approx_duration_mins = $draft_row['approx_duration_mins'];
			if ($draft_row['approx_duration_mins']=='NULL'){
				$approx_duration_mins = 0;
			}
			$end_time = date("Y-m-d H:i:s", strtotime($draft_row['start_time']) + $approx_duration_mins*60);
			if ($end_time==''){
				$end_time = 0;
			}
			
			echo '
			<tr>
            <td>'.$draft_row['name'].': '.$draft_row['start_time'].' - '.$end_time.'</td>
			</tr>';
		}
		echo "</table></div>";
    
?>
</div>


</body>
</html>