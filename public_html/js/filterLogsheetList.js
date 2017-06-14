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

function checkWhetherEpisodeFallsWithinDateRange(startDateString, endDateString, episode) {

    var filterStartDate = new Date(startDateString);
    var filterEndDate = new Date(endDateString);

    var episodeStartDatetime = new Date(episode.start_datetime);
    var episodeEndDatetime = new Date(episode.end_datetime);

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

function appendEpisodeLink(existingLogsheetsContainer, episode) {
    existingLogsheetsContainer.append("<a href=\"view-episode-logsheet.php?episode_id=" + episode.episode_id + "\">" + episode.program + " - " + episode.start_date + "</a> <br />");
}

function filterLogsheetList(episodes, programNameFilterList, startDateFilter, endDateFilter) {
    console.log(programNameFilterList + ", " + startDateFilter + ", " + endDateFilter);
    var existingLogsheetsContainer = $(".logsheets");
    existingLogsheetsContainer.empty();

    var episodesKeyList = Object.keys(episodes);
    var numberOfEpisodes = episodesKeyList.length;

    for (var i = 0; i < numberOfEpisodes; i++) {
        var episode = episodes[episodesKeyList[i]];

        if ((programNameFilterList == null || programNameFilterList.length == 0) && startDateFilter == '' && endDateFilter == '') {
            appendEpisodeLink(existingLogsheetsContainer, episode);
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

        var doesEpisodeFallWithinDateRange = checkWhetherEpisodeFallsWithinDateRange(startDateFilter, endDateFilter, episode);

        if (doesEpisodeFallWithinDateRange) {
            appendEpisodeLink(existingLogsheetsContainer, episode);
        }
    }


}