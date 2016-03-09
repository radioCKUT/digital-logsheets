<?php

    class readFromDatabase
    {
        private static function getEntireColumnsQueryString($column_names, $table_name)
        {

            if (!is_array($column_names) || count($column_names) <= 0) {
                return null; //TODO think more about what should be returned here
            }

            $column_names_string = implode(",", $column_names);

            return "SELECT " . $column_names_string . " FROM " . $table_name;
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

        public static function readEntireColumnFromTable($db_conn, $column_names, $table_name)
        {
            $sql_query_string = self::getEntireColumnsQueryString($column_names, $table_name);

            try {
                $sql_query_stmt = $db_conn->prepare($sql_query_string);

                return self::readFromDatabaseWithStatement($sql_query_stmt);
            } catch (Exception $e) {
                echo "Read entire column failed " . $e;
            }
        }

        public static function readFilteredColumnFromTable($db_conn, $column_names, $table_name, $filter_columns, $filter_values)
        {

            if (is_array($filter_columns) && is_array($filter_values) && count($filter_columns) != count($filter_values)) {
                return null; //TODO think more about what should be returned here
            }

            if ($column_names == null) {
                $column_names = "*"; //return all columns if no specific columns given
            }

            $sql_query_string = self::getEntireColumnsQueryString($column_names, $table_name);

            for ($i = 0; $i < count($filter_columns); $i++) {
                $sql_query_string .= " WHERE " . $filter_columns[$i] . "=" . $filter_values[$i];
            }

            try {
                $sql_query_stmt = $db_conn->prepare($sql_query_string);

                return self::readFromDatabaseWithStatement($sql_query_stmt);
            } catch (Exception $e) {
                echo "Read filtered column failed: " . $e;
            }
        }

        public static function readFirstMatchingEntryFromTable($db_conn, $column_names, $table_name, $filter_columns, $filter_values)
        {
            $all_matching_entries = self::readFilteredColumnFromTable($db_conn, $column_names, $table_name, $filter_columns, $filter_values);
            return $all_matching_entries[0][$column_names[0]];
        }

    }