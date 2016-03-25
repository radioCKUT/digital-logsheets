<?php

    include_once("readFromDatabase.php");
    include_once("writeToDatabase.php");
    include_once("formatDateStrings.php");
    include_once(__DIR__ . "/../objects/logsheet-classes.php");


    class manageEpisodeEntries {

        const TABLE_NAME = "episode";

        const ID_COLUMN_NAME = "id";
        const PROGRAM_COLUMN_NAME = "program";
        const PLAYLIST_COLUMN_NAME = "playlist";
        const PROGRAMMER_COLUMN_NAME = "programmer";
        const START_TIME_COLUMN_NAME = "start_time";
        const END_TIME_COLUMN_NAME = "end_time";

        const IS_PRERECORD_COLUMN_NAME = "prerecord";
        const PRERECORD_COLUMN_NAME = "prerecord_date";
        const IS_DRAFT_COLUMN_NAME = "draft";

        /**
         * @param PDO $db_conn
         * @param int $episode_id
         * @param Episode $episode_object
         */
        public static function getEpisodeAttributesFromDatabase($db_conn, $episode_id, $episode_object) {
            $database_results = readFromDatabase::readFilteredColumnFromTable($db_conn, array(self::PROGRAM_COLUMN_NAME, self::PLAYLIST_COLUMN_NAME,
                self::PROGRAMMER_COLUMN_NAME, self::START_TIME_COLUMN_NAME, self::END_TIME_COLUMN_NAME), self::TABLE_NAME, array(self::ID_COLUMN_NAME), array($episode_id));

            $programId = $database_results[0][self::PROGRAM_COLUMN_NAME];
            $playlistId = $database_results[0][self::PLAYLIST_COLUMN_NAME];
            $programmerId = $database_results[0][self::PROGRAMMER_COLUMN_NAME];

            $episode_object->setProgram(new Program($db_conn, $programId));
            $episode_object->setPlaylist(new Playlist($db_conn, $playlistId));
            $episode_object->setProgrammer(new Programmer($db_conn, $programmerId));


            $startTimeString = $database_results[0][self::START_TIME_COLUMN_NAME];
            $startDateTime = formatDateStringFromDatabase($startTimeString);
            $endTimeString = $database_results[0][self::END_TIME_COLUMN_NAME];
            $endDateTime = formatDateStringFromDatabase($endTimeString);

            $episode_object->setStartTime($startDateTime);
            $episode_object->setEndTime($endDateTime);
        }

        public static function getAllEpisodesFromDatabase($db_conn) {
            $episode_ids = readFromDatabase::readEntireColumnFromTable($db_conn, array(self::ID_COLUMN_NAME), self::TABLE_NAME);

            $episodes = array();

            if(count($episode_ids)) {
                foreach($episode_ids as $episode_row) {
                    $episode = new Episode($db_conn, $episode_row[self::ID_COLUMN_NAME]);
                    $episodes[$episode->getId()] = $episode;
                }
            }

            return $episodes;
        }

        /**
         * @param PDO $db_conn
         * @param Episode $episode_object
         * @return null
         */
        public static function saveNewEpisode($db_conn, $episode_object) {

            $startDateTimeObject = formatDateStringForDatabaseWrite($episode_object->getStartTime());
            $endDateTimeObject = formatDateStringForDatabaseWrite($episode_object->getEndTime());

            $column_names = array(self::PLAYLIST_COLUMN_NAME, self::PROGRAM_COLUMN_NAME,
                self::PROGRAMMER_COLUMN_NAME, self::START_TIME_COLUMN_NAME, self::END_TIME_COLUMN_NAME,
                self::IS_PRERECORD_COLUMN_NAME, self::PRERECORD_COLUMN_NAME, self::IS_DRAFT_COLUMN_NAME);

            $values = array($episode_object->getPlaylist()->getId(),
                $episode_object->getProgram()->getId(),
                $episode_object->getProgrammer()->getId(),
                $startDateTimeObject, $endDateTimeObject,
                $episode_object->isPrerecord(),
                $episode_object->getPrerecordDate(), true);

            return writeToDatabase::writeEntryToDatabase($db_conn, self::TABLE_NAME, $column_names, $values);
        }

        public static function turnOffEpisodeDraftStatus($db_conn, $episode_object) {
            $column_names = array(self::IS_DRAFT_COLUMN_NAME);
            $values = array("false");

            error_log("turnOffEpisodeDraftStatus values[0]: " . $values[0]);

            return writeToDatabase::editDatabaseEntry($db_conn, $episode_object->getId(), self::TABLE_NAME, $column_names, $values);
        }

    }