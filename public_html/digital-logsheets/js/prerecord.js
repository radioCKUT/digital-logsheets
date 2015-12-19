$(document).ready(function () {
    var prerecord_input = $("#prerecord");

    prerecord_input.change(checkPrerecordInput);
});

function checkPrerecordInput() {
    console.log("check prerecord input");
    var prerecord_date = $("#prerecord_date");
    if(this.checked) {
        prerecord_date.show();
        prerecord_date.prop('required', true);

        $("#prerecord_date_label").show();

    } else {
        prerecord_date.hide();
        prerecord_date.prop('required', false);
        $("#prerecord_date_label").hide();
    }
}


