$(document).ready(function () {
    setStartDateTimeBounds();
    adjustPrerecordDateBounds();
});

function adjustPrerecordDateBounds() {
    var episodeStartInput = $('#start_datetime');
    var episodeStartVal = episodeStartInput.val();
    episodeStartVal = episodeStartVal.replace('T', ' '); //So HTML input may be parsed by Date.js
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
    var todayWithOffset = date.addMonths(monthOffsetFromDate);

    var dd = todayWithOffset.getDate();
    var mm = todayWithOffset.getMonth()+1; //January is 0!

    var yyyy = todayWithOffset.getFullYear();
    if(dd<10){
        dd='0'+dd
    }
    if(mm<10){
        mm='0'+mm
    }

    todayWithOffset = yyyy + '-' + mm + '-' + dd;
    return todayWithOffset;
}