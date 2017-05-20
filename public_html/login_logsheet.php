<?php

session_start();

include("../digital-logsheets-res/php/database/connectToDatabase.php");
include('../digital-logsheets-res/php/objects/User.php');

$userClass = new user();
$errorMsgReg='';
$errorMsgLogin='';

/* Login Form */
if (!empty($_POST['loginSubmit']))
{
	$username=$_POST['username'];
	$password=$_POST['password'];
	if(strlen(trim($username))>1 && strlen(trim($password))>1 )
	{
		$uid=$userClass->userLogin($username,$password);
		if($uid)
		{
			$url='index_test.php';
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
<body> 
	<div id="login">
		<h3>Login</h3>
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
	
	