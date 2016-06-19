function isDateEntryBlank(dateEntry) {
    return dateEntry == null || dateEntry == '' || isNaN(dateEntry.getTime());
}

function checkWhetherEpisodeFallsWithinDateRange(startDateString, endDateString, episode) {

    var filterStartDate = new Date(startDateString);
    var filterEndDate = new Date(endDateString);

    var episodeStartDatetime = new Date(episode.start_datetime);
    var episodeEndDatetime = new Date(episode.end_datetime);

    if (isDateEntryBlank(filterStartDate) && isDateEntryBlank(filterEndDate)) { //TODO: check if this covers blank date
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
        //console.log("episode to consider: " + JSON.stringify(episode));

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