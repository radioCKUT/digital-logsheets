<!DOCTYPE html>
<html>
<head>
    <title>
        Logsheets Retrieval
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

        function filterLogsheetListByTime() {

            var date_search = $( "#date_search" ).val();
			var time_search = $( "#time_search" ).val();
			console.log(date_search + " " + time_search);
			
			if (date_search != "" && time_search != ""){
                            
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
					document.getElementById("logsheets").innerHTML = xmlhttp_login.responseText;
			    }
			  }
			xmlhttp_login.open("GET","server_filter_time.php?date_search="+date_search+"&time_search="+time_search,true);
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
	<h1 style="float: left;">Episodes</h1>
	<div class="col-lg-6" style="padding-top: 20px;">
    <div class="input-group">
      <input type="date" id="date_search">
	  <input type="time" id="time_search">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button" onclick="filterLogsheetListByTime()">Search</button>
      </span>
    </div><!-- /input-group -->
	</div><!-- /.col-lg-6 -->
	</div>
	
    <div class="logsheets">
	<table class="table" id="logsheets">
        {foreach $episodes as $episode}
		<tr>
            <td><a href="view-episode-segment.php?episode_id={$episode.id}">{$episode.program} - {$episode.startDate}</a></td>
		</tr>
        {/foreach}
	</table>
    </div>
</div>


</body>
</html>
    