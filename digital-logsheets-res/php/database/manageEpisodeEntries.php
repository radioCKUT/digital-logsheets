<?php

    include_once("readFromDatabase.php");
    include_once("writeToDatabase.php");
    include_once("formatDateStrings.php");
    include_once(__DIR__ . "/../objects/logsheetClasses.php");


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
         * @param PDO $dbConn
         * @param int $episodeId
         * @param Episode $episodeObject
         */
        public static function getEpisodeAttributesFromDatabase($dbConn, $episodeId, $episodeObject) {
            $databaseResults = readFromDatabase::readFilteredColumnFromTable($dbConn, array(self::PROGRAM_COLUMN_NAME, self::PLAYLIST_COLUMN_NAME,
                self::PROGRAMMER_COLUMN_NAME, self::START_TIME_COLUMN_NAME, self::END_TIME_COLUMN_NAME), self::TABLE_NAME, array(self::ID_COLUMN_NAME), array($episodeId));

            $programId = $databaseResults[0][self::PROGRAM_COLUMN_NAME];
            $playlistId = $databaseResults[0][self::PLAYLIST_COLUMN_NAME];
            $programmerId = $databaseResults[0][self::PROGRAMMER_COLUMN_NAME];

            $episodeObject->setProgram(new Program($dbConn, $programId));
            $episodeObject->setPlaylist(new Playlist($dbConn, $playlistId));
            $episodeObject->setProgrammer(new Programmer($dbConn, $programmerId));


            $startTimeString = $databaseResults[0][self::START_TIME_COLUMN_NAME];
            $startDateTime = formatDateStringFromDatabase($startTimeString);
            $endTimeString = $databaseResults[0][self::END_TIME_COLUMN_NAME];
            $endDateTime = formatDateStringFromDatabase($endTimeString);

            $episodeObject->setStartTime($startDateTime);
            $episodeObject->setEndTime($endDateTime);
        }

        public static function getAllEpisodesFromDatabase($dbConn) {
            $episodeIds = readFromDatabase::readEntireColumnFromTable($dbConn, array(self::ID_COLUMN_NAME), self::TABLE_NAME);

            $episodes = array();

            if(count($episodeIds)) {
                foreach($episodeIds as $episodeRow) {
                    $episode = new Episode($dbConn, $episodeRow[self::ID_COLUMN_NAME]);
                    $episodes[$episode->getId()] = $episode;
                }
            }

            return $episodes;
        }

        /**
         * @param PDO $dbConn
         * @param Episode $episodeObject
         * @return null
         */
        public static function saveNewEpisode($dbConn, $episodeObject) {

            $startDateTimeObject = formatDateStringForDatabaseWrite($episodeObject->getStartTime());
            $endDateTimeObject = formatDateStringForDatabaseWrite($episodeObject->getEndTime());

            $columnNames = array(self::PLAYLIST_COLUMN_NAME, self::PROGRAM_COLUMN_NAME,
                self::PROGRAMMER_COLUMN_NAME, self::START_TIME_COLUMN_NAME, self::END_TIME_COLUMN_NAME,
                self::IS_PRERECORD_COLUMN_NAME, self::PRERECORD_COLUMN_NAME, self::IS_DRAFT_COLUMN_NAME);

            $values = array($episodeObject->getPlaylist()->getId(),
                $episodeObject->getProgram()->getId(),
                $episodeObject->getProgrammer()->getId(),
                $startDateTimeObject, $endDateTimeObject,
                $episodeObject->isPrerecord(),
                $episodeObject->getPrerecordDate(), true);

            return writeToDatabase::writeEntryToDatabase($dbConn, self::TABLE_NAME, $columnNames, $values);
        }

        public static function turnOffEpisodeDraftStatus($dbConn, $episodeObject) {
            $columnNames = array(self::IS_DRAFT_COLUMN_NAME);
            $values = array("false");

            error_log("turnOffEpisodeDraftStatus values[0]: " . $values[0]);

            return writeToDatabase::editDatabaseEntry($dbConn, $episodeObject->getId(), self::TABLE_NAME, $columnNames, $values);
        }

    }