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

function setupEpisodeValidation(validationBounds) {

    setStartDateTimeBounds(validationBounds.episodeStartEarlyLimit, validationBounds.episodeStartLateLimit);
    adjustPrerecordDateBounds(validationBounds.prerecordEarlyDaysLimit, validationBounds.prerecordLateDaysLimit);
    setDurationBounds(validationBounds.minDuration, validationBounds.maxDuration);

}

function adjustPrerecordDateBounds(prerecordEarlyDaysLimit, prerecordLateDaysLimit) {
    var episodeStartInput = $('#start_datetime');
    var episodeStartVal = episodeStartInput.val();

    if (!_isEpisodeStartDatetimeValid(episodeStartVal)) {
        return;
    }

    episodeStartVal = episodeStartVal.replace('T', ' '); //So HTML input may be parsed by moment.js
    var episodeStartDate = Date.parse(episodeStartVal);

    var upperBound;
    var lowerBound;

    if (episodeStartDate != null && !isNaN(episodeStartDate)) {
        upperBound = getDateOffset(prerecordLateDaysLimit, episodeStartDate);
        lowerBound = getDateOffset(-1 * prerecordEarlyDaysLimit, episodeStartDate);

    } else {
        upperBound = getDateOffset(prerecordLateDaysLimit, moment());
        lowerBound = getDateOffset(-1 * prerecordEarlyDaysLimit, moment());
    }

    var prerecordDateInput = $('#prerecord_date');
    prerecordDateInput.prop('min', lowerBound);
    prerecordDateInput.prop('max', upperBound);
}

function setDurationBounds(minDuration, maxDuration) {
    var durationField = $('#episode_duration');
    durationField.prop('min', minDuration);
    durationField.prop('max', maxDuration);
}

function setStartDateTimeBounds(earlyLimit, lateLimit) {
    var startDateTime = $('#start_datetime');

    const milliSecsInMinute = 1000 * 60;

    console.log('earlyLimit', earlyLimit);
    var earlyLimitDate = new Date(earlyLimit);
    var roundedEarlyLimitInMillisecs = Math.round(earlyLimitDate.getTime() / milliSecsInMinute) * milliSecsInMinute;
    var roundedEarlyLimitDate = new Date(roundedEarlyLimitInMillisecs);
    var roundedEarlyLimitDateAsString = roundedEarlyLimitDate.toISOString().split('.')[0];

    var lateLimitDate = new Date(lateLimit);
    var roundedLateLimitInMillisecs = Math.round(lateLimitDate.getTime() / milliSecsInMinute) * milliSecsInMinute;
    var roundedLateLimitDate = new Date(roundedLateLimitInMillisecs);
    var roundedLateLimitDateAsString = roundedLateLimitDate.toISOString().split('.')[0];

    startDateTime.prop('min', roundedEarlyLimitDateAsString);
    startDateTime.prop('max', roundedLateLimitDateAsString);
}

function getDateOffset(daysOffsetFromDate, date) {
    var todayWithOffset = moment(date).add(daysOffsetFromDate, 'days');

    var dd = todayWithOffset.date();
    var mm = todayWithOffset.month() + 1; //January is 0!
    var yyyy = todayWithOffset.year();

    if (dd < 10) {
        dd = '0' + dd
    }
    if (mm < 10) {
        mm = '0' + mm
    }

    todayWithOffset = yyyy + '-' + mm + '-' + dd;
    return todayWithOffset;
}








function verifyProgrammer() {
    var programmerGroup = $('#programmer_group');
    var programmerInput = programmerGroup.find('#programmer').val();
    var helpBlock = programmerGroup.find('#programmer_help_block');

    if (programmerInput != '') {
        markFieldCorrect(programmerGroup, helpBlock);
    } else {
        markFieldError(programmerGroup, helpBlock);
    }
}

function verifyProgram() {
    var programGroup = $('#program_group');
    var programInput = programGroup.find('#program').val();
    var helpBlock = programGroup.find('#program_help_block');

    if (programInput != '') {
        markFieldCorrect(programGroup, helpBlock);
    } else {
        markFieldError(programGroup, helpBlock);
    }
}

