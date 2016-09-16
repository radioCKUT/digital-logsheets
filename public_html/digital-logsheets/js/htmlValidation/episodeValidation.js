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

$(document).ready(function () {
    setStartDateTimeBounds();
    adjustPrerecordDateBounds();
});

function adjustPrerecordDateBounds() {
    var episodeStartInput = $('#start_datetime');
    var episodeStartVal = episodeStartInput.val();
    episodeStartVal = episodeStartVal.replace('T', ' '); //So HTML input may be parsed by moment.js
    var episodeStartDate = Date.parse(episodeStartVal);

    var upperBound;
    var lowerBound;

    if (episodeStartDate != null && !isNaN(episodeStartDate)) {
        upperBound = getDateOffset(0, episodeStartDate);
        lowerBound = getDateOffset(-1, episodeStartDate);

    } else {
        upperBound = getDateOffset(0, Date.today());
        lowerBound = getDateOffset(-1, Date.today());
    }

    var prerecordDateInput = $('#prerecord_date');
    prerecordDateInput.prop('min', lowerBound);
    prerecordDateInput.prop('max', upperBound);
}

function setStartDateTimeBounds() {
    var lowerBoundMonthOffset = -1;
    var upperBoundMonthOffset = 1;

    var lowerBound = getDateOffset(lowerBoundMonthOffset, Date.today());
    lowerBound += 'T00:00:00';
    var upperBound = getDateOffset(upperBoundMonthOffset, Date.today());
    upperBound += 'T23:59:59';

    var startDateTime = $('#start_datetime');
    startDateTime.prop('min', lowerBound);
    startDateTime.prop('max', upperBound);
}

function getDateOffset(monthOffsetFromDate, date) {
    var todayWithOffset = moment(date).add(monthOffsetFromDate, 'months');

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