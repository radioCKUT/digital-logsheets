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

include_once(dirname(__FILE__) . "/../database/connectToDatabase.php");
require_once(dirname(__FILE__) . "/../objects/LogsheetComponent.php");


class User extends LogsheetComponent {

    private $username;
    private $password;

    /**
     * @var Program
     */
    private $program;


    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setProgram($program) {
        $this->program = $program;
    }



    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getProgram() {
        return $this->program;
    }




}






/*class User
{
    /**
     * @param $username
     * @param $password
     * @return bool
     *//*

    public function userLogin($username, $password)
    {
        try {
            $db = getPDOStatementWithLogin();
            //$hash = password_hash($password, PASSWORD_DEFAULT);

            $hash_password= hash('sha1', $password); //Password encryption

            $stmt = $db->prepare("SELECT id, username, program FROM user WHERE username=:username AND encryptedpw=:hash_password");
            $stmt->bindParam("username", $username,PDO::PARAM_STR) ;
            $stmt->bindParam("hash_password", $hash_password,PDO::PARAM_STR) ;
            $stmt->execute();
            $count = $stmt->rowCount();

            $db = null;

            if ($count){
                $data = $stmt->fetch(PDO::FETCH_OBJ);
                $_SESSION['id'] = $data->id; // Storing user session value
                $_SESSION['username'] = $data->username; // Storing user session value
                $_SESSION['program'] = $data->program;
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


    public function userDetails($user_id)
    {
        try {
            $db = getPDOStatementWithLogin();

            $query = $db->prepare("SELECT name FROM program INNER JOIN user ON program.id = " .
                                            "(SELECT program FROM user WHERE id=:user_id)");
            $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_OBJ);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
}*/