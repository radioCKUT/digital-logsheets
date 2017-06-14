<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2017  Evan Vassallo
 * Copyright (C) 2017 Donghee Baik
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */ /* Smarty version 3.1.27, created on 2017-06-05 16:38:50
         compiled from "/var/www/digital-logsheets-res/templates/segment-form.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:13275716535935891a2bb161_50666582%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '78750a42e17257c600dd317d6650fe6a1821512f' => 
    array (
      0 => '/var/www/digital-logsheets-res/templates/segment-form.tpl',
      1 => 1496673762,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13275716535935891a2bb161_50666582',
  'variables' => 
  array (
    'idSuffix' => 0,
    'episode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5935891a36e920_34272168',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5935891a36e920_34272168')) {
function content_5935891a36e920_34272168 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '13275716535935891a2bb161_50666582';
?>
<form id="logsheet<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" role="form" method="post" data-toggle="validator" novalidate>

    <div id="segments">
        <div id="time_group<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="form-group row time_group">
            <div class="col-md-3">
                <label for="segment_time<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="control-label">Time:</label>
                <input name="segment_time" class="form-control segment_time"
                       type="time" id="segment_time<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
">
                <span id="segment_time_out_of_bounds_help_text<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="segment_time_help_text help-block hidden">
                    Segment must fall within episode.
                </span>
                <span id="missing_segment_time_help_block<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="help-block hidden">
                    Please enter a segment time.
                </span>
            </div>
        </div>

        <div id="category_group<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="form-group category_group">
            <label for="category" class="control-label">Category:</label>
            <div class="btn-group" class="category" id="category" data-toggle="buttons"> 
                <label class="btn btn-primary"
                       onclick="setupCat1Fields(<?php if ($_smarty_tpl->tpl_vars['idSuffix']->value == '_edit') {?> true <?php } else { ?> false <?php }?>)"
                       data-toggle="tooltip" data-placement="bottom"
                       title="All Spoken Word">
                    <input type="radio" name="category" class="category1" autocomplete="off" required value="1">1
                </label>

                <label class="btn btn-primary"
                       onclick="setupCat2Fields(<?php if ($_smarty_tpl->tpl_vars['idSuffix']->value == '_edit') {?> true <?php } else { ?> false <?php }?>)"
                       data-toggle="tooltip" data-placement="bottom"
                       title="General Music">
                    <input type="radio" name="category" class="category2" autocomplete="off" value="2">2
                </label>

                <label class="btn btn-primary"
                       onclick="setupCat3Fields(<?php if ($_smarty_tpl->tpl_vars['idSuffix']->value == '_edit') {?> true <?php } else { ?> false <?php }?>)"
                       data-toggle="tooltip" data-placement="bottom"
                       title="Jazz, Classical, and Traditional Music">
                    <input type="radio" name="category" class="category3" autocomplete="off" value="3">3
                </label>

                <label class="btn btn-primary"
                       onclick="setupCat4Fields(<?php if ($_smarty_tpl->tpl_vars['idSuffix']->value == '_edit') {?> true <?php } else { ?> false <?php }?>)"
                       data-toggle="tooltip" data-placement="bottom"
                       title="Musical Productions (ID's, etc.)">
                    <input type="radio" name="category" class="category4" autocomplete="off" value="4">4
                </label>

                <label class="btn btn-primary"
                       onclick="setupCat5Fields(<?php if ($_smarty_tpl->tpl_vars['idSuffix']->value == '_edit') {?> true <?php } else { ?> false <?php }?>)"
                       data-toggle="tooltip"  data-placement="bottom"
                       title="Ads, Promos">
                    <input type="radio" name="category" class="category5" autocomplete="off" value="5">5
                </label>

                <span id="category_help_block<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="help-block hidden">
                    Please select a category.
                </span>
            </div>
        </div>

        <div id="ad_number_group<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="form-group row ad_number_group" style="display:none;">
            <div class="col-md-3">
                <label for="ad_number_input<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="control-label ad_number_label">Ad Number:</label>
                <input class="form-control" type="number" min="1" step="1" max="300" name="ad_number" id="ad_number_input<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
">

                <span id="ad_number_help_block<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="help-block hidden">
                    Please enter a valid ad number.
                </span>
            </div>
        </div>

        <div id="name_group<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="form-group row name_group" style="display:none;">
            <div class="col-md-9">
                <label for="name_input<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="control-label name_label">Title:</label>
                <input class="form-control name_input" type="text" name="name" id="name_input<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
">

                <span id="name_help_block<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="help-block hidden">
                    Please enter a name.
                </span>
            </div>
        </div>

        <label class="checkbox-inline station_id_group" style="display:none;">
            <input type="checkbox" name="station_id" value="" id="station_id<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
">Station ID Given</label>

        <div id="author_group<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="form-group row author_group" style="display:none;">
            <div class="col-md-9">
                <label for="author_input<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="control-label">Artist:</label>
                <input class="form-control author_input" type="text" name="author" id="author_input<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
">

                <span id="author_help_block<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="help-block hidden">
                    Please enter an author.
                </span>
            </div>
        </div>

        <div id="album_group<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="form-group row album_group" style="display:none;">
            <div class="col-md-9">
                <label for="album_input<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="control-label">Album:</label>
                <input class="form-control album_input" type="text" name="album" id="album_input<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
">

                <span id="album_help_block<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
" class="help-block hidden">
                    Please enter an album.
                </span>
            </div>
        </div>

        <label class="checkbox-inline can_con_group" style="display:none;">
            <input type="checkbox" name="can_con" value="" id="can_con<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
">CC</label>
        <label class="checkbox-inline new_release_group" style="display:none;">
            <input type="checkbox" name="new_release" value="" id="new_release<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
">NR</label>
        <label class="checkbox-inline french_vocal_music_group" style="display:none;">
            <input type="checkbox" name="french_vocal_music" value="" id="french_vocal_music<?php echo $_smarty_tpl->tpl_vars['idSuffix']->value;?>
">FV</label>

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