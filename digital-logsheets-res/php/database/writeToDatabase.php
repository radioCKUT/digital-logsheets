<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2017  Evan Vassallo
 * Copyright (C) 2016-2017  James Wang
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

class writeToDatabase {

        public static function writeEntryToDatabase($dbConn, $tableName, $columnNames, $valuesToWrite)
        {
            try {
                $columnNamesString = "(" . implode(", ", $columnNames) . ")";
                $valuesToWriteString = "(";

                for ($valueIndex = 0; $valueIndex < count($valuesToWrite); $valueIndex++) {
                    $valueToWrite = $valuesToWrite[$valueIndex];

                    if (is_null($valueToWrite)) {
                        $valuesToWriteString .= "NULL";
                    } else {
                        $valuesToWriteString .= "'" . $valueToWrite . "'";
                    }

                    if ($valueIndex < (count($valuesToWrite) - 1)) {
                        $valuesToWriteString .= ", \n";
                    }
                }

                $valuesToWriteString .= ")";

                $query = "INSERT INTO " . $tableName . " " . $columnNamesString . " VALUES " . $valuesToWriteString;
                $dbConn->exec($query);

                return $dbConn->lastInsertId();

            } catch (Exception $error) {
                error_log("Write to database failed: " . $error);
                return null;
            }
        }

        public static function editDatabaseEntry($dbConn, $idToEdit, $tableName, $columnNames, $valuesToWrite) {
            try {

                $query = "UPDATE " . $tableName . " SET ";
                    for ($i = 0; $i < count($columnNames); $i++) {
                        $query .= $columnNames[$i] . "=" . "'" . $valuesToWrite[$i] . "'";

                        if ($i < count($columnNames) - 1) {
                            $query .= ", \n";
                        }
                    }
                $query .= " WHERE id=" . $idToEdit;

                error_log("edit database query: " . $query);
                $dbConn->exec($query);

                return $dbConn->lastInsertId();

            } catch (Exception $error) {
                error_log("Edit database entry failed: " . $error);
                return null;
            }
        }

        /**
         * @param PDO $dbConn
         * @param int $idToDelete
         * @param string $tableName
         */
        public static function deleteDatabaseEntry($dbConn, $idToDelete, $tableName) {
            try {

                $query = "DELETE FROM " . $tableName . " WHERE id=" . $idToDelete;
                error_log("delete query: " . $query);

                $dbConn->exec($query);

            } catch (Exception $error) {
                error_log("delete query unsuccessful: " . $error);
            }
        }
    }
