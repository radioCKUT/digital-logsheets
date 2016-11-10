function generateDeleteButton(segment_id) {
    return $(document.createElement("li"))
        .click(function(eventObject) {
            deleteEpisodeSegment(segment_id);
        })
        .text("Delete");
}

function generateEditButton(segment_id) {
    return $(document.createElement("li"))
        .click(function(eventObject) {
            prepareFormForEdit(eventObject);
        })
        .text("Edit");
}