<?php /* Smarty version 3.1.27, created on 2016-10-27 17:48:06
         compiled from "C:\xampp\digital-logsheets-res\templates\index2.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:8992581221b675b4b6_12047298%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bfa9aaa59f39bef13d69b53fad09ffe369b6d524' => 
    array (
      0 => 'C:\\xampp\\digital-logsheets-res\\templates\\index2.tpl',
      1 => 1477583277,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8992581221b675b4b6_12047298',
  'variables' => 
  array (
    'episodes' => 0,
    'episode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_581221b69bc384_77269363',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_581221b69bc384_77269363')) {
function content_581221b69bc384_77269363 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '8992581221b675b4b6_12047298';
?>
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
    <?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-1.11.3.min.js"><?php echo '</script'; ?>
>

    <!-- Boostrap JS -->
    <?php echo '<script'; ?>
 src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"><?php echo '</script'; ?>
>

    <!-- Select2 -->
    <?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"><?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
 src="js/filterLogsheetList.js"><?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"><?php echo '</script'; ?>
>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

    <?php echo '<script'; ?>
 type="text/javascript">

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

    <?php echo '</script'; ?>
>
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
        <?php
$_from = $_smarty_tpl->tpl_vars['episodes']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['episode'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['episode']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['episode']->value) {
$_smarty_tpl->tpl_vars['episode']->_loop = true;
$foreach_episode_Sav = $_smarty_tpl->tpl_vars['episode'];
?>
		<tr>
            <td><a href="view-episode-segment.php?episode_id=<?php echo $_smarty_tpl->tpl_vars['episode']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['episode']->value['program'];?>
 - <?php echo $_smarty_tpl->tpl_vars['episode']->value['startDate'];?>
</a></td>
		</tr>
        <?php
$_smarty_tpl->tpl_vars['episode'] = $foreach_episode_Sav;
}
?>
	</table>
    </div>
</div>


</body>
</html>
    <?php }
}
?>