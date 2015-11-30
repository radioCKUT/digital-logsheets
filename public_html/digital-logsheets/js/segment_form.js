function initialize() {
    var i;
    for (i = 0; i < 20; i++) {
        createNewSegmentForm(i);
    }
}

function createNewSegmentForm(segmentCount) {
    var segment = document.createElement("div");
    segment.id = "segment[" + segmentCount + "]";
    segment.className = "form-group";

    addSegmentTimeInput(segment, segmentCount);
    addCategoryInput(segment, segmentCount);
    addNameInput(segment, segmentCount);
    addAuthorInput(segment, segmentCount);
    addAlbumInput(segment, segmentCount);

    addCanConInput(segment, segmentCount);
    addNewReleaseInput(segment, segmentCount);
    addFrenchVocalMusicInput(segment, segmentCount);

    var horizontalRule = document.createElement("hr");
    segment.appendChild(horizontalRule);

    var segmentsList = document.getElementById("segments");
    segmentsList.appendChild(segment);
}

function getSegmentCountPostfix(segmentCount) {
    return "[" + segmentCount + "]";
}

function addSegmentTimeInput(segment, segmentCount) {

    var segmentTimeDiv = document.createElement("div");
    segmentTimeDiv.className = "form-group";

    var segmentTime = document.createElement("input");
    segmentTime.name = "segment_time" + getSegmentCountPostfix(segmentCount);
    segmentTime.id = segmentTime.name;
    segmentTime.className = "form-control";
    segmentTime.type = "time";

    var segmentTimeLabel = document.createElement("label");
    segmentTimeLabel.htmlFor = segmentTime.id;
    segmentTimeLabel.className = "control-label";
    var segmentTimeLabelText = document.createTextNode("Time:");
    segmentTimeLabel.appendChild(segmentTimeLabelText);

    segmentTimeDiv.appendChild(segmentTimeLabel);
    segmentTimeDiv.appendChild(segmentTime);

    segment.appendChild(segmentTimeDiv);
}

function addCategoryInput(segment, segmentCount) {

    var categoryInputDiv = document.createElement("div");
    categoryInputDiv.className = "form-group";

    var categoryButtonsDiv = document.createElement("div");
    categoryButtonsDiv.className = "btn-group";
    categoryButtonsDiv.id = "category" + getSegmentCountPostfix(segmentCount);
    categoryButtonsDiv.setAttribute("data-toggle", "buttons");

    for (var i = 1; i < 6; i++) {
        addCategoryButton(categoryButtonsDiv, i, segmentCount);
    }

    var categoryButtonsLabel = document.createElement("label");
    categoryButtonsLabel.htmlFor = categoryButtonsDiv.id;
    var categoryButtonsLabelText = document.createTextNode("Category:");
    categoryButtonsLabel.appendChild(categoryButtonsLabelText);

    categoryInputDiv.appendChild(categoryButtonsLabel);
    categoryInputDiv.appendChild(categoryButtonsDiv);
    segment.appendChild(categoryInputDiv);
}

function addCategoryButton(categoryButtonsDiv, categoryCount, segmentCount) {

    var buttonLabel = document.createElement("label");
    buttonLabel.className = "btn btn-primary";

    var buttonInput = document.createElement("input");
    buttonInput.type = "radio";
    buttonInput.name = "category" + getSegmentCountPostfix(segmentCount);
    buttonInput.id = "category" + categoryCount;
    buttonInput.autocomplete = "off";
    buttonInput.value = categoryCount;

    var buttonLabelText = document.createTextNode(categoryCount);

    buttonLabel.appendChild(buttonInput);
    buttonLabel.appendChild(buttonLabelText);

    categoryButtonsDiv.appendChild(buttonLabel);
}




function addNameInput(segment, segmentCount) {
    addTextInput("name", segment, segmentCount);
}

function addAuthorInput(segment, segmentCount) {
    addTextInput("author", segment, segmentCount);
}

function addAlbumInput(segment, segmentCount) {
    addTextInput("album", segment, segmentCount);
}

function addTextInput(name, segment, segmentCount) {

    var inputDiv = document.createElement("div");
    inputDiv.className = "form-group";

    var input = document.createElement("input");
    input.className = "form-control";
    input.type = "text";
    input.name = name + getSegmentCountPostfix(segmentCount);
    input.id = input.name;

    var inputLabel = document.createElement("label");
    inputLabel.htmlFor = input.id;
    var inputLabelText = document.createTextNode(name.charAt(0).toUpperCase() + name.slice(1) + ":");
    inputLabel.appendChild(inputLabelText);

    inputDiv.appendChild(inputLabel);
    inputDiv.appendChild(input);

    segment.appendChild(inputDiv);
}



function addCanConInput(segment, segmentCount) {
    addCheckbox("can_con", "CC", segment, segmentCount);
}

function addNewReleaseInput(segment, segmentCount) {
    addCheckbox("new_release", "NR", segment, segmentCount);
}

function addFrenchVocalMusicInput(segment, segmentCount) {
    addCheckbox("french_vocal_music", "FV", segment, segmentCount);
}

function addCheckbox(name, label, segment, segmentCount) {

    var checkboxLabel = document.createElement("label");
    checkboxLabel.className = "checkbox-inline";

    var checkboxInput = document.createElement("input");
    checkboxInput.type = "checkbox";
    checkboxInput.name = name + getSegmentCountPostfix(segmentCount);
    checkboxInput.id = checkboxInput.name;
    checkboxInput.value = "";

    var checkboxLabelText = document.createTextNode(label);

    checkboxLabel.appendChild(checkboxInput);
    checkboxLabel.appendChild(checkboxLabelText);

    segment.appendChild(checkboxLabel);
}

window.onload = initialize;