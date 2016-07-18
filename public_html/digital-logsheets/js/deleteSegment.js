function deleteEpisodeSegment(id) {
    $.ajax({
        type: "POST",
        url: window.location.protocol + "//" + window.location.host + "/" + "digital-logsheets/delete-segment-validation.php",
        data: { segment_id : id },
        success: deleteSuccessCallback,
        error: deleteErrorCallback
    })
}

function deleteSuccessCallback(data) {
    console.log("success callback");

    if (!data.hasOwnProperty("error")) {
        getEpisodeSegments();
    } else {
        console.error("error in data " + data.error);
        //TODO error handling
    }
}

function deleteErrorCallback(jqhxr, textStatus, errorThrown) {
    alert("Add segment fail! status: " + textStatus + " error thrown: " + errorThrown);
    //TODO: proper error handling
}