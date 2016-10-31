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


function markSegmentTimeIncorrect(helpBlock) {
    var segmentTimeFormGroup = $('.time_group');
    markFieldError(segmentTimeFormGroup, helpBlock)
}

function markSegmentTimeCorrect(helpBlock) {
    var segmentTimeFormGroup = $('.time_group');
    markFieldCorrect(segmentTimeFormGroup, helpBlock);
}

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