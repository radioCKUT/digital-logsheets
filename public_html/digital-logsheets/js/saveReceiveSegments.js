function getEpisodeSegments() {
    $.ajax({
        type: "POST",
        url: window.location.protocol + "//" + window.location.host + "/" + "digital-logsheets/get-episode-data.php",
        data: $('#logsheet').serialize(),
        success: receiveSegmentsSuccess,
        error: receiveSegmentsError
    });
}

function createSegment() {
    var dataToSend = $('#logsheet').serializeArray();
    sendRequestToSaveSegment(dataToSend);
}

function sendRequestToSaveSegment(dataToSend) {
    $.ajax({
        type: "POST",
        url: window.location.protocol + "//" + window.location.host + "/" + "digital-logsheets/save-segment.php",
        dataType: "json",
        data: dataToSend,
        success: receiveSegmentsSuccess,
        error: receiveSegmentsError
    });
}

function receiveSegmentsError(jqhxr, textStatus, errorThrown) {
    alert("add segment fail! status: " + textStatus + " error thrown: " + errorThrown);
    // TODO: proper error notification
}

function receiveSegmentsSuccess(data) {
    if (data.hasOwnProperty("error")) {

        var errors = data.error;
        var idSuffix = data.wasEditing ? "_edit" : "";

        if (errors.missingName) {
            markFieldError($('#name_group' + idSuffix), $('#name_help_block' + idSuffix));
        }

        if (errors.missingAuthor) {
            markFieldError($('#author_group' + idSuffix), $('#author_help_block' + idSuffix));
        }

        if (errors.missingAlbum) {
            markFieldError($('#album_group' + idSuffix), $('#album_help_block' + idSuffix));
        }

        if (errors.missingAdNumber) {
            markFieldError($('#ad_number_group' + idSuffix), $('#ad_number_help_block' + idSuffix));
        }
    } else {
        hideEditForm();
        $('#logsheet').trigger("reset");

        resetCategoryButtons();

        var addedSegments = $('#added_segments');
        addedSegments.empty();
        addedSegments.append($('<thead><tr>' + '<th>' + 'Time' + '</th>' +'<th>' + 'Name' + '</th>' + '</tr></thead><tbody>'));

        $.each(data, function(i, e) {
            var segment_id = data[i].id;
            var name = data[i].name;
            var start_time = data[i].startTime;

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
        });

        addedSegments.append($('</tbody>'));

    }
}

function resetCategoryButtons() {
    $('.btn.btn-primary').removeClass('active');
    $('.category1').prop('checked', false);
    $('.category2').prop('checked', false);
    $('.category3').prop('checked', false);
    $('.category5').prop('checked', false);
    $('.category4').prop('checked', false);
    resetAllFields();
}

