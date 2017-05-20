<?php
/**
 * Created by PhpStorm.
 * User: baikdonghee
 * Date: 2017-05-20
 * Time: 12:32 PM
 */

if(!empty($_SESSION['username']))
{
    $session_uid=$_SESSION['username'];
    include('../digital-logsheets-res/php/objects/User.php');
    $userClass = new User();
}
if(empty($session_uid))
{
    $url='index.php';
    header("Location: $url");
}
?>