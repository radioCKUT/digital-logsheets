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

function init(episodeStartDatetimeString) {
    getEpisodeSegments();
    setFormOnSubmitBehaviour();
    setConfirmModalBehaviour();

    var segmentTimeField = $('#segment_time');
    segmentTimeField.datetimepicker({
        format: "LT",
        defaultDate: moment(episodeStartDatetimeString)
    });

    var segmentTimeEditField = $('#segment_time_edit');
    segmentTimeEditField.datetimepicker({
        format: "LT"
    });

    $('[data-toggle="tooltip"]').tooltip();
}

function setFormOnSubmitBehaviour() {
    $('#logsheet').on('submit', function(e) {
        e.preventDefault();
        createSegment();
    });

    var logsheetEdit = $('#logsheet_edit');

    logsheetEdit.on('submit', function(e) {
        e.preventDefault();
        editEpisodeSegment();
    });

    logsheetEdit.hide();

    $('#finalize')
        .on('submit', function(e) {
            console.log("logsheet_edit:hidden: ", $("#logsheet_edit:hidden"));
            if ($("#logsheet_edit:hidden").length === 0) {
                e.preventDefault();
                alert("You will lose unsaved changes to this segment if you proceed. Continue?");
            }


            if (!verifyPlaylistEpisodeAlignment()) {
                e.preventDefault();
            }

            $('#added_segments').find('tbody').find('tr').each(function (i, segment) {
                segment = $(segment);
                var errors = segment.data("errors");

                if (isSegmentErroneous(errors)) {
                    markErroneousSegmentsExist();
                    e.preventDefault();
                    return false;
                }

                markNoErroneousSegmentsExist();
            });
        });
}

function setConfirmModalBehaviour() {
    $('#confirmDeleteModal')
        .on('show.bs.modal', function (e) {
            var deleteSegmentLink = $(e.relatedTarget);
            var deleteSegmentRow = deleteSegmentLink.closest("tr");

            var segmentToDelete = deleteSegmentRow.data("segment");
            var segmentIdToDelete = segmentToDelete.id;

            var confirmDeleteButton = $("#confirmDeleteButton");

            confirmDeleteButton.click(function (e) {
                e.preventDefault();
                deleteEpisodeSegment(segmentIdToDelete);
                $('#confirmDeleteModal').modal('hide');
            });
        });
}
