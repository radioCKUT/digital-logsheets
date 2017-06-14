<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2017  Evan Vassallo
 * Copyright (C) 2017 Donghee Baik
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/*
 * Created by PhpStorm.
 * User: baikdonghee
 * Date: 2017-06-05
 * Time: 10:47 AM
 *
 */
//----INCLUDE FILES----
include('../digital-logsheets-res/smarty/libs/Smarty.class.php');
include("../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../digital-logsheets-res/php/objects/logsheetClasses.php");
require_once("../digital-logsheets-res/php/DataPreparationForUI.php");
include('../digital-logsheets-res/php/objects/User.php');
include('../digital-logsheets-res/php/objects/Statistic.php');

include('session.php');

$userClass = new User();
$userDetails = $userClass->userDetails($session_uid); // get user details
//logout
echo "<div class='row'>
                <div class='container-fluid'>
                    <h5 class='col-sm-7'><a href='logout.php'>Logout</a></h5>
                </div>
               </div>";

if ($session_program == null) {
    echo "<div class='row'>
                    <div class='container-fluid'> 
                    <div class='col-sm-2'><h3>Admin</h3></div></div></div>";
} else {
    // user information
    echo "<div class='row'>
                    <div class='container-fluid'>";
    echo "<h4 class='col-sm-7'>Show  name :" . $userDetails->name . "</h4> ";
    echo "</div></div>";
}

if(isset($_GET['searchSubmit'])) {
    $errMsg = '';
    $startdate = $_GET['startDateFilter'];
    $enddate = $_GET['endDateFilter'];

    $category = '';

    if ($startdate == 0||$enddate == 0)
    $errMsg .= 'Select the date<br>';

    if ($startdate != 0 && $enddate != 0 && $startdate >= $enddate)
            $errMsg .= 'Select the start date eariler than end date <br>';

}
?>

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
                    <input type="date" name="startDateFilter" value="<? if(isset($_GET['searchSubmit'])) echo $startdate;?>" >
                </div>
                <div class="col-sm-2">
                    <label for="endDateFilter" class="control-label">End:</label>
                    <input type="date" name="endDateFilter"  value="<? if(isset($_GET['searchSubmit'])) echo $enddate;?>" >
                </div>
                <div class="col-sm-2 ">
                    <input type="submit" class="btn btn-default" name="searchSubmit" value="Search">
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-2">
            <? echo '<div class="text-danger">'.$errorMsgLogin.'</div>'; ?>
            <?php
            if(isset($errMsg)){
                echo '<p class="text-danger">'.$errMsg.'</p>';
            }
            ?>


        </div>
    </div>
    <br>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Canadian content  </a></li>
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
                                <th>Canadien contents album for general music</th>
                                <th>Duration</th>
                                <th>%</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            if(isset($_GET['searchSubmit']) && $startdate!='' && $enddate!='') {
                                $totalDuration = 0;
                                $category='2';
                                $arObj = new Statistic();
                                $listOfCan_con = $arObj->getAllCan_Con($db, $startdate, $enddate, $category);

                                if (isset($listOfCan_con)) {
                                    foreach ($listOfCan_con as $oneCad_con) {
                                        $totalDuration += $oneCad_con->getApprox_duration_mins();
                                    }

                                    foreach ($listOfCan_con as $oneCad_con) {
                                        $percentage = round(10000*$oneCad_con->getApprox_duration_mins()/$totalDuration)/100;
                                        echo "<tr>";
                                        echo "<tr><td>" . $oneCad_con->getAlbum() . "</td><td>" . $oneCad_con->getApprox_duration_mins() . "</td><td>" . $percentage . " %</td>";

                                        echo "</tr>";
                                    }
                                }else {
                                    echo '<tr><td colspan="3"> no data </td></tr>';
                                }
                            }

                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-8">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Canadien contents album for Jazz,Classical and traditional music</th>
                                <th>Duration</th>
                                <th>%</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(isset($_GET['searchSubmit']) && $startdate!='' && $enddate!='') {
                                $totalDuration = 0;
                                $category='3';
                                $arObj = new Statistic();
                                $listOfCan_con = $arObj->getAllCan_Con($db, $startdate, $enddate,$category);
                                if (isset($listOfCan_con)) {
                                    foreach ($listOfCan_con as $oneCad_con) {
                                        $totalDuration += $oneCad_con->getApprox_duration_mins();
                                    }

                                    foreach ($listOfCan_con as $oneCad_con) {
                                        $percentage = round(10000*$oneCad_con->getApprox_duration_mins()/$totalDuration)/100;
                                        echo "<tr>";
                                        echo "<tr><td>" . $oneCad_con->getAlbum() . "</td><td>" . $oneCad_con->getApprox_duration_mins() . "</td><td>" . $percentage . " %</td>";
                                        // echo count($data['id']) . '<br>';

                                        echo "</tr>";
                                    }
                                }else{
                                    echo '<tr><td colspan="3">no data</td></tr>';
                                }
                            }

                            ?>
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

                            <th> Album</th>
                            <th> Artist</th>
                            <th> Number of time </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(isset($_GET['searchSubmit']) && $startdate!='' && $enddate!='') {

                            $arObj = new Statistic();
                            $listOfCan_30 = $arObj->getMostPlayedAlbum($db, $startdate, $enddate);
                            if (isset($listOfCan_con)) {
                                foreach ($listOfCan_30 as $oneCad_30) {
                                    echo "<tr>";
                                    echo "<tr><td>" . $oneCad_30->getAlbum() . "</td><td>" . $oneCad_30->getAuthor() . "</td><td>" . $oneCad_30->getId() . "</td><td></td>";
                                    echo "</tr>";
                                }
                            }else{
                                echo '<tr><td colspan="3">no data</td></tr>';
                            }
                        }
                        ?>

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
                        <?php
                        if(isset($_GET['searchSubmit']) && $startdate!='' && $enddate!='') {
                            $arObj = new Statistic();
                            $listOfAd=$arObj->getAdFrequency($db,$startdate, $enddate);
                            if (isset($listOfCan_con)) {
                                foreach ($listOfAd as $oneAd) {
                                    echo"<tr>";
                                    echo "<tr><td>".$oneAd->getAd_number() . "</td><td>".$oneAd->getId()."</td><td>";
                                }
                            }else{
                                echo '<tr><td colspan="2">no data</td></tr>';
                            }
                        }
                        ?>
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
                        <?php
                        if(isset($_GET['searchSubmit']) && $startdate!='' && $enddate!='') {
                            $arObj = new Statistic();
                            $listOfAd = $arObj->getAllStationId($db,$startdate, $enddate);
                            if (isset($listOfCan_con)) {

                                foreach ($listOfAd as $oneAd) {
                                    echo "<tr>";
                                    echo "<tr><td>" . $oneAd->getAd_number() . "</td><td>" . $oneAd->getId() . "</td><td>";
                                }
                            } else {
                                echo '<tr><td colspan="2">no data</td></tr>';
                            }
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>

</body>
</html>



