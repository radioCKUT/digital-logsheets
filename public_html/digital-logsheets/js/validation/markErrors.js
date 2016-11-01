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


function markEpisodeStartDatetimeCorrect(group, helpBlock) {
    var datetimeMissingMessage = $('#missing_start_time_message');
    datetimeMissingMessage.addClass("hidden");

    var tooFarInPastMessage = $('#air_date_too_far_in_past_message');
    tooFarInPastMessage.addClass("hidden");

    var tooFarInFutureMessage = $('#air_date_too_far_in_future_message');
    tooFarInFutureMessage.addClass("hidden");

    markFieldCorrect(group, helpBlock);
}

function markEpisodeStartDatetimeMissing(group, helpBlock) {
    var datetimeMissingMessage = $('#missing_start_time_message');
    datetimeMissingMessage.removeClass("hidden");

    var tooFarInPastMessage = $('#air_date_too_far_in_past_message');
    tooFarInPastMessage.addClass("hidden");

    var tooFarInFutureMessage = $('#air_date_too_far_in_future_message');
    tooFarInFutureMessage.addClass("hidden");

    markFieldError(group, helpBlock);
}

function markEpisodeStartDatetimeTooFarInPast(group, helpBlock) {
    var datetimeMissingMessage = $('#missing_start_time_message');
    datetimeMissingMessage.addClass("hidden");

    var tooFarInPastMessage = $('#air_date_too_far_in_past_message');
    tooFarInPastMessage.removeClass("hidden");

    var tooFarInFutureMessage = $('#air_date_too_far_in_future_message');
    tooFarInFutureMessage.addClass("hidden");

    markFieldError(group, helpBlock);
}

function markEpisodeStartDatetimeTooFarInFuture(group, helpBlock) {
    var datetimeMissingMessage = $('#missing_start_time_message');
    datetimeMissingMessage.addClass("hidden");

    var tooFarInPastMessage = $('#air_date_too_far_in_past_message');
    tooFarInPastMessage.addClass("hidden");

    var tooFarInFutureMessage = $('#air_date_too_far_in_future_message');
    tooFarInFutureMessage.removeClass("hidden");

    markFieldError(group, helpBlock);
}

function markEpisodeDurationCorrect(group, helpBlock) {
    var durationMissingMessage = $('#missing_duration_message');
    durationMissingMessage.addClass("hidden");

    var tooShortMessage = $('#too_short_message');
    tooShortMessage.addClass("hidden");

    var tooLongMessage = $('#too_long_message');
    tooLongMessage.addClass("hidden");

    markFieldCorrect(group, helpBlock);
}

function markEpisodeDurationMissing(group, helpBlock) {
    var durationMissingMessage = $('#missing_duration_message');
    durationMissingMessage.removeClass("hidden");

    var tooShortMessage = $('#too_short_message');
    tooShortMessage.addClass("hidden");

    var tooLongMessage = $('#too_long_message');
    tooLongMessage.addClass("hidden");

    markFieldError(group, helpBlock);
}

function markEpisodeDurationTooShort(group, helpBlock) {
    var durationMissingMessage = $('#missing_duration_message');
    durationMissingMessage.addClass("hidden");

    var tooShortMessage = $('#too_short_message');
    tooShortMessage.removeClass("hidden");

    var tooLongMessage = $('#too_long_message');
    tooLongMessage.addClass("hidden");

    markFieldError(group, helpBlock);
}

function markEpisodeDurationTooLong(group, helpBlock) {
    var durationMissingMessage = $('#missing_duration_message');
    durationMissingMessage.addClass("hidden");

    var tooShortMessage = $('#too_short_message');
    tooShortMessage.addClass("hidden");

    var tooLongMessage = $('#too_long_message');
    tooLongMessage.removeClass("hidden");

    markFieldError(group, helpBlock);
}

function markPrerecordDateCorrect(group, helpBlock) {
    var prerecordDateMissingMessage = $('#missing_prerecord_date_message');
    prerecordDateMissingMessage.addClass("hidden");

    var tooFarInPastMessage = $('#prerecord_date_too_far_in_past_message');
    tooFarInPastMessage.addClass("hidden");

    var tooFarInFutureMessage = $('#prerecord_date_too_far_in_future_message');
    tooFarInFutureMessage.addClass("hidden");

    markFieldCorrect(group, helpBlock);
}

function markPrerecordDateMissing(group, helpBlock) {
    var prerecordDateMissingMessage = $('#missing_prerecord_date_message');
    prerecordDateMissingMessage.removeClass("hidden");

    var tooFarInPastMessage = $('#prerecord_date_too_far_in_past_message');
    tooFarInPastMessage.addClass("hidden");

    var tooFarInFutureMessage = $('#prerecord_date_too_far_in_future_message');
    tooFarInFutureMessage.addClass("hidden");

    markFieldError(group, helpBlock);
}

function markPrerecordDateTooFarInPast(group, helpBlock) {
    var prerecordDateMissingMessage = $('#missing_prerecord_date_message');
    prerecordDateMissingMessage.addClass("hidden");

    var tooFarInPastMessage = $('#prerecord_date_too_far_in_past_message');
    tooFarInPastMessage.removeClass("hidden");

    var tooFarInFutureMessage = $('#prerecord_date_too_far_in_future_message');
    tooFarInFutureMessage.addClass("hidden");

    markFieldError(group, helpBlock);
}

function markPrerecordDateTooFarInFuture(group, helpBlock) {
    var prerecordDateMissingMessage = $('#missing_prerecord_date_message');
    prerecordDateMissingMessage.addClass("hidden");

    var tooFarInPastMessage = $('#prerecord_date_too_far_in_past_message');
    tooFarInPastMessage.addClass("hidden");

    var tooFarInFutureMessage = $('#prerecord_date_too_far_in_future_message');
    tooFarInFutureMessage.removeClass("hidden");

    markFieldError(group, helpBlock);
}

function markFirstSegmentNotAtEpisodeStart() {
    $('#start_time_column').addClass('red');
    $('#playlist_not_aligned_help_text').removeClass('hidden');
}

function markFirstSegmentAtEpisodeStart() {
    $('#start_time_column').removeClass('red');
    $('#playlist_not_aligned_help_text').addClass('hidden');
}





function markFieldError(formGroup, helpBlock) {
    formGroup.addClass("has-error");
    helpBlock.removeClass("hidden");
}

function markFieldCorrect(formGroup, helpBlock) {
    formGroup.removeClass("has-error");
    helpBlock.addClass("hidden");
}