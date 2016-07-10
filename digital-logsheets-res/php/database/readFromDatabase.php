<?php

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

        public static function readFirstMatchingEntryFromTable($dbConn, $columnNames, $tableName, $filterColumns, $filterValues)
        {
            $allMatchingEntries = self::readFilteredColumnFromTable($dbConn, $columnNames, $tableName, $filterColumns, $filterValues);
            return $allMatchingEntries[0][$columnNames[0]];
        }


    }