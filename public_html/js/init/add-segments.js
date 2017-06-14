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
