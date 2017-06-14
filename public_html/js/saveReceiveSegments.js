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

const MAX_STRING_LENGTH = 10;

function getBaseUrl() {
    var url = window.location.href;
    var lastSlashIndex = url.lastIndexOf("/");

    return url.substr(0, lastSlashIndex);
}

function getEpisodeSegments() {
    var baseUrl = getBaseUrl();

    $.ajax({
        type: "POST",
        url: baseUrl + "/get-episode-data.php",
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
    var baseUrl = getBaseUrl();

    $.ajax({
        type: "POST",
        url: baseUrl + "/save-segment.php",
        dataType: "json",
        data: dataToSend,
        success: receiveSegmentsSuccess,
        error: receiveSegmentsError
    });

    $(".spinner").removeClass("hidden");
}

function receiveSegmentsError(jqhxr, textStatus, errorThrown) {
    $(".spinner").addClass("hidden");
    $(".fa-check").addClass("hidden");

    var errorMessage = _getErrorMessageFromErrorThrown(errorThrown);

    $(".fa-times").removeClass("hidden")
        .attr("title", errorMessage)
        .tooltip('fixTitle');
}

function getAbbreviatedString(str) {
    if (str && str.length > MAX_STRING_LENGTH) {
        return str.substring(0, MAX_STRING_LENGTH) + '...';
    }

    return str;
}



function receiveSegmentsSuccess(data) {
    $(".spinner").addClass("hidden");
    $(".fa-times").addClass("hidden");
    _showAndHide($(".fa-check"));

    hideEditForm();
    $('#logsheet').trigger("reset");

    resetCategoryButtons();

    var addedSegments = $('#added_segments');
    addedSegments.find("tbody").empty();
    data = JSON.parse(data);

    $.each(data, function(i, e) {
        var segmentAndErrors = data[i];

        var segment = segmentAndErrors.segment;
        var segment_id = segment.id;
        var start_time = segment.startTime;


        var name = segment.name;
        var album = segment.album;
        var author = segment.author;

        if (segment.category == 2 || segment.category == 3) {
            name = getAbbreviatedString(name);
            album = getAbbreviatedString(segment.album);
            author = getAbbreviatedString(segment.author);
        }



        var errors = segmentAndErrors.errors;
        var tableRowElem = isSegmentErroneous(errors) ? "<tr class='erroneous_segment'>" : "<tr>";

        var options_button = generateOptionsButton();
        var delete_button = generateDeleteButton(segment_id);
        var edit_button = generateEditButton(segment_id);


        var segmentRow = $(tableRowElem)
            .data("segment", segment)
            .data("errors", errors)
            .append($('<td class="vert-align">' + start_time + '</td>'));

        if (segment.category == 2 || segment.category == 3) {
            segmentRow.append($('<td class="vert-align">' + name + '</td>'))
                .append($('<td class="vert-align">' + album + '</td>'))
                .append($('<td class="vert-align">' + author + '</td>'));

        } else if (segment.category == 5) {
            segmentRow.append($('<td class="vert-align" colspan="3">' + 'Ad #' + segment.adNumber + '</td>'));

        } else {
            segmentRow.append($('<td class="vert-align" colspan="3">' + name + '</td>'));
        }

        if (segment.category == null) {
            segment.category = "";
        }

        segmentRow.append($('<td class="vert-align">' + segment.category + '</td>'))
            .append($('<td class="vert-align">')
                .append($('<div class="dropdown">')
                .append(options_button)
                .append($('<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">')
                    .append(edit_button).append(delete_button))));

        addedSegments.append(segmentRow);
    });


    if (!$('#playlist_not_aligned_help_text').hasClass("hidden")) {
        verifyPlaylistEpisodeAlignment();
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

function _showAndHide(jQuerySelector) {
    jQuerySelector.removeClass("hidden");
    setTimeout(_hide(jQuerySelector), 1500);
}

function _hide(jQuerySelector) {
    return function() {
        jQuerySelector.addClass("hidden");
    };
}

function _getErrorMessageFromErrorThrown(errorThrown) {
    switch (errorThrown) {
        default:
            return "Error - please try again";
    }
}
