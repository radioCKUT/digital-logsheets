<?php

    include_once("readFromDatabase.php");
    class manageCategoryEntries {

        const TABLE_NAME = "category";

        const ID_COLUMN_NAME = "id";
        const CATEGORY_NAME_COLUMN_NAME = "name";


        public static function getCategoryNameFromDatabase($dbConn, $categoryId) {
            return readFromDatabase::readFirstMatchingEntryFromTable($dbConn, array(self::CATEGORY_NAME_COLUMN_NAME),
                self::TABLE_NAME, array(self::ID_COLUMN_NAME), array($categoryId));
        }


        public static function getAllCategoriesFromDatabase($dbConn) {
            $categoryIds = readFromDatabase::readEntireColumnFromTable($dbConn, array(self::ID_COLUMN_NAME), self::TABLE_NAME);

            $categories = array();
            foreach($categoryIds as $categoryId) {
                $category = new Category($dbConn, $categoryId[self::ID_COLUMN_NAME]);
                $categories[$category->getId()] = $category->getName();
            }

            return $categories;
        }
    }