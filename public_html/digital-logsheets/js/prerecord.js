$(document).ready(function () {
    var prerecord_input = $("#prerecord");

    prerecord_input.change(checkPrerecordInput);
});

function checkPrerecordInput() {
    console.log("check prerecord input");
    if(this.checked) {
        $("#prerecord_date").show();
        $("#prerecord_date_label").show();
    } else {
        $("#prerecord_date").hide();
        $("#prerecord_date_label").hide();
    }
}


