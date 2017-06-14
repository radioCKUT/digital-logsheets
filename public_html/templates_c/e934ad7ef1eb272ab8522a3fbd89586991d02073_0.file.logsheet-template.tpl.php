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
 */ /* Smarty version 3.1.27, created on 2017-06-06 17:40:53
         compiled from "/var/www/digital-logsheets-res/templates/logsheet-template.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:52996325936e925e017d3_45131476%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e934ad7ef1eb272ab8522a3fbd89586991d02073' => 
    array (
      0 => '/var/www/digital-logsheets-res/templates/logsheet-template.tpl',
      1 => 1496681233,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '52996325936e925e017d3_45131476',
  'variables' => 
  array (
    'episode' => 0,
    'segments' => 0,
    'segment' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5936e92609b995_27348983',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5936e92609b995_27348983')) {
function content_5936e92609b995_27348983 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '52996325936e925e017d3_45131476';
?>
Show Name: <?php echo $_smarty_tpl->tpl_vars['episode']->value['program'];?>
 <br/>
Programmer(s): <br/>
Day and Date: <?php echo $_smarty_tpl->tpl_vars['episode']->value['startDate'];?>
 <br/>
Time Started: <?php echo $_smarty_tpl->tpl_vars['episode']->value['startTime'];?>
  Time Ended: <?php echo $_smarty_tpl->tpl_vars['episode']->value['endTime'];?>
 <br/>
Pre-recorded? <?php echo $_smarty_tpl->tpl_vars['episode']->value['prerecorded'];?>
  Date? <?php echo $_smarty_tpl->tpl_vars['episode']->value['prerecordDate'];?>
 <br/> <br/>


<table class="table">
    <tr>
        <th>Time</th>
        <th>Duration</th>
        <th colspan="3">Description of music (artist, album, song); spoken word, or ads/promotion</th>
        <th>Category</th>
        <th>CC</th>
        <th>NR</th>
        <th>FR</th>
    </tr>

    <?php
$_from = $_smarty_tpl->tpl_vars['segments']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['segment'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['segment']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['segment']->value) {
$_smarty_tpl->tpl_vars['segment']->_loop = true;
$foreach_segment_Sav = $_smarty_tpl->tpl_vars['segment'];
?>
        <tr>
            <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['startTime'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['duration'];?>
</td>


            <?php if ($_smarty_tpl->tpl_vars['segment']->value['category'] == 2 || $_smarty_tpl->tpl_vars['segment']->value['category'] == 3) {?>
                <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['name'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['album'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['artist'];?>
</td>
            <?php } elseif ($_smarty_tpl->tpl_vars['segment']->value['category'] == 5) {?>
                <td colspan="3"><?php echo $_smarty_tpl->tpl_vars['segment']->value['adNumber'];?>
</td>
            <?php } else { ?>
                <td colspan="3"><?php echo $_smarty_tpl->tpl_vars['segment']->value['name'];?>
</td>
            <?php }?>

            <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['category'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['canCon'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['newRelease'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['segment']->value['frenchVocalMusic'];?>
</td>
        </tr>
    <?php
$_smarty_tpl->tpl_vars['segment'] = $foreach_segment_Sav;
}
?>
</table><?php }
}
?>