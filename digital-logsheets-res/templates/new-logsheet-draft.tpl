<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Logsheet</title>

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
    <script src="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"></script>
    <script src="js/htmlValidation/episodeValidation.js"></script>
    <script src="js/ui/prerecord.js"></script>
    <script src="js/ui/categoryButton.js"></script>
    <script type="text/javascript">
	
	var episodeId = {$episodeId};
	var program = {$program};
	var programmer = {$programmer|json_encode};
	var end_time = {$end_time|json_encode};
	var start_time = {$start_time|json_encode};
	var duration = {$duration};
	var prerecord = {$prerecord};
	var prerecord_date = {$prerecord_date|json_encode};
	var comment = {$comment|json_encode};
	
        function init() {
            var data = {$programs};

            $(".program").select2({
                data: data
            });
			
			$( "#programmers" ).val(programmer);
			$( "#program" ).val(program);
			if (start_time != "0"){
				$( "#start_datetime" ).val(start_time);
			}
			if (duration != 0){
				$( "#episode_duration" ).val(duration);
			}
			if (prerecord == 1){
				$('#prerecord').prop('checked', true);
			}
			if (prerecord_date != "0"){
				$( "#prerecord_date" ).val(prerecord_date);
			}
			$( "#notes" ).val(comment);
			
			console.log(episodeId);
        }
		
		function saveDraft(){
		    var programmer = $( "#programmers" ).val();
			var program = $( "#program" ).find(":selected").val();
			var start_datetime = $( "#start_datetime" ).val();
			var episode_duration = $( "#episode_duration" ).val();
			if ($("#prerecord").is(':checked')){
				var prerecord = 1;
				var prerecord_date = $( "#prerecord_date" ).val();
			} else {
				var prerecord = 0;
				var prerecord_date = "NULL";
			}
			var notes = $( "#notes" ).val();
			
            if (window.XMLHttpRequest)
			  {
			  xmlhttp=new XMLHttpRequest();
			  }
			else
			  {
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			  }
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
					//document.getElementById("logsheets").innerHTML = xmlhttp_login.responseText;
					console.log(xmlhttp.responseText);
					console.log(episodeId);
			    }
			  }
			xmlhttp.open("GET","server_save_draft_episode_draft.php?programmer="+programmer+"&program="+program+"&notes="+notes+"&episodeId="+episodeId
			+"&start_datetime="+start_datetime+"&episode_duration="+episode_duration+"&prerecord="+prerecord+"&prerecord_date="+prerecord_date,true);
			xmlhttp.send();
			
		}
		
		function submitDraft(){
			window.location.href = "add-segments.php?episode_id="+episodeId;
		}
    </script>
</head>

<body onload="init()">
<div class="container-fluid">
    <h3>New Logsheet</h3>
    <form id="logsheet" role="form">
        <h4>Episode Metadata</h4>

        <div class="form-group row">
            <div class="col-md-6 col-sm-8">
                <label for="programmers" class="control-label">Programmer(s):</label>
                <input class="form-control" type="text" name="programmers" id="programmers" required oninput=saveDraft() onpropertychange=saveDraft()>
            </div>
        </div>

            <div id="program_group" class="form-group row">
                <div class="col-md-4 col-sm-6">
                    <label for="program" class="control-label">Program:</label>
                    <select class="form-control program" name="program" id="program" oninput=saveDraft() onpropertychange=saveDraft()>
                        {if isset($formSubmission.programName)}
                            <option value="{$formSubmission.programId}" selected="selected">{$formSubmission.programName}</option>
                        {/if}
                    </select>
                    <span id="program_help_block" class="help-block{if !$programError} hidden{/if}">
                        Please enter a program.
                    </span>
                </div>
            </div>
        <div class="form-group row">
            <div class="col-md-3 col-sm-5">
                <label for="start_datetime" class="control-label">Start Date/Time:</label>
                <input class="form-control" type="datetime-local" name="start_datetime" id="start_datetime" onchange="adjustPrerecordDateBounds()" required oninput=saveDraft() onpropertychange=saveDraft()>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2 col-sm-4">
                <label for="episode_duration" class="control-label">Duration (in hours):</label>
                <input class="form-control" type="number" step="0.5" min="0.5" max="6.0" name="episode_duration" id="episode_duration" required oninput=saveDraft() onpropertychange=saveDraft()>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2 col-sm-4">
                <label for="prerecord_date" id="prerecord_date_label" class="control-label">Prerecord Date:</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="checkbox" name="prerecord" id="prerecord" title="Was episode prerecorded?" aria-label="Was episode prerecorded?" oninput=saveDraft() onpropertychange=saveDraft()>
                    </span>
                    <input class="form-control" type="date" name="prerecord_date" id="prerecord_date" aria-label="Prerecord date" disabled oninput=saveDraft() onpropertychange=saveDraft()>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="notes" class="control-label">Notes:</label>
            <textarea class="form-control" name="notes" id="notes" oninput=saveDraft() onpropertychange=saveDraft()></textarea>
        </div>

        <input type="submit" value="Add Segments" onclick=submitDraft()>
    </form>
</div>
</body>
</html>