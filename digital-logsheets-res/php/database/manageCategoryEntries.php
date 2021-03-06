<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2017  Evan Vassallo
 * Copyright (C) 2017 Donghee Baik
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

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