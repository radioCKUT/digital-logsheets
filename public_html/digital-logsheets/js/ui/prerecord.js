$(document).ready(function () {
    var prerecord_input = $("#prerecord");
    prerecord_input.change(checkPrerecordInput);
    checkPrerecordInput();
});

function checkPrerecordInput() {
    var prerecord_date = $("#prerecord_date");
    var prerecord_date_label = $("#prerecord_date_label");

    if (this.checked) {
        prerecord_date.prop('required', true);
        prerecord_date.prop('disabled', false);

    } else {
        prerecord_date.prop('required', false);
        prerecord_date.prop('disabled', true);
    }
}


