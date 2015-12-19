$(document).ready(function () {
    $('#logsheet').on('submit', function(e) {
        e.preventDefault();
        addSegment();
    });
});

function getEpisodeSegments() {
    $.ajax({
        type: "POST",
        url: window.location.protocol + "//" + window.location.host + "/" + "/digital-logsheets/get-episode-data.php",
        data: $('#logsheet').serialize(),
        success: successCallback,
        error: errorCallback
    });
}


function addSegment() {
    $.ajax({
        type: "POST",
        url: window.location.protocol + "//" + window.location.host + "/" + "/digital-logsheets/save-segment.php",
        dataType: "json",
        data: $('#logsheet').serialize(),
        success: successCallback,
        error: errorCallback
    });
}

function errorCallback(jqhxr, textStatus, errorThrown) {
    alert("add segment fail! status: " + textStatus + " error thrown: " + errorThrown);
}


function successCallback(data) {
    console.log("success callback");

    if (!data.hasOwnProperty("error")) {
        $('#logsheet').trigger("reset");
        console.log(data[0]);

        var addedSegments = $('#added_segments');
        addedSegments.empty();
        addedSegments.append($('<tr>' +'<th>' + 'Name' + '</th>' + '</tr>'));

        $.each(data, function(i, e) {
            var name = data[i].name;
            var time = data[i].start_time;
            addedSegments.append($('<tr>' + '<td>' + name + '</td>' + '</tr>'));

        });
    } else {
        console.log("error in data " + data.error);
        //TODO error handling
    }
}
