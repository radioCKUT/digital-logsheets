<!DOCTYPE html>
<html>
<head>
    <title>
        Logsheets Retrieval
    </title>
    {include "./header.tpl"}
    {include "./select2.tpl"}

    <script src="js/filterLogsheetList.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

    <script type="text/javascript">
        $(function() {
            var $divs = $('#divs').find('> div');

            $divs.first().show();

            $('input[type=radio]').on('change',function() {
                $divs.hide();
                $divs.eq( $('input[type=radio]').index( this ) ).show();
            });
        });

        $(document).ready(function(){
            $('.nav-tabs a').on('shown.bs.tab', function(event){
                var tab_id = $(event.target).attr('id');         // active tab
                $("#tab_id").val(tab_id);
            });
        });

    </script>
</head>
<body>
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
            <form action="#" method="get">
                <div class="col-sm-2">
                    <label for="startDateFilter" class="control-label">Start:</label>
                    <input type="date" name="startDateFilter" value="{if $search_submit} $start_date {/if}" >
                </div>
                <div class="col-sm-2">
                    <label for="endDateFilter" class="control-label">End:</label>
                    <input type="date" name="endDateFilter"  value="{if $search_submit} $end_date {/if}">
                </div>
                <div class="col-sm-2 ">
                    <input type="submit" class="btn btn-default" name="searchSubmit" value="Search">
                </div>
                <input type="hidden" name="tab_id" id="tab_id" value="$tab_id">
            </form>
        </div>
    </div>
    {if $err_msg}
        <div class="row">
            <div class="col-sm-6 col-sm-offset-2">

                <p class="text-danger">{$err_msg}</p>

            </div>
        </div>
    {/if}
    <br>
    <ul class="nav nav-tabs">
        <li {if ($tab_id == 'tab1' || !$tab_id || $tab_id == '')} class='active' {/if}><a data-toggle="tab" href="#home" id="tab1">Canadian content % </a></li>
        <li {if ($tab_id == 'tab2')} class='active' {/if}><a data-toggle="tab" href="#menu1" id="tab2">The 30 most-played-from albums</a></li>
        <li {if ($tab_id == 'tab3')} class='active' {/if}><a data-toggle="tab" href="#menu2" id="tab3">Frequency of a given advertisement</a></li>
    </ul>
    <br>
    <div class="tab-content">
        <div id="home" class="tab-pane fade {if ($tab_id == 'tab1' || !$tab_id || $tab_id == '')} inactive {/if}">
            <div class="logsheets">
                <br/>
                <div class="row">
                    <div class="col-sm-8">
                        <h4>Category 2 (General Music)</h4>
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>CanCon Songs Played</th>
                                <th>Total Songs Played</th>
                                <th>CanCon %</th>
                            </tr>
                            </thead>
                            <tbody>
                            {if ($search_submit && $start_date != '' && $end_date != '')}
                                <tr>
                                <td>{$general_can_con_duration}</td>
                                <td>{$general_total_duration}</td>
                                <td>{$general_percentage} %</td>
                                </tr>
                            {/if}
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-8">
                        <h4>Category 3 (Jazz, Classical, and Traditional Music)</h4>
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>CanCon Songs Played</th>
                                <th>Total Songs Played</th>
                                <th>CanCon %</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?

                            {if ($search_submit && $start_date != '' && $end_date != '')}
                                <tr>
                                    <td>{$jazz_can_con_duration}</td>
                                    <td>{$jazz_total_duration}</td>
                                    <td>{$jazz_percentage} %</td>
                                </tr>
                            {/if}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div id="menu1" class="tab-pane fade {if $tab_id == 'tab2'} inactive {/if}">
            <div class="row">
                <div class="col-sm-8">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>

                            <th>Album</th>
                            <th>Artist</th>
                            <th>Count</th>
                        </tr>
                        </thead>
                        <tbody>
                        {if ($search_submit && $start_date != '' && $end_date != '')}

                            {if $albums}
                                {foreach from=$albums item=album}
                                <tr>
                                    <td>{$album.album}</td>
                                    <td>{$album.author}</td>
                                    <td>{$album.count}</td>
                                </tr>
                                {/foreach}
                            {else}
                                <tr><td colspan="3">no data</td></tr>
                            {/if}

                        {/if}

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="menu2" class="tab-pane fade {if $tab_id == 'tab3'} inactive {/if}">
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
                        {if ($search_submit && $start_date != '' && $end_date != '')}

                            {if $ads}
                                {foreach from=$ads item=ad}
                                    <tr>
                                        <td>{$ad.adNumber}</td>
                                        <td>{$ad.count}</td>
                                    </tr>
                                {/foreach}
                            {else}
                                <tr><td colspan="2">no data</td></tr>
                            {/if}
                        {/if}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


</div>

</body>
</html>



