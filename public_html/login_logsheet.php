<?php

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
			$url='index_login.php';
			header("Location: $url");
		}
		else
		{
			$errorMsgLogin="Please check login details.";
		}
	}
    //setcookie('username',$username,time()+(100*30),'/');
}

?>

<!DOCTYPE HTML>
<html> 
<head> 
<title>logsheet login</title> 
<body> 
	<div id="login">
		<h3>Login</h3>
        <?php
        if(isset($errMsg)){
            echo '<div>'.$errMsg.'</div>';
        }
        ?>
		<form method="post" action="" name="login">
			<label>Username</label>
			<input type="text" name="username" autocomplete="off" />
			<label>Password</label>
			<input type="password" name="password" autocomplete="off"/>
			<div class="errorMsg"><? echo $errorMsgLogin; ?></div>
			<input type="submit" class="button" name="loginSubmit" value="Login">
		</form>
	</div>

</body> 
</html> 
	
	