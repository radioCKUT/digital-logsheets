/*
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.    
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2017  Evan Vassallo
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

function setupAllCatHTMLValidation(adNumberInput, nameInput) {
    adNumberInput.prop('required', false);
    nameInput.prop('required', true);
}

function setupMusicCatHTMLValidation(authorInput, albumInput) {
    authorInput.prop('required', true);
    albumInput.prop('required', true);
}

function setupNonMusicCatHTMLValidation(authorInput, albumInput) {
    authorInput.prop('required', false);
    albumInput.prop('required', false);
}

function setupCat5HTMLValidation(adNumberInput, nameInput) {
    adNumberInput.prop('required', true);
    nameInput.prop('required', false);
}


function isSegmentErroneous(errors) {
    var errorsKeys = Object.keys(errors);

    for (var errorsIndex = 0; errorsIndex < errorsKeys.length; errorsIndex++) {
        if (errors[errorsKeys[errorsIndex]]) {
            return true;
        }
    }
    return false;
}






function verifySegmentStartTime(timeGroup, episode) {

    var segmentTimeField = timeGroup.find('.segment_time');
    var segmentTime = segmentTimeField.val();

    var helpBlock =  timeGroup.find('.segment_time_out_of_bounds_help_text');

    if (segmentTime == '') {
        markFieldCorrect(timeGroup, helpBlock);
        return false;
    }

    var segmentDatetime = new Date("January 1, " + segmentTime);

    var episodeStartDatetime = new Date(episode.startDatetime);
    var episodeEndDatetime = new Date(episode.endDatetime);

    var segmentTimeInMinutes = getTimeInMinutesSinceMidnight(segmentDatetime);
    var episodeStartTimeInMinutes = getTimeInMinutesSinceMidnight(episodeStartDatetime);
    var episodeStartDay = episodeStartDatetime.getDay();

    var episodeEndTimeInMinutes = getTimeInMinutesSinceMidnight(episodeEndDatetime);
    var episodeEndDay = episodeEndDatetime.getDay();

    var isSegmentInEpisode;

    if (episodeStartDay == episodeEndDay) {
        isSegmentInEpisode = episodeSpanningOneCalendarDay(segmentTimeInMinutes, episodeStartTimeInMinutes, episodeEndTimeInMinutes);

    } else {
        isSegmentInEpisode = episodeSpanningTwoCalendarDays(segmentTimeInMinutes, episodeStartTimeInMinutes, episodeEndTimeInMinutes);
    }



    if (isSegmentInEpisode) {
        markFieldCorrect(timeGroup, helpBlock);
        return true;

    } else {
        markFieldError(timeGroup, helpBlock);
        return false;
    }
}

function getTimeInMinutesSinceMidnight(dateTime) {
    return (dateTime.getHours() * 60) + dateTime.getMinutes();
}

function episodeSpanningOneCalendarDay(segmentStartTimeInMinutes, episodeStartTimeInMinutes, episodeEndTimeInMinutes) {
    return ((segmentStartTimeInMinutes >= episodeStartTimeInMinutes)
    && (segmentStartTimeInMinutes <= episodeEndTimeInMinutes));
}

const MINUTES_IN_DAY = 24 * 60;

function isInEpisodesFirstCalendarDay(segmentStartTimeInMinutes, episodeStartTimeInMinutes, episodeEndTimeInMinutes) {
    return (segmentStartTimeInMinutes >= episodeStartTimeInMinutes
    && segmentStartTimeInMinutes <= episodeEndTimeInMinutes + MINUTES_IN_DAY);
}

function isInEpisodesSecondCalendarDay(segmentStartTimeInMinutes, episodeStartTimeInMinutes, episodeEndTimeInMinutes) {
    return (segmentStartTimeInMinutes + MINUTES_IN_DAY >= episodeStartTimeInMinutes
    && segmentStartTimeInMinutes <= episodeEndTimeInMinutes);
}

function episodeSpanningTwoCalendarDays(segmentStartTimeInMinutes, episodeStartTimeInMinutes, episodeEndTimeInMinutes) {
    return (isInEpisodesFirstCalendarDay(segmentStartTimeInMinutes, episodeStartTimeInMinutes, episodeEndTimeInMinutes)
    || isInEpisodesSecondCalendarDay(segmentStartTimeInMinutes, episodeStartTimeInMinutes, episodeEndTimeInMinutes));
}