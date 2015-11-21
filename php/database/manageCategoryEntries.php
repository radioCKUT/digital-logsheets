<?php

    include_once("readFromDatabase.php");
    class manageCategoryEntries {

        private static $tableName = "category";

        private static $idColumnName = "id";
        private static $categoryNameColumnName = "name";


        public static function getCategoryNameFromDatabase($db_connection, $category_id) {
            return readFromDatabase::readFirstMatchingEntryFromTable($db_connection, array(self::$categoryNameColumnName),
                manageCategoryEntries::$tableName, array(manageCategoryEntries::$idColumnName), array($category_id));
        }


        public static function getAllCategoriesFromDatabase($db_connection) {
            $category_ids = readFromDatabase::readEntireColumnFromTable($db_connection, array(self::$idColumnName), self::$tableName);

            $categories = array();
            foreach($category_ids as $category_id) {
                $category = new Category($db_connection, $category_id[self::$idColumnName]);
                $categories[$category->getId()] = $category->getName();
            }

            return $categories;
        }
    }