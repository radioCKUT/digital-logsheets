<!DOCTYPE html>
<html>
    <head>
        <title>Dynamic Form Fields Test</title>
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            th, td {
                padding: 5px;
                text-align: left;
            }
        </style>
        <script>
            function addRow() {
                var table = document.getElementById("tracks");
                
                var row = table.insertRow(0);
                
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                
                cell1.innerHTML = "New Artist";
                cell2.innerHTML = "Song";
                cell3.innerHTML = "Album";
            }
        </script>
    </head>
    <body>
        <table id="tracks">
            <tr>
                <th>Artist</th>
                <th>Song</th>
                <th>Album</th>
            </tr>
            <tr>
                <td>Deadbeat</td>
                <td>Horns of Jericho</td>
                <td>Eight</td>
            </tr>
            <tr>
                <td>Michael Jackson</td>
                <td>Thriller</td>
                <td>Thriller</td>
            </tr>
            <tr>
                <td>Tipper</td>
                <td>Seamless Unspeakable</td>
                <td>Surrounded</td>
            </tr>
        </table>
        <button onClick="addRow()">Add a Row</button>
    </body>
</html>