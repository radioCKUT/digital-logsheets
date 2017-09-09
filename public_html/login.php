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
require_once('../digital-logsheets-res/php/database/manageUserEntries.php');

require_once("../digital-logsheets-res/smarty/libs/Smarty.class.php");

$smarty = new Smarty;

$errMsg = '';

$username = $_POST['username'];
$password = $_POST['password'];

if (isset($_POST['loginSubmit']) && ($username == '' || $password == '')) {
    if ($username == '') {
        $errMsg .= 'You must enter your Username<br>';
    }

    if ($password == '') {
        $errMsg .= 'You must enter your Password<br>';
    }

} else if (strlen(trim($username)) > 1 && strlen(trim($password)) > 1) {

    $dbConn = connectToDatabase();
    $hash = hash('sha1', $password);
    $user = manageUserEntries::getUserFromUsernameAndPassword($dbConn, $username, $hash);


    if ($user != null) {
        setLoginSession($user);

        header("Location: index.php");
        exit();
    }
}

$smarty->assign("errMsg", $errMsg);
echo $smarty->fetch("../digital-logsheets-res/templates/login.tpl");


/**
 * @param User $user
 */
function setLoginSession($user) {
    $_SESSION['id'] = $user->getId();
    $program = $user->getProgram();
    $_SESSION['programName'] = $program->getName();
    $_SESSION['programId'] = $program->getId();
    $_SESSION['username'] = $user->getUsername();

    $_SESSION['start'] = time();
    // Set expiry to six hours
    $_SESSION['expire'] = $_SESSION['start'] + (6 * 60 * 60);
}