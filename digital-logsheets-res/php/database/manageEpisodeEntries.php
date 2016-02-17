<?php

    include_once("readFromDatabase.php");
    include_once("writeToDatabase.php");
    include_once("formatDateStrings.php");
    include_once(__DIR__ . "/../objects/logsheet-classes.php");


    class manageEpisodeEntries {

        private static $episodeTableName = "episode";

        private static $idColumnName = "id";
        private static $programColumnName = "program";
        private static $playlistColumnName = "playlist";
        private static $programmerColumnName = "programmer";
        private static $startTimeColumnName = "start_time";
        private static $endTimeColumnName = "end_time";

        private static $isPrerecordColumnName = "prerecord";
        private static $prerecordDateColumnName = "prerecord_date";
        private static $isDraftColumnName = "draft";


        public static function getEpisodeAttributesFromDatabase($db_conn, $episode_id, $episode_object) {
            $database_results = readFromDatabase::readFilteredColumnFromTable($db_conn, array(self::$programColumnName, self::$playlistColumnName,
                self::$programmerColumnName, self::$startTimeColumnName, self::$endTimeColumnName), self::$episodeTableName, array(self::$idColumnName), array($episode_id));

            $programId = $database_results[0][self::$programColumnName];
            $playlistId = $database_results[0][self::$playlistColumnName];
            $programmerId = $database_results[0][self::$programmerColumnName];

            $episode_object->setProgram(new Program($db_conn, $programId));
            $episode_object->setPlaylist(new Playlist($db_conn, $playlistId));
            $episode_object->setProgrammer(new Programmer($db_conn, $programmerId));


            $startTimeString = $database_results[0][self::$startTimeColumnName];
            $startDateTime = formatDateStringFromDatabase($startTimeString);
            $endTimeString = $database_results[0][self::$endTimeColumnName];
            $endDateTime = formatDateStringFromDatabase($endTimeString);

            $episode_object->setStartTime($startDateTime);
            $episode_object->setEndTime($endDateTime);
        }

        public static function getAllEpisodesFromDatabase($db_conn) {
            $episode_ids = readFromDatabase::readEntireColumnFromTable($db_conn, array(self::$idColumnName), self::$episodeTableName);

            $episodes = array();

            if(count($episode_ids)) {
                foreach($episode_ids as $episode_row) {
                    $episode = new Episode($db_conn, $episode_row[self::$idColumnName]);
                    $episodes[$episode->getId()] = $episode;
                }
            }

            return $episodes;
        }

        public static function saveNewEpisode($db_conn, $playlistId, $programId, $programmerId,
                                              $startDateTimeObject, $endDateTimeObject, $is_prerecord, $prerecord_date) {

            $startDateTimeObject = formatDateStringForDatabaseWrite($startDateTimeObject);
            $endDateTimeObject = formatDateStringForDatabaseWrite($endDateTimeObject);

            $column_names = array(self::$playlistColumnName, self::$programColumnName,
                self::$programmerColumnName, self::$startTimeColumnName, self::$endTimeColumnName,
                self::$isPrerecordColumnName, self::$prerecordDateColumnName, self::$isDraftColumnName);

            $values = array($playlistId, $programId, $programmerId, $startDateTimeObject,
                $endDateTimeObject, $is_prerecord, $prerecord_date, true);

            return writeToDatabase::writeEntryToDatabase($db_conn, self::$episodeTableName, $column_names, $values);
        }

        public static function turnOffEpisodeDraftStatus($db_conn, $episode_object) {
            $column_names = array(self::$isDraftColumnName);
            $values = array("false");

            error_log("turnOffEpisodeDraftStatus values[0]: " . $values[0]);

            return writeToDatabase::editDatabaseEntry($db_conn, $episode_object->getId(), self::$episodeTableName, $column_names, $values);
        }

    }