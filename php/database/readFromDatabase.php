<?php

    class readFromDatabase
    {
        private static function getEntireColumnQueryString($column_name, $table_name)
        {
            return "SELECT " . $column_name . " FROM " . $table_name;
        }

        public static function readEntireColumnFromTable($db_connection, $column_name, $table_name)
        {
            $sql_query_string = self::getEntireColumnQueryString($column_name, $table_name);
            $sql_query_stmt = $db_connection->prepare($sql_query_string);

            return self::readFromDatabaseWithStatement($sql_query_stmt);
        }

        public static function readFilteredColumnFromTable($db_connection, $column_name, $table_name, $filter_column, $filter_id_number)
        {
            $sql_query_string = self::getEntireColumnQueryString($column_name, $table_name) . " WHERE " . $filter_column . "=:id";
            $sql_query_stmt = $db_connection->prepare($sql_query_string);
            $sql_query_stmt->bindParam(":id", $filter_id_number, PDO::PARAM_INT);

            return self::readFromDatabaseWithStatement($sql_query_stmt);
        }

        public static function readFirstMatchingEntryFromTable($db_connection, $column_name, $table_name, $filter_column, $filter_id_number)
        {
            $all_matching_entries = self::readFilteredColumnFromTable($db_connection, $column_name, $table_name, $filter_column, $filter_id_number);
            return $all_matching_entries[0][$column_name];
        }

        private static function readFromDatabaseWithStatement($sql_query_stmt)
        {
            try {
                $sql_query_stmt->execute();
                $db_result = $sql_query_stmt->fetchAll(PDO::FETCH_ASSOC);

                return $db_result;

            } catch (Exception $error) {
                echo "Read from database failed: " . $error;
            }

            return null;
        }

    }