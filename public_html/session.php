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

/**
 * Created by PhpStorm.
 * User: baikdonghee
 * Date: 2017-05-25
 * Time: 11:05 AM
 */

session_start();

$session_uid = $_SESSION['id'];
$session_program = $_SESSION['program'];
$session_programName = $_SESSION['username'];


if(!isset($_SESSION['id'])){
    $url = 'login_logsheet.php';
    header("location: $url");
}else {
    $now = time(); // Checking the time now when home page starts.
    //echo $now.'<br/>';
    //echo $_SESSION['expire'];

    if ($now > $_SESSION['expire']) {

        echo '<script language="javascript">';
        echo 'alert("Your session has expired!")';
        echo '</script>';

        session_destroy();

        echo '<script language="javascript">';
        echo "window.location.href=\"login_logsheet.php\";\n";
        echo '</script>';

    }
}
