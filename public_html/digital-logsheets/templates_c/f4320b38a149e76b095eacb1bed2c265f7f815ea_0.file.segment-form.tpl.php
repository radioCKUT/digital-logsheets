<?php /* Smarty version 3.1.27, created on 2016-11-03 12:32:46
         compiled from "C:\xampp\digital-logsheets-res\templates\segment-form.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:2572581b205e6b74b3_15139767%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f4320b38a149e76b095eacb1bed2c265f7f815ea' => 
    array (
      0 => 'C:\\xampp\\digital-logsheets-res\\templates\\segment-form.tpl',
      1 => 1478172761,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2572581b205e6b74b3_15139767',
  'variables' => 
  array (
    'idSuffix' => 0,
    'episode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_581b205e74d5d2_01813794',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_581b205e74d5d2_01813794')) {
function content_581b205e74d5d2_01813794 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '2572581b205e6b74b3_15139767';
?>
<form id="logsheet<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" role="form" method="post" data-toggle="validator">
    <h5>Episode ID: <?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
</h5>

    <div id="segments">
        <div class="form-group row">
            <div class="col-md-3">
                <label for="segment_time<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="control-label">Time:</label>
                <input name="segment_time" class="form-control segment-time"
                       data-remote="validation/segment-time.php"
                       data-error="Segment start time must fall within episode start and end times"
                       type="time" id="segment_time<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" required onkeyup=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
) oninput=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
) onpropertychange=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
)>
            </div>
        </div>
        <div class="form-group">
            <label for="category" class="control-label">Category:</label>
            <div class="btn-group category" data-toggle="buttons">
                <label class="btn btn-primary" onclick="setupCat1Fields()">
                    <input type="radio" name="category" class="category1" autocomplete="off" required value="1">1</label>
                <label class="btn btn-primary" onclick="setupCat2Fields()">
                    <input type="radio" name="category" class="category2" autocomplete="off" value="2">2</label>
                <label class="btn btn-primary" onclick="setupCat3Fields()">
                    <input type="radio" name="category" class="category3" autocomplete="off" value="3">3</label>
                <label class="btn btn-primary" onclick="setupCat4Fields()">
                    <input type="radio" name="category" class="category4" autocomplete="off" value="4">4</label>
                <label class="btn btn-primary" onclick="setupCat5Fields()">
                    <input type="radio" name="category" class="category5" autocomplete="off" value="5">5</label></div>
        </div>
        <div class="form-group row ad_number_group" style="display:none;">
            <div class="col-md-3">
                <label for="ad_number_input<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="control-label ad_number_label">Ad Number:</label>
                <input class="form-control" type="number" min="1" step="1" max="300" name="ad_number" id="ad_number_input<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" onkeyup=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
) oninput=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
) onpropertychange=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
)>
            </div>
        </div>
        <div class="form-group row name_group" style="display:none;">
            <div class="col-md-9">
                <label for="name_input<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="control-label name_label">Name:</label>
                <input class="form-control name_input" type="text" name="name" id="name_input<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" required onkeyup=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
) oninput=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
) onpropertychange=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
)>
            </div>
        </div>
        <div class="form-group row author_group" style="display:none;">
            <div class="col-md-9">
                <label for="author_input<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="control-label">Author:</label>
                <input class="form-control author_input" type="text" name="author" id="author_input<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" onkeyup=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
) oninput=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
) onpropertychange=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
)>
            </div>
        </div>
        <div class="form-group row album_group" style="display:none;">
            <div class="col-md-9">
                <label for="album_input<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="control-label">Album:</label>
                <input class="form-control album_input" type="text" name="album" id="album_input<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" onkeyup=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
) oninput=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
) onpropertychange=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
)>
            </div>
        </div>
        <label class="checkbox-inline can_con_group" style="display:none;">
            <input type="checkbox" name="can_con" value="" id="can_con<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" onkeyup=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
) oninput=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
) onpropertychange=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
)>CC</label>
        <label class="checkbox-inline new_release_group" style="display:none;">
            <input type="checkbox" name="new_release" value="" id="new_release<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" onkeyup=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
) oninput=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
) onpropertychange=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
)>NR</label>
        <label class="checkbox-inline french_vocal_music_group" style="display:none;">
            <input type="checkbox" name="french_vocal_music" value="" id="french_vocal_music<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" onkeyup=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
) oninput=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
) onpropertychange=saveDraft(<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
)>FV</label>

        <input type="hidden" name="episode_id" value=<?php echo json_encode($_smarty_tpl->tpl_vars['episode']->value['id']);?>
>
        <hr>
    </div>

    <?php if ($_smarty_tpl->tpl_vars['idSuffix']->value == '_edit') {?>
        <input type="hidden" name="segment_id" id="segment_id<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
">
        <input type="hidden" name="is_segment<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" id="is_segment<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
">
        <input type="button" name="cancel" value="Cancel" onclick="cancelEdit()">
        <input type="submit" name="save" value="Save">
    <?php } else { ?>
        <input type="submit" value="Add">
    <?php }?>

</form><?php }
}
?>