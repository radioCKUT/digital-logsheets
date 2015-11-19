<?php

    class readFromDatabase
    {
        private static function getEntireColumnQueryString($column_name, $table_name)
        {
            return "SELECT " . $column_name . " FROM " . $table_name;
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

        public static function readEntireColumnFromTable($db_connection, $column_name, $table_name)
        {
            $sql_query_string = self::getEntireColumnQueryString($column_name, $table_name);
            $sql_query_stmt = $db_connection->prepare($sql_query_string);

            return self::readFromDatabaseWithStatement($sql_query_stmt);
        }

        public static function readFilteredColumnFromTable($db_connection, $column_name, $table_name, $filter_columns, $filter_values)
        {
            $sql_query_string = self::getEntireColumnQueryString($column_name, $table_name);

            if (is_array($filter_columns) && is_array($filter_values) && count($filter_columns) != count($filter_values)) {
                return null;
            }

            for ($i = 0; $i < count($filter_columns); $i++) {
                $sql_query_string .= " WHERE " . $filter_columns[$i] . "=" . $filter_values[$i];
            }

            $sql_query_stmt = $db_connection->prepare($sql_query_string);

            return self::readFromDatabaseWithStatement($sql_query_stmt);
        }

        public static function readFirstMatchingEntryFromTable($db_connection, $column_name, $table_name, $filter_columns, $filter_values)
        {
            $all_matching_entries = self::readFilteredColumnFromTable($db_connection, $column_name, $table_name, $filter_columns, $filter_values);
            return $all_matching_entries[0][$column_name];
        }

    }