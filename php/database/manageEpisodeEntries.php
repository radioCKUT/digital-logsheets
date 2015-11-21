<?php

    include_once("readFromDatabase.php");
    class manageEpisodeEntries {

        private static $episodeTableName = "episode";

        private static $idColumnName = "id";
        private static $programColumnName = "program";
        private static $playlistColumnName = "playlist";
        private static $programmerColumnName = "programmer";
        private static $startTimeColumnName = "start_time";
        private static $endTimeColumnName = "end_time";


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
    }