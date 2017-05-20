<?php

/**
 * Created by PhpStorm.
 * User: baikdonghee
 * Date: 2017-05-20
 * Time: 7:55 AM
 */
include_once(dirname(__FILE__) . "/../database/connectToDatabase.php");

class User
{
    /**
     * @param $username
     * @param $password
     * @return bool
     */
    public function userLogin($username, $password)
    {
        try {
            $db = getPDOStatementWithLogin();
            //$hash_password=hash('admin1234', $password); //Password encryption
            //$stmt = $db->prepare("SELECT username FROM user WHERE username=:username AND password=:hash_password");

            $stmt = $db->prepare("SELECT username FROM user WHERE username=:username AND password=:password");
            $stmt->bindParam("username", $username,PDO::PARAM_STR) ;
            $stmt->bindParam("password", $password,PDO::PARAM_STR) ;

            //$stmt->bindParam("hash_password", $hash_password,PDO::PARAM_STR) ;
            $stmt->execute();
            $count = $stmt->rowCount();

            $db = null;

            if ($count) {
                $data = $stmt->fetch(PDO::FETCH_OBJ);
                $_SESSION['username'] = $data->username; // Storing user session value
                return true;

            } else {
                return false;
            }
        }
        catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }

    }



    /* User Details */
    public function userDetails($uname)
    {
        try{
            $db = getPDOStatementWithLogin();
            $stmt = $db->prepare("SELECT username FROM users WHERE username=:uname");
            $stmt->bindParam("uid", $uname,PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_OBJ); //User data
            return $data;
        }
        catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }
}