$(document).ready(function () {
    var prerecord_input = $("#prerecord");

    prerecord_input.change(checkPrerecordInput);
});

function checkPrerecordInput() {
    console.log("check prerecord input");
    var prerecord_date = $("#prerecord_date");
    var prerecord_date_label = $("#prerecord_date_label");

    if(this.checked) {
        prerecord_date_label.show();
        prerecord_date.show();
        prerecord_date.prop('required', true);

    } else {
        prerecord_date_label.hide();
        prerecord_date.hide();
        prerecord_date.prop('required', false);
    }
}


