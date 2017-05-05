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

class readFromDatabase
    {
        private static function getEntireColumnsQueryString($columnNames, $tableName)
        {
            if (!is_array($columnNames) || count($columnNames) <= 0) {
                $columnNamesString = "*";
            } else {
                $columnNamesString = implode(",", $columnNames);
            }

            return "SELECT " . $columnNamesString . " FROM " . $tableName;
        }


        private static function readFromDatabaseWithStatement($sqlQueryStmt)
        {
            try {
                $sqlQueryStmt->execute();
                $dbResult = $sqlQueryStmt->fetchAll(PDO::FETCH_ASSOC);

                return $dbResult;

            } catch (Exception $error) {
                error_log("Read from database failed: " . $error);
                return null;
            }
        }

        public static function readEntireColumnFromTable($dbConn, $columnNames, $tableName)
        {
            $sqlQueryString = self::getEntireColumnsQueryString($columnNames, $tableName);

            try {
                $sqlQueryStmt = $dbConn->prepare($sqlQueryString);
                return self::readFromDatabaseWithStatement($sqlQueryStmt);
                
            } catch (Exception $e) {
                error_log("Read entire column failed " . $e);
                return null;
            }
        }

    /**
     * @param PDO $dbConn
     * @param String[] $columnNames If value is null, return all columns.
     * @param String $tableName
     * @param String[] $filterColumns
     * @param array $filterValues
     * @return null
     */
        public static function readFilteredColumnFromTable($dbConn, $columnNames, $tableName, $filterColumns, $filterValues)
        {

            if (is_array($filterColumns) && is_array($filterValues) && count($filterColumns) != count($filterValues)) {
                return null;
            }

            $sqlQueryString = self::getEntireColumnsQueryString($columnNames, $tableName);

            for ($i = 0; $i < count($filterColumns); $i++) {
                $sqlQueryString .= "\n WHERE " . $filterColumns[$i] . "=" . $filterValues[$i];
            }

            try {
                $sqlQueryStmt = $dbConn->prepare($sqlQueryString);
                return self::readFromDatabaseWithStatement($sqlQueryStmt);
                
            } catch (Exception $e) {
                error_log("Read filtered column failed: " . $e);
                return null;
            }
        }


    /**
     * @param PDO $dbConn
     * @param $columnNames
     * @param $tableName
     * @param $filterColumn
     * @param $lowestValue
     * @param $highestValue
     * @return null
     */
        public static function readAllColumnsBetweenTwoValues($dbConn, $tableName, $filterColumn, $lowestValue, $highestValue) {

            $sqlQueryString = self::getEntireColumnsQueryString(null, $tableName);

            $sqlQueryString .= "\n WHERE " . $filterColumn . " between '" . $lowestValue . "' and '" . $highestValue . "'";

            try {
                $sqlQueryStmt = $dbConn->prepare($sqlQueryString);
                return self::readFromDatabaseWithStatement($sqlQueryStmt);

            } catch (Exception $e) {
                error_log("Read columns (between two values) failed: " . $e);
                return null;
            }
        }

        public static function readFirstMatchingEntryFromTable($dbConn, $columnNames, $tableName, $filterColumns, $filterValues)
        {
            try {
                $allMatchingEntries = self::readFilteredColumnFromTable($dbConn, $columnNames, $tableName, $filterColumns, $filterValues);
                return $allMatchingEntries[0][$columnNames[0]];
            } catch (Exception $e) {
                return null;
            }
        }


    }