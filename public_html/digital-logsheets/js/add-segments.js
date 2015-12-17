function addSegment() {
    $.ajax({
        type: "POST",
        url: window.location.protocol + "//" + window.location.host + "/" + "public_html/digital-logsheets/save-segment.php",
        dataType: "json",
        data: $('#logsheet').serialize(),
        success: function (data) {
            alert("segment added! data:" + JSON.stringify(data));
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("add segment fail! status: " + textStatus + " error thrown: " + errorThrown + " url used: ");
        }
    });
}



