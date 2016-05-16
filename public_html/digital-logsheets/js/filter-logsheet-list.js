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
    var existingLogsheetsContainer = $(".logsheets");
    existingLogsheetsContainer.empty();

    episodes.each(function (index, episode) {
        if (programNameFilterList == null && startDateFilter == null && endDateFilter == null) {
            appendEpisodeLink(existingLogsheetsContainer, episode);
        }

        var doesEpisodeMatchProgramName = false;
        var episodeProgramName = episode.program;

        programNameFilterList.each(function(index, element) {
            if (episodeProgramName == element) {
                doesEpisodeMatchProgramName = true;
                return false;
            }
            return true;
        });

        if (!doesEpisodeMatchProgramName) {
            return true;
        }

        var doesEpisodeFallWithinDateRange = checkWhetherEpisodeFallsWithinDateRange(startDateFilter, endDateFilter);

        if (doesEpisodeFallWithinDateRange) {
            appendEpisodeLink(existingLogsheetsContainer, episode);
        }
    });
}