<?php

    class writeToDatabase {

        public static function writeBlankValuesToDB($db_conn, $table_name) {
            $db_conn->query("INSERT INTO " . $table_name . "() VALUES ()");
            return $db_conn->lastInsertId();
        }

        public static function writeEntryToDatabase($db_conn, $table_name, $column_names, $values_to_write)
        {
            try {

                $column_names_string = "(" . implode(",", $column_names) . ")";

                for($i = 0; $i < count($values_to_write); $i++) {
                    if ($values_to_write[$i] == "") {
                        $values_to_write[$i] = "null";
                    }

                    /*if (strpos($values_to_write[$i],"0:") !== false) {
                        $values_to_write[$i] = "null";
                    }*/
                }

                $values_to_write_string = "('" . implode("','", $values_to_write) . "')";
                $query = "INSERT INTO " . $table_name . " " . $column_names_string . " VALUES " . $values_to_write_string;
                print "<br /> sending query: " . $query . "<br />";
                $db_conn->query($query);

                return $db_conn->lastInsertId();

            } catch (Exception $error) {
                echo "Write to database failed: " . $error;
            }

            return null; //TODO think more about what to return here
        }
    }
