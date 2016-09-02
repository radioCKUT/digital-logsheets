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
}

function showEditForm() {
    $('#logsheet').hide();
    $('#logsheet_edit').show();
}

function hideEditForm() {
    $('#logsheet').show();
    $('#logsheet_edit').hide();
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

    // change submit value to createSegment
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