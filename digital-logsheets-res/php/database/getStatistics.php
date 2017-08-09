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

require_once("manageSegmentEntries.php");

class getStatistics {

    const END_TIME_PARAMETER = ":end_time";

    /**
     * @param PDO $db
     * @param $startDate
     * @param $endDate
     * @param $category
     * @return null
     */
    function getAllCanCon($db, $startDate, $endDate, $category) {
        try {
            $query = "SELECT sum(" . manageSegmentEntries::DURATION_COLUMN_NAME . ") " .
                "AS total_Can_duration," .
                    "(SELECT sum(" . manageSegmentEntries::DURATION_COLUMN_NAME . ") FROM " . manageSegmentEntries::TABLE_NAME . ") " .
                    "AS total_duration " .
                " FROM " . manageSegmentEntries::TABLE_NAME .
                " WHERE " . manageSegmentEntries::CAN_CON_COLUMN_NAME . " = 1" .
                    " AND "  . manageSegmentEntries::CATEGORY_COLUMN_NAME . " = '" . manageSegmentEntries::CATEGORY_PARAMETER . "'" .
                    " AND " . manageSegmentEntries::START_TIME_COLUMN_NAME . " BETWEEN " .
                        manageSegmentEntries::START_TIME_PARAMETER . " AND " . $this::END_TIME_PARAMETER . ";";

            $stmt = $db->prepare($query);

            $stmt->bindValue(manageSegmentEntries::CATEGORY_PARAMETER, $category, PDO::PARAM_STR);
            $stmt->bindValue(manageSegmentEntries::START_TIME_PARAMETER, $startDate, PDO::PARAM_STR);
            $stmt->bindValue(':enddate', $endDate, PDO::PARAM_STR);

            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


            foreach ($results as $rec) {
                $aObj = new CanConStatistic();
                $aObj->setRangeStart($startDate);
                $aObj->setRangeEnd($endDate);

                $aObj->setCategory($category);
                $aObj->setCanConDuration($rec["total_Can_duration"]);
                $aObj->setTotalDuration($rec["total_duration"]);

                array_push($arrAd, $aObj);
            }

            return $arrAd;

        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @param PDO $db
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    function getMostPlayedAlbum($db, $startDate, $endDate) {

        $counter = 0;
        $query = "SELECT " .
            manageSegmentEntries::ALBUM_COLUMN_NAME . ", " .
            manageSegmentEntries::AUTHOR_COLUMN_NAME . ", " .
            " COUNT(" . manageSegmentEntries::ID_COLUMN_NAME . ") AS id_count" .
            " FROM " . manageSegmentEntries::TABLE_NAME .
            " WHERE " . manageSegmentEntries::START_TIME_COLUMN_NAME . " BETWEEN " .
                manageSegmentEntries::START_TIME_PARAMETER . " AND " . $this::END_TIME_PARAMETER .
            " GROUP BY " .
                manageSegmentEntries::ALBUM_COLUMN_NAME . ", " . manageSegmentEntries::AUTHOR_COLUMN_NAME .
            " ORDER BY id_count DESC limit 30;";

        $stmt = $db->prepare($query);

        $stmt->bindParam(manageSegmentEntries::START_TIME_PARAMETER, $startDate);
        $stmt->bindParam($this::END_TIME_PARAMETER, $endDate);

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $arrAd = array();

        foreach ($results as $rec) {
            $aObj = new CountStatistic();
            $aObj->setRangeStart($startDate);
            $aObj->setRangeEnd($endDate);

            $aObj->setCount($rec["id_count"]);
            $aObj->setAlbum($rec["album"]);
            $aObj->setAuthor($rec["author"]);

            array_push($arrAd, $aObj);
        }

        return $arrAd;
    }


    /**
     * @param PDO $db
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    function getAdFrequency($db, $startDate, $endDate) {
        $counter = 0;
        $query = "SELECT COUNT(" . manageSegmentEntries::ID_COLUMN_NAME . ") as id_count, " .
            manageSegmentEntries::AD_NUMBER_COLUMN_NAME .
            " FROM " . manageSegmentEntries::TABLE_NAME .
            " WHERE " .  manageSegmentEntries::START_TIME_COLUMN_NAME .
                " BETWEEN " . manageSegmentEntries::START_TIME_PARAMETER .
                " AND " . $this::END_TIME_PARAMETER .
            " GROUP BY " . manageSegmentEntries::AD_NUMBER_COLUMN_NAME .
            " ORDER BY id_count DESC;";

        $stmt = $db->prepare($query);

        $stmt->bindParam(manageSegmentEntries::START_TIME_PARAMETER, $startDate);
        $stmt->bindParam($this::END_TIME_PARAMETER, $endDate);

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $arrAd = array();

        foreach ($results as $rec) {
            $aObj = new CountStatistic();
            $aObj->setRangeStart($startDate);
            $aObj->setRangeEnd($endDate);

            $aObj->setCount($rec["id_count"]);
            $aObj->setAdNumber($rec["ad_number"]);

            array_push($arrAd, $aObj);
        }

        return $arrAd;
    }
}
