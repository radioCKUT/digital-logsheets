/*
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
 */


function markEpisodeStartDatetimeCorrect(group, helpBlock) {
    var datetimeMissingMessage = $('#missing_start_time_message');
    datetimeMissingMessage.hide();

    var tooFarInPastMessage = $('#air_date_too_far_in_past_message');
    tooFarInPastMessage.hide();

    var tooFarInFutureMessage = $('#air_date_too_far_in_future_message');
    tooFarInFutureMessage.hide();

    markFieldCorrect(group, helpBlock);
}

function markEpisodeStartDatetimeMissing(group, helpBlock) {
    var datetimeMissingMessage = $('#missing_start_time_message');
    datetimeMissingMessage.show();

    var tooFarInPastMessage = $('#air_date_too_far_in_past_message');
    tooFarInPastMessage.hide();

    var tooFarInFutureMessage = $('#air_date_too_far_in_future_message');
    tooFarInFutureMessage.hide();

    markFieldError(group, helpBlock);
}

function markEpisodeStartDatetimeTooFarInPast(group, helpBlock) {
    var datetimeMissingMessage = $('#missing_start_time_message');
    datetimeMissingMessage.hide();

    var tooFarInPastMessage = $('#air_date_too_far_in_past_message');
    tooFarInPastMessage.show();

    var tooFarInFutureMessage = $('#air_date_too_far_in_future_message');
    tooFarInFutureMessage.hide();

    markFieldError(group, helpBlock);
}

function markEpisodeStartDatetimeTooFarInFuture(group, helpBlock) {
    var datetimeMissingMessage = $('#missing_start_time_message');
    datetimeMissingMessage.hide();

    var tooFarInPastMessage = $('#air_date_too_far_in_past_message');
    tooFarInPastMessage.hide();

    var tooFarInFutureMessage = $('#air_date_too_far_in_future_message');
    tooFarInFutureMessage.show();

    markFieldError(group, helpBlock);
}

function markEndDateTimeCorrect(group, helpBlock) {
    var durationMissingMessage = $('#missing_end_datetime_message');
    durationMissingMessage.hide();

    var tooShortMessage = $('#too_short_message');
    tooShortMessage.hide();

    var tooLongMessage = $('#too_long_message');
    tooLongMessage.hide();

    markFieldCorrect(group, helpBlock);
}

function markEndDateTimeMissing(group, helpBlock) {
    var durationMissingMessage = $('#missing_end_datetime_message');
    durationMissingMessage.show();

    var tooShortMessage = $('#too_short_message');
    tooShortMessage.hide();

    var tooLongMessage = $('#too_long_message');
    tooLongMessage.hide();

    markFieldError(group, helpBlock);
}

function markEpisodeDurationTooShort(group, helpBlock) {
    var durationMissingMessage = $('#missing_end_datetime_message');
    durationMissingMessage.hide();

    var tooShortMessage = $('#too_short_message');
    tooShortMessage.show();

    var tooLongMessage = $('#too_long_message');
    tooLongMessage.hide();

    markFieldError(group, helpBlock);
}

function markEpisodeDurationTooLong(group, helpBlock) {
    var durationMissingMessage = $('#missing_end_datetime_message');
    durationMissingMessage.hide();

    var tooShortMessage = $('#too_short_message');
    tooShortMessage.hide();

    var tooLongMessage = $('#too_long_message');
    tooLongMessage.show();

    markFieldError(group, helpBlock);
}

function markPrerecordDateCorrect(group, helpBlock) {
    var prerecordDateMissingMessage = $('#missing_prerecord_date_message');
    prerecordDateMissingMessage.hide();

    var tooFarInPastMessage = $('#prerecord_date_too_far_in_past_message');
    tooFarInPastMessage.hide();

    var tooFarInFutureMessage = $('#prerecord_date_too_far_in_future_message');
    tooFarInFutureMessage.hide();

    markFieldCorrect(group, helpBlock);
}

function markPrerecordDateMissing(group, helpBlock) {
    var prerecordDateMissingMessage = $('#missing_prerecord_date_message');
    prerecordDateMissingMessage.show();

    var tooFarInPastMessage = $('#prerecord_date_too_far_in_past_message');
    tooFarInPastMessage.hide();

    var tooFarInFutureMessage = $('#prerecord_date_too_far_in_future_message');
    tooFarInFutureMessage.hide();

    markFieldError(group, helpBlock);
}

function markPrerecordDateTooFarInPast(group, helpBlock) {
    var prerecordDateMissingMessage = $('#missing_prerecord_date_message');
    prerecordDateMissingMessage.hide();

    var tooFarInPastMessage = $('#prerecord_date_too_far_in_past_message');
    tooFarInPastMessage.show();

    var tooFarInFutureMessage = $('#prerecord_date_too_far_in_future_message');
    tooFarInFutureMessage.hide();

    markFieldError(group, helpBlock);
}

function markPrerecordDateTooFarInFuture(group, helpBlock) {
    var prerecordDateMissingMessage = $('#missing_prerecord_date_message');
    prerecordDateMissingMessage.hide();

    var tooFarInPastMessage = $('#prerecord_date_too_far_in_past_message');
    tooFarInPastMessage.hide();

    var tooFarInFutureMessage = $('#prerecord_date_too_far_in_future_message');
    tooFarInFutureMessage.show();

    markFieldError(group, helpBlock);
}

function markFirstSegmentNotAtEpisodeStart() {
    $('#start_time_column').addClass('red');
    $('#playlist_not_aligned_help_text').show();
}

function markFirstSegmentAtEpisodeStart() {
    $('#start_time_column').removeClass('red');
    $('#playlist_not_aligned_help_text').hide();
}




function markErroneousSegmentsExist() {
    console.error('in mark Erroneous');
    $('#segment_errors_exist_help_text').show();
}

function markNoErroneousSegmentsExist() {
    $('#segment_errors_exist_help_text').hide();
}





function markFieldError(formGroup, helpBlock) {
    formGroup.addClass("has-error");
    helpBlock.show();
}

function markFieldCorrect(formGroup, helpBlock) {
    formGroup.removeClass("has-error");
    helpBlock.hide();
}