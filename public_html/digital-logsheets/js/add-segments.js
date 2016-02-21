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
        $('.category').button('reset' ;

        console.log(data[0]);

        var addedSegments = $('#added_segments');
        addedSegments.empty();
        addedSegments.append($('<thead><tr>' + '<th>' + 'Time' + '</th>' +'<th>' + 'Name' + '</th>' + '</tr></thead><tbody>'));

        $.each(data, function(i, e) {
            var name = data[i].name;
            var start_time = data[i].start_time;
            addedSegments.append($('<tr>' + '<td class="vert-align">' + start_time + '</td>' + '<td class="vert-align">' + name + '</td><td class="vert-align">' + '<div class="dropdown"> <button class="btn btn-default btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>  </button> <ul class="dropdown-menu" aria-labelledby="dropdownMenu1"><li><a href="#">Edit</a></li><li style="background-color: red; color: white;"><a href="#">Delete</a></li> </ul> </div></td>' + '</tr>').data("segment", data[i]));
            console.log(addedSegments.closest("tr"));
            console.log(addedSegments.closest("tr").data());
        });

        addedSegments.append($('</tbody>'));
    } else {
        console.log("error in data " + data.error);
        //TODO error handling
    }
}
