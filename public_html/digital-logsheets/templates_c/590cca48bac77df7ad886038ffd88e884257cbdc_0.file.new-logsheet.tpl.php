<?php /* Smarty version 3.1.27, created on 2016-11-07 00:18:59
         compiled from "C:\xampp\digital-logsheets-res\templates\new-logsheet.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:5494581fba639e5898_88185772%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '590cca48bac77df7ad886038ffd88e884257cbdc' => 
    array (
      0 => 'C:\\xampp\\digital-logsheets-res\\templates\\new-logsheet.tpl',
      1 => 1478473940,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5494581fba639e5898_88185772',
  'variables' => 
  array (
    'programs' => 0,
    'formSubmission' => 0,
    'programError' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_581fba63a4bf72_62395621',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_581fba63a4bf72_62395621')) {
function content_581fba63a4bf72_62395621 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '5494581fba639e5898_88185772';
?>
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
    <?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-1.11.3.min.js"><?php echo '</script'; ?>
>

    <!-- Boostrap JS -->
    <?php echo '<script'; ?>
 src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"><?php echo '</script'; ?>
>

    <!-- Select2 -->
    <?php echo '<script'; ?>
 src="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"><?php echo '</script'; ?>
>


    <?php echo '<script'; ?>
 type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="js/htmlValidation/episodeValidation.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="js/ui/prerecord.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="js/ui/categoryButton.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript">
	var episodeId =0;
	
        function init() {
            var data = <?php echo $_smarty_tpl->tpl_vars['programs']->value;?>
;

            $(".program").select2({
                data: data
            });
        }
		
		var same_episode = 0;
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
			//console.log(same_episode);
			
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
					episodeId = xmlhttp.responseText;
					if (same_episode == 0){
						same_episode++;
					}
			    }
			  }
			xmlhttp.open("GET","server_save_draft_episode.php?programmer="+programmer+"&program="+program+"&notes="+notes+"&same_episode="+same_episode
			+"&start_datetime="+start_datetime+"&episode_duration="+episode_duration+"&prerecord="+prerecord+"&prerecord_date="+prerecord_date,true);
			xmlhttp.send();
		}
		
		function submitDraft(){
			window.location.href = "add-segments.php?episode_id="+episodeId;
		}
    <?php echo '</script'; ?>
>
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
                        <?php if (isset($_smarty_tpl->tpl_vars['formSubmission']->value['programName'])) {?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['formSubmission']->value['programId'];?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['formSubmission']->value['programName'];?>
</option>
                        <?php }?>
                    </select>
                    <span id="program_help_block" class="help-block<?php if (!$_smarty_tpl->tpl_vars['programError']->value) {?> hidden<?php }?>">
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
</html><?php }
}
?>