

function deleteEpisodeSegment(id) {
    $.ajax({
        type: "POST",
        url: window.location.protocol + "//" + window.location.host + "/" + "digital-logsheets/get-episode-data.php",
        data: { segment_id : id },
        success: successCallback,
        error: errorCallback
    })
}

function successCallback(data) {
    console.log("success callback");

    if (!data.hasOwnProperty("error")) {
        getEpisodeSegments();
    } else {
        console.log("error in data " + data.error);
        //TODO error handling
    }
}

function errorCallback(jqhxr, textStatus, errorThrown) {
    alert("add segment fail! status: " + textStatus + " error thrown: " + errorThrown);
}