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


        private static function getEpisodeAttributeFromDatabase($db_connection, $attribute_column_name, $episode_id) {
            return readFromDatabase::readFirstMatchingEntryFromTable($db_connection, array($attribute_column_name),
                self::$episodeTableName, array(self::$idColumnName), array($episode_id));
        }

        public static function getEpisodeProgramFromDatabase($db_connection, $episode_id) {
            $program_id = self::getEpisodeAttributeFromDatabase($db_connection, self::$programColumnName, $episode_id);
            return new Program($db_connection, $program_id);
        }

        public static function getEpisodePlaylistFromDatabase($db_connection, $episode_id) {
            $playlist_id = self::getEpisodeAttributeFromDatabase($db_connection, self::$playlistColumnName, $episode_id);
            return new Playlist($db_connection, $playlist_id);
        }

        public static function getEpisodeProgrammerFromDatabase($db_connection, $episode_id) {
            $programmer_id = self::getEpisodeAttributeFromDatabase($db_connection, self::$programmerColumnName, $episode_id);
            return new Programmer($db_connection, $programmer_id);
        }

        public static function getEpisodeStartTimeFromDatabase($db_connection, $episode_id) {
            return self::getEpisodeAttributeFromDatabase($db_connection, self::$startTimeColumnName, $episode_id);
        }

        public static function getEpisodeEndTimeFromDatabase($db_connection, $episode_id) {
            return self::getEpisodeAttributeFromDatabase($db_connection, self::$endTimeColumnName, $episode_id);
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