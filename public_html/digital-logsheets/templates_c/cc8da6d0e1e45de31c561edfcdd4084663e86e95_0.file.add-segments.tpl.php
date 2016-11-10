<?php /* Smarty version 3.1.27, created on 2016-11-04 12:30:37
         compiled from "C:\xampp\digital-logsheets-res\templates\add-segments.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:3820581c715da149c2_98009420%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cc8da6d0e1e45de31c561edfcdd4084663e86e95' => 
    array (
      0 => 'C:\\xampp\\digital-logsheets-res\\templates\\add-segments.tpl',
      1 => 1478246539,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3820581c715da149c2_98009420',
  'variables' => 
  array (
    'episode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_581c715da769d8_49129965',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_581c715da769d8_49129965')) {
function content_581c715da769d8_49129965 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '3820581c715da149c2_98009420';
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
    <link href="css/custom.css" rel="stylesheet">

    <!-- jQuery -->
    <?php echo '<script'; ?>
 type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"><?php echo '</script'; ?>
>

    <!-- Boostrap JS -->
    <?php echo '<script'; ?>
 type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"><?php echo '</script'; ?>
>


    <?php echo '<script'; ?>
 type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/htmlValidation/segmentValidation.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/deleteSegment.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/editSegment.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/ui/segmentOptionsMenu.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/saveReceiveSegments.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/ui/categoryButton.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/lib/sisyphus.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/lib/validator.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript">
        function startStoringFormEntries() {
            $('#logsheet').on('submit', function(e) {
                e.preventDefault();
                createSegment();
            });

            var logsheetEdit = $('#logsheet_edit');

            logsheetEdit.on('submit', function(e) {
                e.preventDefault();
                editEpisodeSegment();
            });

            getEpisodeSegments();
            logsheetEdit.hide();
            $('form').sisyphus();
        }
		
		function saveDraft(episode_id){
		    var segment_time = $( "#segment_time" ).val();
			var ad_number_input = $( "#ad_number_input" ).val();
			var name_input = $( "#name_input" ).val();
			var author_input = $( "#author_input" ).val();
			var album_input = $( "#album_input" ).val();
			var can_con = $( "#can_con" ).val();
			var new_release = $( "#new_release" ).val();
			var french_vocal_music = $( "#french_vocal_music" ).val();
			
			var category = document.getElementsByName('category');
			var category_value;
			for(var i = 0; i < category.length; i++){
				if(category[i].checked){
					category_value = category[i].value;
				}
			}
                
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
					//document.getElementById("logsheets").innerHTML = xmlhttp.responseText;
					console.log(xmlhttp.responseText);
			    }
			  }
			xmlhttp.open("GET","server_save_draft_segment.php?segment_time="+segment_time+"&ad_number_input="+ad_number_input
			+"&name_input="+name_input+"&author_input="+author_input+"&album_input="+album_input+"&can_con="+can_con
			+"&new_release="+new_release+"&french_vocal_music="+french_vocal_music+"&category_value="+category_value+"&episode_id="+episode_id,true);
			xmlhttp.send();
			
		}
    <?php echo '</script'; ?>
>
</head>
<body onload="startStoringFormEntries()">
<div class="container-fluid">
    <div class="col-md-8">
        <h3>Add Segments</h3>
        <?php echo $_smarty_tpl->getSubTemplate ('../../digital-logsheets-res/templates/segment-form.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('idSuffix'=>''), 0);
?>

        <?php echo $_smarty_tpl->getSubTemplate ('../../digital-logsheets-res/templates/segment-form.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('idSuffix'=>'_edit'), 0);
?>


        <form id="finalize" role="form" action="review-logsheet.php" method="post" onsubmit="">
            <input type="hidden" name="episode_id" value=<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
>
            <input type="submit" value="Submit All">
        </form>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">Episode Segments</div>

            <!-- Table -->
            <table class="table table-hover" id="added_segments">
            </table>
        </div>
    </div>
</div>
</body>
</html><?php }
}
?>