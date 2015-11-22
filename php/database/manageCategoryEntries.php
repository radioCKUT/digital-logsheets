<?php

    include_once("readFromDatabase.php");
    class manageCategoryEntries {

        private static $categoryTableName = "category";

        private static $idColumnName = "id";
        private static $categoryNameColumnName = "name";


        public static function getCategoryNameFromDatabase($db_conn, $category_id) {
            return readFromDatabase::readFirstMatchingEntryFromTable($db_conn, array(self::$categoryNameColumnName),
                manageCategoryEntries::$categoryTableName, array(manageCategoryEntries::$idColumnName), array($category_id));
        }


        public static function getAllCategoriesFromDatabase($db_conn) {
            $category_ids = readFromDatabase::readEntireColumnFromTable($db_conn, array(self::$idColumnName), self::$categoryTableName);

            $categories = array();
            foreach($category_ids as $category_id) {
                $category = new Category($db_conn, $category_id[self::$idColumnName]);
                $categories[$category->getId()] = $category->getName();
            }

            return $categories;
        }
    }