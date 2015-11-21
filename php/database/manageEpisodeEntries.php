<?php

    include_once("readFromDatabase.php");
    include_once("writeToDatabase.php");
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


        public static function getEpisodeAttributesFromDatabase($db_connection, $episode_id, $episode_object) {
            $database_results = readFromDatabase::readFilteredColumnFromTable($db_connection, array(self::$programColumnName, self::$playlistColumnName,
                self::$programmerColumnName, self::$startTimeColumnName, self::$endTimeColumnName), self::$episodeTableName, array(self::$idColumnName), array($episode_id));

            $episode_object->setProgram(new Program($db_connection, $database_results[0][self::$programColumnName]));
            $episode_object->setPlaylist(new Playlist($db_connection, $database_results[0][self::$playlistColumnName]));
            $episode_object->setProgrammer(new Programmer($db_connection, $database_results[0][self::$programmerColumnName]));
            $episode_object->setStartTime($database_results[0][self::$startTimeColumnName]);
            $episode_object->setEndTime($database_results[0][self::$endTimeColumnName]);
        }

        public static function getAllEpisodesFromDatabase($db_connection) {
            $episode_ids = readFromDatabase::readEntireColumnFromTable($db_connection, array(self::$idColumnName), self::$episodeTableName);

            $episodes = array();

            if(count($episode_ids)) {
                foreach($episode_ids as $episode_row) {
                    $episode = new Episode($db_connection, $episode_row[self::$idColumnName]);
                    $episodes[$episode->getId()] = $episode;
                }
            }

            return $episodes;
        }

        public static function saveNewEpisode($db_conn, $playlistId, $programId, $programmerId, $start_time, $end_time, $is_prerecord, $prerecord_date) {

            $column_names = array(self::$playlistColumnName, self::$programColumnName,
                self::$programmerColumnName, self::$startTimeColumnName, self::$endTimeColumnName,
                self::$isPrerecordColumnName, self::$prerecordDateColumnName);

            $values = array($playlistId, $programId, $programmerId, $start_time,
                $end_time, $is_prerecord, $prerecord_date);


            writeToDatabase::writeEntryToDatabase($db_conn, self::$episodeTableName, $column_names, $values);
        }
    }