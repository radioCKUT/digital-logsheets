
<!DOCTYPE html>
<html>
<head>
    <title>
        Logsheets Retrieval
    </title>
    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="http://getbootstrap.com/dist/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" rel="stylesheet"/>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Boostrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>

    <script src="js/filterLogsheetList.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
    <style>
        #divs div {
         }
    </style>
    <script type="text/javascript">

        function init() {
            var data = {$programs};
            var $programSelect = $(".program");

            $programSelect.select2({
                data: data
            });

            $programSelect.on("change", function (e) {
                updateFilteredLogsheetList();
            } );
        }

        function updateFilteredLogsheetList() {
            var programNameFilterList = $(".program").select2('data').map(function (index, element) {
                console.log(index.text);
                return index.text;
            });

            var startDateFilter = $( "#startDateFilter" ).val();
            var endDateFilter = $( "#endDateFilter" ).val();

            var episodes = {$episodes|json_encode};

            filterLogsheetList(episodes, programNameFilterList, startDateFilter, endDateFilter);
        }

        $(function() {
            var $divs = $('#divs > div');

            $divs.first().show()
            $('input[type=radio]').on('change',function() {
                $divs.hide();
                $divs.eq( $('input[type=radio]').index( this ) ).show();
            });
        });

    </script>
</head>
<body onload="init()">
    <div class='container-fluid'>
         <div class="row " >
            <div class='container-fluid'>
                <div class="form-group">
                    <h3>Log Sheet Statistics</h3>
                </div>
            </div>
        </div>
<br>
        <div class="row">
            <div class="form-group">
                     <div class="col-sm-4" style="display: none;">
                        <label for="program" class="control-label">Program:</label>
                        <select class="form-control program" name="program" id="program" multiple="multiple"></select>
                    </div>

                <div class="col-sm-2">
                    <label for="startDateFilter" class="control-label">Start:</label>
                    <input type="date" id="startDateFilter" onchange="updateFilteredLogsheetList()">
                </div>
                <div class="col-sm-2">
                    <label for="endDateFilter" class="control-label">End:</label>
                    <input type="date" id="endDateFilter" onchange="updateFilteredLogsheetList()">
                </div>
                <!--div class="col-sm-2 ">
                    <input type="submit" class="btn btn-default" name="loginSubmit" value="Search">
                </div-->
            </div>
        </div>
        <br>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Canadian content</a></li>
            <li><a data-toggle="tab" href="#menu1">The 30 most-played-from albums</a></li>
            <li><a data-toggle="tab" href="#menu2">Frequency of a given advertisement</a></li>
            <li><a data-toggle="tab" href="#menu3">The number of station IDs</a></li>
        </ul>
<br>
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <div class="logsheets">
                    <br/>
                    <div class="row">
                        <div class="col-sm-8">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Program name </th>
                                    <th>Time</th>
                                    <th>%</th>
                                </tr>
                                </thead>
                                <tbody>
                                {foreach $segments as $segment}
                                    <tr>
                                        {if $segment.category == 2 || $segment.category == 3}
                                            <td>{$segment.name}</td>
                                            <td>{$segment.album}</td>
                                            <td>{$segment.artist}</td>

                                            <td colspan="3">{$segment.name}</td>
                                        {/if}

                                         <td>{$segment.canCon}</td>

                                    </tr>
                                {/foreach}


                                {foreach $episodes as $episode}
                                    <tr>
                                        <td>
                                             {$episode.program}
                                        <td>
                                        <td> {$episode.startDate}</td><td>%</td>
                                    </tr>
                                {/foreach}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
             </div>


            <div id="menu1" class="tab-pane fade">
                <div class="row">
                    <div class="col-sm-8">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>

                                <th> Album name</th>
                                <th> Artist</th>
                                <th> Number of time</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                                <td> Top album </td>
                                <td> David angel </td>
                                <td>08</td>
                            </tr>
                            <tr>

                                <td> Summer </td>
                                <td> Cool </td>
                                <td> 20</td>
                            </tr>
                            <tr>

                                <td> Three one two  </td>
                                <td> Teny  </td>
                                <td> 12</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
             </div>
            <div id="menu2" class="tab-pane fade">
                <div class="row">
                    <div class="col-sm-8">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                 <th>Advertisement number</th>
                                <th>Frequency </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                 <td> 2017-06-05</td>
                                <td> 4 </td>
                            </tr>
                            <tr>
                                 <td> 2017-05-25 </td>
                                <td> 5</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
             </div>
            <div id="menu3" class="tab-pane fade">
                <div class="row">
                    <div class="col-sm-8">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>The number of station IDs</th>
                                <th>Frequency</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                                <td> 0_d0s0_1</td>
                                <td> 4 </td>
                            </tr>
                            <tr>

                                <td> 1_d0s_12 </td>
                                <td> 5</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
             </div>
        </div>


    </div>

</body>
</html>
