/*
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2016  Evan Vassallo
 * Copyright (C) 2016  James Wang
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
 */

const SEGMENT_NOT_IN_EPISODE_ERROR_MSG = "Segment must fall within episode.";
const SEGMENT_TIME_HELP_BLOCK_ID = "segment_time_help_block";

function markSegmentTimeIncorrect() {
    var segmentTimeFormGroup = $('.time_group');
    markFieldError(segmentTimeFormGroup, SEGMENT_TIME_HELP_BLOCK_ID, SEGMENT_NOT_IN_EPISODE_ERROR_MSG)
}

function markSegmentTimeCorrect() {
    var segmentTimeFormGroup = $('.time_group');
    markFieldCorrect(segmentTimeFormGroup, SEGMENT_TIME_HELP_BLOCK_ID);
}

function markFirstSegmentNotAtEpisodeStart() {
    $('#start_time_column').addClass('red');
    $('#playlist_not_aligned_help_text').removeClass('hidden');
}

function markFirstSegmentAtEpisodeStart() {
    $('#start_time_column').removeClass('red');
    $('#playlist_not_aligned_help_text').addClass('hidden');
}





function markFieldError(formGroup, helpBlockId, message) {
    formGroup.addClass("has-error");
    if ($('#' + helpBlockId).length === 0) {
        formGroup.append('<span id="' + helpBlockId + '" class="help-block">' + message + '</span>');
    }
}

function markFieldCorrect(formGroup, helpBlockId) {
    formGroup.removeClass("has-error");
    $('#' + helpBlockId).remove();
}