function verifyEpisodeStartDatetime() {
    var startDatetimeGroup = $('#start_datetime_group');
    var startDatetimeInputField = startDatetimeGroup.find('#start_datetime');
    var startDatetimeInput = startDatetimeInputField.val();
    var helpBlock = startDatetimeGroup.find('#start_datetime_help_block');


    var isInputADate = _isEpisodeStartDatetimeValid(startDatetimeInput);

    if (isInputADate) {
        var earlyLimit = startDatetimeInputField.attr("min");
        var earlyLimitMillisecs = new Date(earlyLimit).getTime();

        var lateLimit = startDatetimeInputField.attr("max");
        var lateLimitMillisecs = new Date(lateLimit).getTime();

        var startDatetimeMillisecs = new Date(startDatetimeInput).getTime();

        if (startDatetimeMillisecs < earlyLimitMillisecs) {
            markEpisodeStartDatetimeTooFarInPast(startDatetimeGroup, helpBlock);

        } else if (startDatetimeMillisecs > lateLimitMillisecs) {
            markEpisodeStartDatetimeTooFarInFuture(startDatetimeGroup, helpBlock);

        } else {
            markEpisodeStartDatetimeCorrect(startDatetimeGroup, helpBlock);
        }

    } else {
        markEpisodeStartDatetimeMissing(startDatetimeGroup, helpBlock);
    }
}

function verifyEpisodeDuration() {
    var durationGroup = $('#duration_group');
    var durationField = durationGroup.find('#episode_duration');
    var duration = durationField.val();
    duration = +duration; //Coerce to a number for comparison purposes.
    var helpBlock = durationGroup.find('#duration_help_block');

    if (duration === '') {
        markEpisodeDurationMissing(durationGroup, helpBlock);
        return;
    }

    var minDuration = durationField.attr('min');
    minDuration = +minDuration;
    var maxDuration = durationField.attr('max');
    maxDuration = +maxDuration;

    if (duration < minDuration) {
        markEpisodeDurationTooShort(durationGroup, helpBlock);

    } else if (duration > maxDuration) {
        markEpisodeDurationTooLong(durationGroup, helpBlock);

    } else {
        markEpisodeDurationCorrect(durationGroup, helpBlock);
    }
}

function verifyPrerecordDate() {
    var prerecordGroup = $('#prerecord_group');
    var prerecordDateField = prerecordGroup.find('#prerecord_date');
    var prerecordDate = prerecordDateField.val();
    var helpBlock = $('#prerecord_help_block');

    var isInputADate = moment(prerecordDate, "YYYY-MM-DD", true).isValid();
    console.log('isInputADate', isInputADate);

    if (isInputADate) {
        var earlyLimit = prerecordDateField.attr("min");
        var earlyLimitMillisecs = new Date(earlyLimit).getTime();

        var lateLimit = prerecordDateField.attr("max");
        var lateLimitMillisecs = new Date(lateLimit).getTime();

        var startDatetimeMillisecs = new Date(prerecordDate).getTime();

        if (startDatetimeMillisecs < earlyLimitMillisecs) {
            markPrerecordDateTooFarInPast(prerecordGroup, helpBlock);

        } else if (startDatetimeMillisecs > lateLimitMillisecs) {
            markPrerecordDateTooFarInFuture(prerecordGroup, helpBlock);

        } else {
            markPrerecordDateCorrect(prerecordGroup, helpBlock);
        }

    } else {
        markPrerecordDateMissing(prerecordGroup, helpBlock);
    }
}

function _isEpisodeStartDatetimeValid(startDatetimeInput) {
    // check for two kinds of date format, based on browser used
    return moment(startDatetimeInput, "YYYY-MM-DDTHH:mm", true).isValid() ||
        moment(startDatetimeInput, "YYYY-MM-DDTHH:mm:ss", true).isValid();
}