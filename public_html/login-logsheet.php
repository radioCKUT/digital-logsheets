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

session_start();

include("../digital-logsheets-res/php/database/connectToDatabase.php");
require_once('../digital-logsheets-res/php/objects/User.php');

/* Login Form*/
$userClass = new User();
$errorMsgReg='';
$errorMsgLogin='';

if(isset($_POST['loginSubmit']))
{
    $errMsg = '';
    $username=$_POST['username'];
    $password=$_POST['password'];

    if($username == '')
        $errMsg .= 'You must enter your Username<br>';

    if($password == '')
        $errMsg .= 'You must enter your Password<br>';


    if(strlen(trim($username))>1 && strlen(trim($password))>1 )
    {
        $uid=$userClass->userLogin($username,$password);


        if($uid)
        {
            $url='index.php';
            header("Location: $url");
        }
        else
        {
            $errorMsgLogin="Please check login details.";
        }
    }
}

?>

<!DOCTYPE HTML>
<html>
<head>

    <title>logsheet login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: black;
            background: url(images/bg.png) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
<body>
<div id="login">
    <form method="post" action="" name="login" class="form-horizontal">
        <div class="row">
            <div class="col-sm-2 col-sm-offset-2">
                <h3>Digital Logsheets Login</h3>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="username">Username</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="username" autocomplete="off" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="password">Password</label>
            <div class="col-sm-2">
                <input type="password" class="form-control" name="password" autocomplete="off" />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2 col-sm-offset-2">
                <? echo '<div class="text-danger">'.$errorMsgLogin.'</div>'; ?>
                <?php
                if(isset($errMsg)){
                    echo '<p class="text-danger">'.$errMsg.'</p>';
                }
                ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-2 col-sm-offset-2">
                <input type="submit" class="btn btn-default" name="loginSubmit" value="Login">
            </div>
        </div>
    </form>
</div>
</body>
</html>

