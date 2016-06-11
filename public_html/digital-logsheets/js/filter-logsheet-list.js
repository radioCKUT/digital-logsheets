function isDateEntryBlank(dateEntry) {
    return dateEntry == null || dateEntry == '' || isNaN(dateEntry.getTime());
}

function checkWhetherEpisodeFallsWithinDateRange(startDateString, endDateString, episode) {

    var startDate = new Date(startDateString);
    var endDate = new Date(endDateString);

    console.log("start date object: " + startDate);
    console.log("end date object: " + isNaN(new Date(endDateString).getTime()));

    if (isDateEntryBlank(startDate) && isDateEntryBlank(endDate)) { //TODO: check if this covers blank date
        console.log("Both dates blank");
        return true;

    } else if (isDateEntryBlank(startDate)) {
        console.log("start date blank");
        return episode.start_date < endDate;

    } else if (isDateEntryBlank(endDate)) {
        console.log("end date blank");
        console.log("episode end date: " + episode.end_date);
        return episode.end_date > startDate;

    } else if (startDate < endDate) {
        console.log("Neither date blank - start date before end date");
        return episode.start_date < endDate || episode.end_date > startDate;
    } else {
        console.error("Unexpected date option. isDateEntryBlank(endDate): " + isDateEntryBlank(endDate) + " isDateIsBlank(startDate): " + isDateEntryBlank(startDate) + " endDate: " + endDate);
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