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

require_once(dirname(__FILE__) . "/../objects/User.php");


class manageUserEntries {


    const TABLE_NAME = "user";

    const ID_COLUMN_NAME = "id";
    const ID_PARAMETER = ":id";


    const USERNAME_COLUMN_NAME = "username";
    const USERNAME_PARAMETER = ":username";

    const PROGRAM_COLUMN_NAME = "program";
    const PROGRAM_PARAMETER = ":program";

    const PASSWORD_COLUMN_NAME = "encryptedpw";
    const PASSWORD_PARAMETER = ":encryptedpw";


    /**
     * @param PDO $dbConn
     * @param $username
     * @param $hashedPassword
     * @return User $user
     */
    public static function getUserFromUsernameAndPassword($dbConn, $username, $hashedPassword) {
        $query = "SELECT " . self::ID_COLUMN_NAME . ", " . self::USERNAME_COLUMN_NAME . ", " . self::PROGRAM_COLUMN_NAME .
            " FROM " . self::TABLE_NAME . " WHERE " .
            self::USERNAME_COLUMN_NAME . "=" . self::USERNAME_PARAMETER . " AND " .
            self::PASSWORD_COLUMN_NAME . "=" . self::PASSWORD_PARAMETER;

        error_log("query: " . $query);

        $stmt = $dbConn->prepare($query);
        $stmt->bindParam(self::USERNAME_PARAMETER, $username,PDO::PARAM_STR);
        $stmt->bindParam(self::PASSWORD_PARAMETER, $hashedPassword,PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        error_log("result: " . print_r($result, true));


        if ($result != null) {
            $user = new User($dbConn, null);

            $user->setId($result[self::ID_COLUMN_NAME]);
            $user->setUsername($result[self::USERNAME_COLUMN_NAME]);
            $user->setPassword($result[self::PASSWORD_COLUMN_NAME]);
            $user->setProgram($result[self::PROGRAM_COLUMN_NAME]);

            return $user;

        } else {
            return null;
        }
    }
}
