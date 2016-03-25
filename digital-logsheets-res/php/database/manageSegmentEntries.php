<?php

    include_once("readFromDatabase.php");
    include_once("writeToDatabase.php");
    include_once("managePlaylistEntries.php");
    include_once(__DIR__ . "/../objects/Segment.php");

    class manageSegmentEntries {

        const TABLE_NAME = "segment";

        const ID_COLUMN_NAME = "id";
        const SEGMENT_NAME_COLUMN_NAME = "name";
        const ALBUM_COLUMN_NAME = "album";
        const AUTHOR_COLUMN_NAME = "author";

        const START_TIME_COLUMN_NAME = "start_time";
        const DURATION_COLUMN_NAME = "approx_duration_mins";
        const CATEGORY_COLUMN_NAME = "category";

        const CAN_CON_COLUMN_NAME = "can_con";
        const NEW_RELEASE_COLUMN_NAME = "new_release";
        const FRENCH_VOCAL_MUSIC_COLUMN_NAME = "french_vocal_music";

        /**
         * @param PDO $db_conn
         *
         * @param int $segment_id
         *
         * @param Segment $segment_object
         *
         */
        public static function getSegmentAttributesFromDatabase($db_conn, $segment_id, $segment_object) {
            $database_result = readFromDatabase::readFilteredColumnFromTable($db_conn, null, self::TABLE_NAME, array(self::ID_COLUMN_NAME), array($segment_id));


            $segment_name = $database_result[0][self::SEGMENT_NAME_COLUMN_NAME];
            $segment_object->setName($segment_name);

            $segment_album = $database_result[0][self::ALBUM_COLUMN_NAME];
            $segment_object->setAlbum($segment_album);

            $segment_author = $database_result[0][self::AUTHOR_COLUMN_NAME];
            $segment_object->setAuthor($segment_author);

            $segment_category = $database_result[0][self::CATEGORY_COLUMN_NAME];
            $segment_object->setCategory($segment_category);

            $segment_duration = $database_result[0][self::DURATION_COLUMN_NAME];
            $segment_object->setDuration($segment_duration);

            $segment_can_con = $database_result[0][self::CAN_CON_COLUMN_NAME];
            $segment_object->setIsCanCon($segment_can_con);

            $segment_new_release = $database_result[0][self::NEW_RELEASE_COLUMN_NAME];
            $segment_object->setIsNewRelease($segment_new_release);

            $segment_french_vocal_music = $database_result[0][self::FRENCH_VOCAL_MUSIC_COLUMN_NAME];
            $segment_object->setIsFrenchVocalMusic($segment_french_vocal_music);

            $dbStartTimeString = $database_result[0][self::START_TIME_COLUMN_NAME];
            $startDateTime = formatDateStringFromDatabase($dbStartTimeString);
            $segment_object->setStartTime($startDateTime);
        }

        /**
         * @param PDO $db_conn
         *
         * @param Segment $segment_object
         *
         */
        public static function editExistingSegmentDuration($db_conn, $segment_object) {
            $column_names = array(self::DURATION_COLUMN_NAME);
            $values = array($segment_object->getDuration());

            error_log("segment duration: " . $segment_object->getDuration());

            writeToDatabase::editDatabaseEntry($db_conn, $segment_object->getId(), self::TABLE_NAME, $column_names, $values);
        }

        /**
         * @param PDO $db_conn
         *
         * @param Segment $segment_object
         *
         * @return int
         */
        public static function saveNewSegmentToDatabase($db_conn, $segment_object)
        {
            list($column_names, $values) = self::processSegmentForWrite($segment_object);
            $segmentId = writeToDatabase::writeEntryToDatabase($db_conn, self::TABLE_NAME, $column_names, $values);

            managePlaylistEntries::addSegmentToDatabasePlaylist($db_conn, $segment_object->getPlaylistId(), $segmentId);

            return $segmentId;
        }

        /**
         * @param PDO $db_conn
         * @param Segment $segment_object
         */
        public static function editSegmentInDatabase($db_conn, $segment_object)
        {
            list($column_names, $values) = self::processSegmentForWrite($segment_object);

            writeToDatabase::editDatabaseEntry($db_conn, $segment_object->getId(), self::TABLE_NAME, $column_names, $values);
        }

        /**
         * @param Segment $segment_object
         * @return array
         */
        private static function processSegmentForWrite($segment_object)
        {
            $startDateString = formatDateStringForDatabaseWrite($segment_object->getStartTime());

            $column_names = array(self::START_TIME_COLUMN_NAME, self::DURATION_COLUMN_NAME, self::SEGMENT_NAME_COLUMN_NAME,
                self::AUTHOR_COLUMN_NAME, self::ALBUM_COLUMN_NAME, self::CATEGORY_COLUMN_NAME, self::CAN_CON_COLUMN_NAME, self::NEW_RELEASE_COLUMN_NAME, self::FRENCH_VOCAL_MUSIC_COLUMN_NAME);

            $values = array($startDateString, $segment_object->getDuration(), $segment_object->getName(),
                $segment_object->getAuthor(), $segment_object->getAlbum(), $segment_object->getCategory(),
                $segment_object->isCanCon(), $segment_object->isNewRelease(), $segment_object->isFrenchVocalMusic());

            return array($column_names, $values);
        }

        public static function deleteSegmentFromDatabase($db_conn, $segment_id)
        {
            writeToDatabase::deleteDatabaseEntry($db_conn, $segment_id, self::TABLE_NAME);
        }

        /**
         * @param $db_conn
         * @param $episode_id
         * @return Segment[]
         */
        public static function getAllSegmentsForEpisodeId($db_conn, $episode_id)
        {
            $episode = new Episode($db_conn, $episode_id);
            $playlist_id = $episode->getPlaylistId();

            $segments = managePlaylistEntries::getPlaylistSegmentsFromDatabase($db_conn, $playlist_id);

            return $segments;
        }

    }