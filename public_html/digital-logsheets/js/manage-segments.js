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
    var dataToSend = $('#logsheet').serializeArray();

    sendRequestToSaveSegment(dataToSend);
}

function editEpisodeSegment(id) {
    var dataToSend = $('#logsheet').serializeArray();
    dataToSend.push({name: "segment_id", value: id});
    dataToSend.push({name: "is_existing_segment", value: true});

    sendRequestToSaveSegment(dataToSend);

    // change submit value to addSegment
}

function prepareFormForEdit(eventObject) {
    console.log("preparing form for edit.");
    var tableRow = $(eventObject.target).parent().parent().parent().parent();
    console.log(" tableRow: " + tableRow);
    var segment_object = $(tableRow).data("segment");
    console.log("segment_object: " + segment_object);

    //set values of logsheet form
    $('#logsheet').hide();
    $('#logsheet_edit').show();

    switch (segment_object.category) {
        case 1:
            $('.category1_edit').closest('.btn').button('toggle');
            setupCat1Fields();
            break;
        case 2:
            $('.category2_edit').closest('.btn').button('toggle');
            setupCat2Fields();
            break;
        case 3:
            $('.category3_edit').closest('.btn').button('toggle');
            setupCat3Fields();
            break;
        case 4:
            $('.category4_edit').closest('.btn').button('toggle');
            setupCat4Fields();
            break;
        case 5:
            $('.category5_edit').closest('.btn').button('toggle');
            setupCat5Fields();
            break;
    }

    $('#name_input_edit').attr("value", segment_object.name);
    $('#author_input_edit').attr("value", segment_object.author);
    $('#album_input_edit').attr("value", segment_object.album);
    $('#ad_number_input_edit').attr("value", segment_object.ad_number);

    //TODO: change submit value to editEpisodeSegment
}

function sendRequestToSaveSegment(dataToSend) {
    $.ajax({
        type: "POST",
        url: window.location.protocol + "//" + window.location.host + "/" + "digital-logsheets/save-segment.php",
        dataType: "json",
        data: dataToSend,
        success: successCallback,
        error: errorCallback
    });
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

            var delete_button = generateDeleteButton(segment_id);
            var edit_button = generateEditButton(segment_id);

            var segmentRow = $(document.createElement("tr"))
                .data("segment", data[i])
                .append($('<td class="vert-align">' + start_time + '</td>')).append($('<td class="vert-align">' + name + '</td>')).append($('<td class="vert-align">')
                .append($('<div class="dropdown">')
                    .append($('<button class="btn btn-default btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">')
                        .append($('<span class="glyphicon glyphicon-option-vertical" aria-hidden="true">')))
                    .append($('<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">')
                        .append(edit_button).append(delete_button))));

            addedSegments.append(segmentRow);
            console.log("segment saved in row:");
            console.log(segmentRow.data("segment"));

        });

        addedSegments.append($('</tbody>'));

    } else {
        console.log("error in data " + data.error);
        //TODO error handling
    }
}

function generateDeleteButton(segment_id) {
    return $(document.createElement("li"))
        .click(function(eventObject) {
            console.log("entered delete button on click handler");
            deleteEpisodeSegment(segment_id);
        })
        .text("Delete");
}

function generateEditButton(segment_id) {
    return $(document.createElement("li"))
        .click(function(eventObject) {
            console.log("entered edit button on click handler");
            prepareFormForEdit(eventObject);
        })
        .text("Edit");
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