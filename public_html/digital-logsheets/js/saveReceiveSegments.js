/*
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2016  Evan Vassallo
 * Copyright (C) 2016  James Wang
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
        console.error("error in data " + data.error);
        //TODO error handling

    } else {
        hideEditForm();
        $('#logsheet').trigger("reset");

        resetCategoryButtons();

        var addedSegments = $('#added_segments');
        addedSegments.find("tbody").empty();

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


        if (!$('#playlist_not_aligned_help_text').hasClass("hidden")) {
            verifyPlaylistEpisodeAlignment();
        }
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

