//page starts with only 1 row initially
var numRows = 1;

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

    var segmentsList = document.getElementById("segments");
    segmentsList.appendChild(segment);
}

function addSegmentTimeInput(segment, segmentCount) {
    var segmentTime = document.createElement("input");
    segmentTime.id = "segment_time[" + segmentCount + "]";
    segmentTime.className = "form-control";
    segmentTime.type = "text";

    var segmentTimeLabel = document.createElement("label");
    segmentTimeLabel.htmlFor = "segment_time[" + segmentCount + "]";
    var segmentTimeLabelText = document.createTextNode("Time:");
    segmentTimeLabel.appendChild(segmentTimeLabelText);

    segment.appendChild(segmentTimeLabel);
    segment.appendChild(segmentTime);
}

function addCategoryInput(segment, segmentCount) {
    var categoryButtonsDiv = document.createElement("div");
    categoryButtonsDiv.className = "btn-group";
    categoryButtonsDiv.setAttribute("data-toggle", "buttons");

    for (var i = 1; i < 6; i++) {
        addCategoryButton(categoryButtonsDiv, i);
    }

    segment.appendChild(categoryButtonsDiv);
}

function addCategoryButton(categoryButtonsDiv, categoryCount) {

    var buttonLabel = document.createElement("label");
    buttonLabel.className = "btn btn-primary";

    var buttonInput = document.createElement("input");
    buttonInput.type = "radio";
    buttonInput.name = "category";
    buttonInput.id = "category" + categoryCount;
    buttonInput.autocomplete = "off";
    buttonInput.value = categoryCount;

    var buttonLabelText = document.createTextNode(categoryCount);

    buttonLabel.appendChild(buttonInput);
    buttonLabel.appendChild(buttonLabelText);

    categoryButtonsDiv.appendChild(buttonLabel);
}

window.onload = initialize;

function cloneRow(event) {
    //get the first row of the form
    var logsheetForm = document.getElementById("logsheet");
    var logsheetRow;

    if (event == null) {
        logsheetRow = document.getElementById("segment");
    } else {
        logsheetRow = event.target.parentNode;
    }

    console.log(logsheetRow);
    
    //copy the row node and its children
    var rowClone = logsheetRow.cloneNode(true);
    
    //remove the add button from the current row
    //logsheetRow.removeChild(logsheetRow.childNodes[7]);
    
    //insert new row
    logsheetForm.insertBefore(rowClone, logsheetRow.nextSibling)
    
    //update the row count
    numRows++;
}

function removeRow(event) {
    if (numRows>1) {
        var row = event.target.parentNode;
        row.parentNode.removeChild(row);
        numRows--;
    }
    
}