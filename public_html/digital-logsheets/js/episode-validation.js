$(document).ready(function () {
    setStartDateTimeBounds();
});

function setStartDateTimeBounds() {
    var lowerBoundMonthOffset = -1;
    var upperBoundMonthOffset = 1;

    var lowerBound = getDateOffset(lowerBoundMonthOffset);
    lowerBound += 'T00:00:00';
    var upperBound = getDateOffset(upperBoundMonthOffset);
    upperBound += 'T23:59:59';

    var startDateTime = $('#start_datetime');
    startDateTime.prop('min', lowerBound);
    startDateTime.prop('max', upperBound);
}

function getDateOffset(monthOffsetFromCurrentDate) {
    var todayWithOffset = Date.today().addMonths(monthOffsetFromCurrentDate);

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