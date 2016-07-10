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

function isSegmentTimeWithinEpisode(segmentStartTime, episodeStartDatetime, episodeEndDatetime) {
    console.log("in isSegmentTimeWithinEpisode");
    var segmentStartTimeObject = new Date("January 1 " + segmentStartTime);
    var segmentStartTimeInMinutes = getTimeInMinutes(segmentStartTimeObject);

    var episodeStartDatetimeObject = new Date(episodeStartDatetime);
    var episodeStartTimeInMinutes = getTimeInMinutes(episodeStartDatetimeObject);

    var episodeEndDatetimeObject = new Date(episodeEndDatetime);
    var episodeEndTimeInMinutes = getTimeInMinutes(episodeEndDatetimeObject);

    var episodeStartDay = episodeStartDatetimeObject.getDay();
    var episodeEndDay = episodeEndDatetimeObject.getDay();

    if (episodeStartDay === episodeEndDay) {
        return (segmentStartTimeInMinutes >= episodeStartTimeInMinutes)
            && (segmentStartTimeInMinutes <= episodeEndTimeInMinutes);

    } else {
        const MINUTES_IN_DAY = 24 * 60;

        return (segmentStartTimeInMinutes + MINUTES_IN_DAY >= episodeStartTimeInMinutes
                && segmentStartTimeInMinutes <= episodeEndTimeInMinutes)
            || (segmentStartTimeInMinutes >= episodeStartTimeInMinutes
                && segmentStartTimeInMinutes <= episodeEndTimeInMinutes + MINUTES_IN_DAY)
    }
}

function getTimeInMinutes(datetimeObject) {
    return (datetimeObject.getHours() * 60) + datetimeObject.getMinutes();
}

