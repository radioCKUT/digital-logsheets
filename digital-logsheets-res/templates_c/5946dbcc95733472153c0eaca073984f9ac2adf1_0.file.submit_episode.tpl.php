<?php /* Smarty version 3.1.22-dev/21, created on 2015-07-23 07:51:43
         compiled from "/home/ubuntu/workspace/submit_episode.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:132880276455b09d0f9a0f84_28254521%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5946dbcc95733472153c0eaca073984f9ac2adf1' => 
    array (
      0 => '/home/ubuntu/workspace/submit_episode.tpl',
      1 => 1437637718,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '132880276455b09d0f9a0f84_28254521',
  'variables' => 
  array (
    'categories' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.22-dev/21',
  'unifunc' => 'content_55b09d0f9d4028_98324411',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55b09d0f9d4028_98324411')) {
function content_55b09d0f9d4028_98324411 ($_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once '/home/ubuntu/workspace/smarty/libs/plugins/function.html_options.php';
?>
<?php
$_smarty_tpl->properties['nocache_hash'] = '132880276455b09d0f9a0f84_28254521';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Submit a playlist</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        
        <!-- datetimepicker -->
        <link rel="stylesheet" href="/public_html/digital-logsheets/css/bootstrap-datetimepicker.css">
    </head>
    
    <body>
        <div class="container">
            <div class="jumbotron">
                <h1>CKUT Logsheets</h1>
                <p>Submit logsheet data below.</p>
            </div>
            
            <!--This needs to be dynamic-->
            <form id="logsheet" role="form" action="saveEpisode.php" method="POST">
                
                <div class="row">
                    <div class="col-md-4">   
                        <div class="form-group">
                            <label for="program">Program</label>
                            <input type="text"  id="program" class="form-control" placeholder="Title" name="program">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">   
                        <div class="form-group">
                            <label for="programmer">Programmer's Name</label>
                            <input type="text"  id="programmer" class="form-control" placeholder="First and Last name" name="programmer">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label><input type="checkbox">Pre-recorded</label>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="datetimepicker6">Time Started</label>
                            <div class='input-group date' id='datetimepicker6'>
                                <input type='text' class="form-control" name="start_time" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="datetimepicker7">Time Ended</label>
                            <div class='input-group date' id='datetimepicker7'>
                                <input type='text' class="form-control" name="end_time" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="comment">Did your show feature a theme, feature, interview, etc.?</label>
                            <textarea class="form-control" rows="3" id="comment"></textarea>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-md-1">
                        <input type='text' id='datetimepicker10' class="form-control" name="length[]" />
                    </div>
                    
                    <div class='col-md-2'>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Segment Title" name="name[]" />
                        </div>
                    </div>
                    
                    <div class='col-md-2'>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Artist/Author" name="author[]" />
                        </div>
                    </div>
                    
                    <div class='col-md-2'>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Album" name="album[]" />
                        </div>
                    </div>
                    
                    <div class='col-md-2'>
                        <div class="form-group category-select">
                            <?php echo smarty_function_html_options(array('class'=>"form-control",'name'=>"category[]",'options'=>$_smarty_tpl->tpl_vars['categories']->value),$_smarty_tpl);?>

                        </div>
                    </div>
                    
                    <div class='col-md-3 form-inline'>    
                        <div class="checkbox">
                            <label><input type="checkbox" name="can_con">CanCon</label>
                        </div>    
                        <div class="checkbox">
                            <label><input type="checkbox" name="new_release">New</label>
                        </div>    
                        <div class="checkbox">
                            <label><input type="checkbox" name="french_vocal_music">French</label>
                        </div>    
                        <div class="checkbox">
                            <label><input type="checkbox" name="request">Request</label>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class='col-md-11'>
                    </div>
                    <div class='col-md-1'>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
  
            </form>
            
        </div>

        <!-- jQuery -->
        <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"><?php echo '</script'; ?>
>
        
        <!-- Bootstrap -->
        <?php echo '<script'; ?>
 src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"><?php echo '</script'; ?>
>
        
        <!-- Javascript libraries for datetimepicker -->
        <?php echo '<script'; ?>
 src="js/moment.min.js"><?php echo '</script'; ?>
> <!-- moment.js -->
        <?php echo '<script'; ?>
 src="js/bootstrap-datetimepicker.js"><?php echo '</script'; ?>
> <!-- datetimepicker -->
        
        <?php echo '<script'; ?>
 type="text/javascript">
            $(function () {
                $('#datetimepicker6').datetimepicker();
                $('#datetimepicker7').datetimepicker();
                $("#datetimepicker6").on("dp.change", function (e) {
                    $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
                });
                $("#datetimepicker7").on("dp.change", function (e) {
                    $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
                });
            });
        <?php echo '</script'; ?>
>
        
        
        <?php echo '<script'; ?>
 type="text/javascript">
            $(function () {
                $('#datetimepicker10').datetimepicker({
                    viewMode: 'years',
                    format: 'MM/YYYY'
                });
            });
        <?php echo '</script'; ?>
>
        
    </body>
</html><?php }
}
?>