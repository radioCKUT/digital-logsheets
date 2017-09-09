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

function isDateEntryBlank(dateEntry) {
    return dateEntry == null || dateEntry == '' || isNaN(dateEntry.getTime());
}

function doesEpisodeFallInDateRange(startDateString, endDateString, episode) {

    var filterStartDate = new Date(startDateString);
    var filterEndDate = new Date(endDateString);

    var episodeStartDatetime = new Date(episode.startDatetime);
    var episodeEndDatetime = new Date(episode.endDatetime);

    if (isDateEntryBlank(filterStartDate) && isDateEntryBlank(filterEndDate)) {
        return true;

    } else if (isDateEntryBlank(filterStartDate)) {
        return episodeStartDatetime < filterEndDate;

    } else if (isDateEntryBlank(filterEndDate)) {
        return episodeEndDatetime > filterStartDate;

    } else if (filterStartDate < filterEndDate) {
        return episodeStartDatetime < filterEndDate && episodeEndDatetime > filterStartDate;
    } else {
        return false;
    }
}



function filterLogsheetList(episodes, appendFunc, container, programNameFilterList, startDateFilter, endDateFilter) {
    console.log(programNameFilterList + ", " + startDateFilter + ", " + endDateFilter);
    container.empty();

    var episodesKeyList = Object.keys(episodes);
    var numberOfEpisodes = episodesKeyList.length;

    for (var i = 0; i < numberOfEpisodes; i++) {
        var episode = episodes[episodesKeyList[i]];

        if ((programNameFilterList == null || programNameFilterList.length == 0) && startDateFilter == '' && endDateFilter == '') {
            appendFunc(container, episode);
        }

        if (programNameFilterList != null && programNameFilterList.length != 0) {
            var doesEpisodeMatchProgramName = false;
            var episodeProgramName = episode.program;

            for (var j = 0; j < programNameFilterList.length; j++) {
                if (episodeProgramName == programNameFilterList[j]) {
                    doesEpisodeMatchProgramName = true;
                    break;
                }
            }

            if (!doesEpisodeMatchProgramName) {
                continue;
            }
        }

        var doesEpisodeFallWithinDateRange = doesEpisodeFallInDateRange(startDateFilter, endDateFilter, episode);

        if (doesEpisodeFallWithinDateRange) {
            appendFunc(container, episode);
        }
    }


}