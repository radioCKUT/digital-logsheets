//page starts with only 1 row initially
var numRows = 1;

function cloneRow(event) {
    //get the first row of the form
    var logsheetForm = document.getElementById("logsheet");
    var logsheetRow = event.target.parentNode;
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