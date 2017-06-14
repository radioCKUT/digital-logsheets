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
            //$hash = password_hash($password, PASSWORD_DEFAULT);

            $hash_password= hash('sha1', $password); //Password encryption
            //$stmt = $db->prepare("SELECT user.id,user.username,user.program,program.name FROM user INNER JOIN program ON user.program=program.id WHERE username=:username AND encrypedpw=:hash_password");

            $stmt = $db->prepare("SELECT id,username,program FROM user WHERE username=:username AND encrypedpw=:hash_password");
            $stmt->bindParam("username", $username,PDO::PARAM_STR) ;
            $stmt->bindParam("hash_password", $hash_password,PDO::PARAM_STR) ;
            $stmt->execute();
            $count = $stmt->rowCount();

            $db = null;

            if ($count){
                $data = $stmt->fetch(PDO::FETCH_OBJ);
                $_SESSION['id'] = $data->id; // Storing user session value
                $_SESSION['username'] = $data->username; // Storing user session value
                $_SESSION['program']=$data->program;
                $_SESSION['start'] = time(); // Taking now logged in time.
                // Ending a session in 30 minutes from the starting time.
                $_SESSION['expire'] = $_SESSION['start'] + (360 * 60);

                header('location:index.php');
                exit;
                //return true;

            } else {
                //$errMsg .= 'Username and Password are not found<br>';
                return false;
            }
        }
        catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }

    }


    public function UserDetails($user_id)
    {
        try {
            $db = getPDOStatementWithLogin();

            $query = $db->prepare("SELECT name FROM program INNER JOIN user ON program.id =
                                            (SELECT program FROM user WHERE id=:user_id)");
            $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_OBJ);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function register($username,$password,$encrytedpw,$program)
    {
        try
        {
            $db = getPDOStatementWithLogin();

            $new_password = password_hash($password, PASSWORD_DEFAULT);

            $query = $db->prepare("INSERT INTO user (username,password,encrytedpw,program) 
                                                       VALUES(:username, :password,:encrytedpw, :program)");

            $query->bindparam(":username", $username);
            $query->bindparam(":password", $password);
            $query->bindparam(":encrytedpw", $new_password);
            $query->bindparam(":program", $program);

            $query->execute();

            return $query;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }


}