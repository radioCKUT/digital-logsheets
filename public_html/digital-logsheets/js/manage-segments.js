$(document).ready(function () {
    $('#logsheet').on('submit', function(e) {
        e.preventDefault();
        addSegment();
    });

    $('#logsheet_edit').on('submit', function(e) {
        e.preventDefault();
        editEpisodeSegment();
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

function cancelEdit() {
    $('#logsheet_edit').trigger("reset");
    hideEditForm();
    resetAllFields();

    if ($('.category1').parent().hasClass("active")) {
        setupCat1Fields()
    } else if ($('.category2').parent().hasClass("active")) {
        setupCat2Fields()
    } else if ($('.category3').parent().hasClass("active")) {
        setupCat3Fields()
    } else if ($('.category4').parent().hasClass("active")) {
        setupCat4Fields()
    } else if ($('.category5').parent().hasClass("active")) {
        setupCat5Fields()
    }
}

function editEpisodeSegment() {
    var dataToSend = $('#logsheet_edit').serializeArray();

    var segment_id = null;

    $.each(dataToSend, function (i, e) {
        if (dataToSend[i].name == "segment_id"){
            segment_id = dataToSend[i].value;
        }
    });

    dataToSend.push({name: "segment_id", value: segment_id});
    dataToSend.push({name: "is_existing_segment", value: true});

    sendRequestToSaveSegment(dataToSend);

    // change submit value to addSegment
}

function showEditForm() {
    $('#logsheet').hide();
    $('#logsheet_edit').show();
}

function hideEditForm() {
    $('#logsheet').show();
    $('#logsheet_edit').hide();
}

function prepareFormForEdit(eventObject) {
    var tableRow = $(eventObject.target).parent().parent().parent().parent();
    var segment_object = $(tableRow).data("segment");
    console.log("start time: " + segment_object.start_time);

    showEditForm();

    switch (segment_object.category) {
        case 1:
            $('.category1').closest('.btn').button('toggle');
            setupCat1Fields();
            break;
        case 2:
            $('.category2').closest('.btn').button('toggle');
            setupCat2Fields();
            break;
        case 3:
            $('.category3').closest('.btn').button('toggle');
            setupCat3Fields();
            break;
        case 4:
            $('.category4').closest('.btn').button('toggle');
            setupCat4Fields();
            break;
        case 5:
            $('.category5').closest('.btn').button('toggle');
            setupCat5Fields();
            break;
    }

    $('#segment_time_edit').attr("value", segment_object.start_time);
    $('#name_input_edit').attr("value", segment_object.name);
    $('#author_input_edit').attr("value", segment_object.author);
    $('#album_input_edit').attr("value", segment_object.album);
    $('#ad_number_input_edit').attr("value", segment_object.ad_number);

    $('#can_con_edit').prop("checked", segment_object.can_con);
    $('#new_release_edit').prop("checked", segment_object.new_release);
    $('#french_vocal_music_edit').prop("checked", segment_object.french_vocal_music);

    $('#segment_id_edit').attr("value", segment_object.id);

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
        hideEditForm();
        $('#logsheet').trigger("reset");
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