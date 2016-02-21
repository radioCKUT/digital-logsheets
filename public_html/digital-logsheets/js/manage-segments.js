$(document).ready(function () {
    $('#logsheet').on('submit', function(e) {
        e.preventDefault();
        addSegment();
    });
});

function getEpisodeSegments() {
    $.ajax({
        type: "POST",
        url: window.location.protocol + "//" + window.location.host + "/" + "digital-logsheets/get-episode-data.php",
        data: $('#logsheet').serialize(),
        success: successCallback,
        error: errorCallback
    });

    console.log(window.location.protocol + "//" + window.location.host + "/" + "digital-logsheets/get-episode-data.php");

}


function addSegment() {
    $.ajax({
        type: "POST",
        url: window.location.protocol + "//" + window.location.host + "/" + "digital-logsheets/save-segment.php",
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
        $('.category').button('reset');

        console.log(data[0]);

        var addedSegments = $('#added_segments');
        addedSegments.empty();
        addedSegments.append($('<thead><tr>' + '<th>' + 'Time' + '</th>' +'<th>' + 'Name' + '</th>' + '</tr></thead><tbody>'));

        $.each(data, function(i, e) {
            var segment_id = data[i].id;
            var name = data[i].name;
            var start_time = data[i].start_time;

            var delete_button = $(document.createElement("li"))
                .attr("style", "background-color: red; color: white;")
                .click(function(eventObject) {
                    console.log("entered delete button on click handler");
                    deleteEpisodeSegment(segment_id);
                })
                .text("Delete");

            addedSegments.append($('<tr>')
                .append($('<td class="vert-align">' + start_time + '</td>')).append($('<td class="vert-align">' + name + '</td>')).append($('<td class="vert-align">')
                    .append($('<div class="dropdown">')
                        .append($('<button class="btn btn-default btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">')
                        .append($('<span class="glyphicon glyphicon-option-vertical" aria-hidden="true">')))
                            .append($('<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">')
                                .append($('<li><a href="#">Edit</a></li>')).append(delete_button)))))
                .data("segment", data[i]);
        });

        addedSegments.append($('</tbody>'));
    } else {
        console.log("error in data " + data.error);
        //TODO error handling
    }
}


function deleteEpisodeSegment(id) {
    console.log("in deleteEpisodeSegment");

    $.ajax({
        type: "POST",
        url: window.location.protocol + "//" + window.location.host + "/" + "digital-logsheets/delete-segment.php",
        data: { segment_id : id },
        success: deleteSuccessCallback,
        error: deleteErrorCallback
    })
}

function deleteSuccessCallback(data) {
    console.log("success callback");

    if (!data.hasOwnProperty("error")) {
        getEpisodeSegments();
    } else {
        console.log("error in data " + data.error);
        //TODO error handling
    }
}

function deleteErrorCallback(jqhxr, textStatus, errorThrown) {
    alert("add segment fail! status: " + textStatus + " error thrown: " + errorThrown);
}