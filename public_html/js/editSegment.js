/*
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.    
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2017  Evan Vassallo
 * Copyright (C) 2017 Donghee Baik
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

function prepareFormForEdit(eventObject) {
    resetSaveFeedback();

    var tableRow = $(eventObject.target).closest("tr");
    var segment_object = $(tableRow).data("segment");

    showEditForm();

    switch (segment_object.category) {
        case 1:
            $('.category1').closest('.btn').button('toggle');
            setupCat1Fields(false);
            break;
        case 2:
            $('.category2').closest('.btn').button('toggle');
            setupCat2Fields(false);
            break;
        case 3:
            $('.category3').closest('.btn').button('toggle');
            setupCat3Fields(false);
            break;
        case 4:
            $('.category4').closest('.btn').button('toggle');
            setupCat4Fields(false);
            break;
        case 5:
            $('.category5').closest('.btn').button('toggle');
            setupCat5Fields(false);
            break;
    }


    $('#segment_time_edit').attr("value", segment_object.startTime);
    $('#name_input_edit').attr("value", segment_object.name);
    $('#author_input_edit').attr("value", segment_object.author);
    $('#album_input_edit').attr("value", segment_object.album);
    $('#ad_number_input_edit').attr("value", segment_object.adNumber);

    $('#can_con_edit').prop("checked", segment_object.canCon);
    $('#new_release_edit').prop("checked", segment_object.newRelease);
    $('#french_vocal_music_edit').prop("checked", segment_object.frenchVocalMusic);
    $('#station_id_edit').prop("checked", segment_object.stationIdGiven);

    $('#segment_id_edit').attr("value", segment_object.id);




    var errors = $(tableRow).data("errors");

    if (errors.missingCategory || errors.categoryInvalidFormat) {
        markFieldError($('.category_group_edit'), $('#category_help_block_edit'));

    } else {
        markFieldCorrect($('.category_group_edit'), $('#category_help_block_edit'))
    }

    if (errors.missingAlbum) {
        markFieldError($('.album_group_edit'), $('#album_help_block_edit'));

    } else {
        markFieldCorrect($('.album_group_edit'), $('#album_help_block_edit'));
    }

    if (errors.missingAuthor) {
        markFieldError($('.author_group_edit'), $('#author_help_block_edit'));

    } else {
        markFieldCorrect($('.author_group_edit'), $('#author_help_block_edit'));
    }

    if (errors.missingName) {
        markFieldError($('.name_group_edit'), $('#name_help_block_edit'));

    } else {
        markFieldCorrect($('.name_group_edit'), $('#name_help_block_edit'));
    }

    if (errors.missingAdNumber || errors.invalidAdNumber) {
        markFieldError($('.ad_number_group_edit'), $('#ad_number_help_block_edit'));

    } else {
        markFieldCorrect($('.ad_number_group_edit'), $('#ad_number_help_block_edit'))
    }




    var timeGroupEdit = $('.time_group_edit');

    if (errors.missingStartTime || errors.startTimeInvalidFormat) {
        markFieldCorrect(timeGroupEdit, $('#segment_time_out_of_bounds_help_text_edit'));
        markFieldError(timeGroupEdit, $('#missing_segment_time_help_block_edit'));


    } else if (errors.outOfEpisodeBounds) {
        markFieldCorrect(timeGroupEdit, $('#missing_segment_time_help_block_edit'));
        markFieldError(timeGroupEdit, $('#segment_time_out_of_bounds_help_text_edit'));

    } else {
        markFieldCorrect(timeGroupEdit, $('#missing_segment_time_help_block_edit'));
        markFieldCorrect(timeGroupEdit, $('#segment_time_out_of_bounds_help_text_edit'))
    }


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
    resetSaveFeedback();

    if ($('.category1').parent().hasClass("active")) {
        setupCat1Fields(true)
    } else if ($('.category2').parent().hasClass("active")) {
        setupCat2Fields(true)
    } else if ($('.category3').parent().hasClass("active")) {
        setupCat3Fields(true)
    } else if ($('.category4').parent().hasClass("active")) {
        setupCat4Fields(true)
    } else if ($('.category5').parent().hasClass("active")) {
        setupCat5Fields(true)
    }
}