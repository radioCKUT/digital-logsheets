<?php

    include_once("readFromDatabase.php");
    class manageCategoryEntries {

        const TABLE_NAME = "category";

        const ID_COLUMN_NAME = "id";
        const CATEGORY_NAME_COLUMN_NAME = "name";


        public static function getCategoryNameFromDatabase($db_conn, $category_id) {
            return readFromDatabase::readFirstMatchingEntryFromTable($db_conn, array(self::CATEGORY_NAME_COLUMN_NAME),
                self::TABLE_NAME, array(self::ID_COLUMN_NAME), array($category_id));
        }


        public static function getAllCategoriesFromDatabase($db_conn) {
            $category_ids = readFromDatabase::readEntireColumnFromTable($db_conn, array(self::ID_COLUMN_NAME), self::TABLE_NAME);

            $categories = array();
            foreach($category_ids as $category_id) {
                $category = new Category($db_conn, $category_id[self::ID_COLUMN_NAME]);
                $categories[$category->getId()] = $category->getName();
            }

            return $categories;
        }
    }