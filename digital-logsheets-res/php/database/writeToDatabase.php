<?php

    class writeToDatabase {

        public static function writeEntryToDatabase($db_conn, $table_name, $column_names, $values_to_write)
        {
            try {
                $column_names_string = "(" . implode(",", $column_names) . ")";
                $values_to_write_string = "('" . implode("','", $values_to_write) . "')";

                $query = "INSERT INTO " . $table_name . " " . $column_names_string . " VALUES " . $values_to_write_string;

                $db_conn->exec($query);

                return $db_conn->lastInsertId();

            } catch (Exception $error) {
                error_log("Write to database failed: " . $error);
                return null;
            }
        }

        public static function editDatabaseEntry($db_conn, $id_to_edit, $table_name, $column_names, $values_to_write) {
            try {

                $query = "UPDATE " . $table_name . " SET ";
                    for($i = 0; $i < count($column_names); $i++) {
                        $query .= $column_names[$i] . "=" . "'" . $values_to_write[$i] . "'";

                        if ($i < count($column_names) - 1) {
                            $query .= ", \n";
                        }
                    }
                $query .= " WHERE id=" . $id_to_edit;

                error_log("edit database query: " . $query);
                $db_conn->exec($query);

                return $db_conn->lastInsertId();

            } catch (Exception $error) {
                error_log("Edit database entry failed: " . $error);
                return null;
            }
        }

        /**
         * @param PDO $db_conn
         * @param int $id_to_delete
         * @param string $table_name
         */
        public static function deleteDatabaseEntry($db_conn, $id_to_delete, $table_name) {
            try {

                $query = "DELETE FROM " . $table_name . " WHERE id=" . $id_to_delete;
                error_log("delete query: " . $query);

                $db_conn->exec($query);

            } catch (Exception $error) {
                error_log("delete query unsuccessful: " . $error);
            }
        }
    }
