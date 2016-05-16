function isDateEntryBlank(dateEntry) {
    return dateEntry == null || dateEntry == '';
}

function checkWhetherEpisodeFallsWithinDateRange(startDate, endDate) {
    if (isDateEntryBlank(startDate) && isDateEntryBlank(endDate)) { //TODO: check if this covers blank date submissions
        return true;

    } else if (isDateEntryBlank(startDate)) {
        return episode.start_date < endDate;

    } else if (isDateEntryBlank(endDate)) {
        return episode.end_date > startDate;

    } else if (startDate < endDate) {
        return episode.start_date < endDate || episode.end_date > startDate;
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

        var doesEpisodeFallWithinDateRange = checkWhetherEpisodeFallsWithinDateRange(startDateFilter, endDateFilter);

        if (doesEpisodeFallWithinDateRange) {
            appendEpisodeLink(existingLogsheetsContainer, episode);
        }
    }


}