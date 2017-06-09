
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
                        <form>
                            <div class="radio">
                                <label><input type="radio" name="optradio" value="radio1" checked>Canadian content per category </label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="optradio" value="radio2">The 30 most-played-from albums</label>
                            </div>
                            <div class="radio ">
                                <label><input type="radio" name="optradio" value="radio3">Frequency of a given advertisement</label>
                            </div>
                            <div class="radio ">
                                <label><input type="radio" name="optradio" value="radio4">The number of station IDs </label>
                            </div>
                        </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                {if $program_id != null}
                    <div class="col-sm-4 " style="display: none">
                        <label for="program" class="control-label">Program:</label>
                        <select class="form-control program" name="program" id="program" multiple="multiple"></select>
                    </div>
                {/if}
                {if $program_id == null}
                    <div class="col-sm-4">
                        <label for="program" class="control-label">Program:</label>
                        <select class="form-control program" name="program" id="program" multiple="multiple"></select>
                    </div>
                {/if}

                <div class="col-sm-2">
                    <label for="startDateFilter" class="control-label">Start:</label>
                    <input type="date" id="startDateFilter" onchange="updateFilteredLogsheetList()">
                </div>
                <div class="col-sm-2">
                    <label for="endDateFilter" class="control-label">End:</label>
                    <input type="date" id="endDateFilter" onchange="updateFilteredLogsheetList()">
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="form-group">
                <div class="col-sm-2 ">
                    <input type="submit" class="btn btn-default" name="loginSubmit" value="Search">
                </div>
            </div>
        </div>
        <br>
        <!-- Canadian content per category -->
        <div id="divs"" >
            <div id="div1" >
                <div id="category_group{$idSuffix}" class="form-group category_group">
                <label for="category" class="control-label">Category:</label>
                <div class="btn-group" class="category" id="category" data-toggle="buttons"> {*Need double class attribute for Bootstrap tooltip to work correctly*}
                    <label class="btn btn-primary"
                           onclick="setupCat1Fields({if $idSuffix == '_edit'} true {else} false {/if})"
                           data-toggle="tooltip" data-placement="bottom"
                           title="All Spoken Word">
                        <input type="radio" name="category" class="category1" autocomplete="off" required value="1">1
                    </label>

                    <label class="btn btn-primary"
                           onclick="setupCat2Fields({if $idSuffix == '_edit'} true {else} false {/if})"
                           data-toggle="tooltip" data-placement="bottom"
                           title="General Music">
                        <input type="radio" name="category" class="category2" autocomplete="off" value="2">2
                    </label>

                    <label class="btn btn-primary"
                           onclick="setupCat3Fields({if $idSuffix == '_edit'} true {else} false {/if})"
                           data-toggle="tooltip" data-placement="bottom"
                           title="Jazz, Classical, and Traditional Music">
                        <input type="radio" name="category" class="category3" autocomplete="off" value="3">3
                    </label>

                    <label class="btn btn-primary"
                           onclick="setupCat4Fields({if $idSuffix == '_edit'} true {else} false {/if})"
                           data-toggle="tooltip" data-placement="bottom"
                           title="Musical Productions (ID's, etc.)">
                        <input type="radio" name="category" class="category4" autocomplete="off" value="4">4
                    </label>

                    <label class="btn btn-primary"
                           onclick="setupCat5Fields({if $idSuffix == '_edit'} true {else} false {/if})"
                           data-toggle="tooltip"  data-placement="bottom"
                           title="Ads, Promos">
                        <input type="radio" name="category" class="category5" autocomplete="off" value="5">5
                    </label>

                    <span id="category_help_block{$idSuffix}" class="help-block hidden">
                            Please select a category.
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Description</th>
                            <th>Time</th>
                            <th>%</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td> Description</td>
                            <td> 46</td>
                            <td> 46%</td>
                        </tr>
                        <tr>
                            <td> Description</td>
                            <td> 1</td>
                            <td> 1% </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

            <!-- The 30 most-played-from albums -->
            <div id="div2" style="display: none;">
            <div class="row">
                <div class="col-sm-8">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>30 most played albums</th>
                            <th> artist</th>
                            <th>Number of time</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td> 1</td>
                            <td> Top album </td>
                            <td> David angel </td>
                            <td>08</td>
                        </tr>
                        <tr>
                            <td> 2</td>
                            <td> Summer </td>
                            <td> Cool </td>
                            <td> 20</td>
                        </tr>
                        <tr>
                            <td> 3</td>
                            <td> Three one two  </td>
                            <td> Teny  </td>
                            <td> 12</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <!--Frequency of a given advertisement-->
            <div id="div3" style="display: none;">
        <br/>
            <div class="row">
                <div class="col-sm-8">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Episode</th>
                            <th>Advertisement number</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td> 1</td>
                            <td> 2017-06-05</td>
                            <td> 4 </td>
                        </tr>
                        <tr>
                            <td> 2</td>
                            <td> 2017-05-25 </td>
                            <td> 5</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--The number of station IDs-->

            <div id="div4" style="display: none;">
            <div class="row">
                <div class="col-sm-8">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Episode</th>
                            <th>The number of station IDs</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td> 1</td>
                            <td> 2017-06-05</td>
                            <td> 4 </td>
                        </tr>
                        <tr>
                            <td> 2</td>
                            <td> 2017-05-25 </td>
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
