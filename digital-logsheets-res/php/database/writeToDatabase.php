<?php

    class writeToDatabase {

        public static function writeEntryToDatabase($dbConn, $tableName, $columnNames, $valuesToWrite)
        {
            try {
                $columnNamesString = "(" . implode(",", $columnNames) . ")";
                $valuesToWriteString = "('" . implode("','", $valuesToWrite) . "')";

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
                    for($i = 0; $i < count($columnNames); $i++) {
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
