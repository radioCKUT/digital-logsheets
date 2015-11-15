<?php

    //begin episode-specific methods
    function getEpisodeTableName()
    {
        return "episode";
    }

    function getEpisodeAttributeFromDatabase($db_connection, $attribute_column_name, $episode_id)
    {
        return readFirstMatchingEntryFromTable($db_connection, $attribute_column_name,
            getEpisodeTableName(), "id", $episode_id);
    }

    function getProgramNameFromDatabase($db_connection, $program_id) {
        return readFirstMatchingEntryFromTable($db_connection, "name", "program", "id", $program_id);
    }

    function getProgramFromDatabase($db_connection, $episode_id)
    {
        $program_id = getEpisodeAttributeFromDatabase($db_connection, "program", $episode_id);
        return new Program($db_connection, $program_id);
    }

    function getPlaylistFromDatabase($db_connection, $episode_id)
    {
        $playlist_id = getEpisodeAttributeFromDatabase($db_connection, "playlist", $episode_id);
        return new Playlist($db_connection, $playlist_id);
    }

    function getProgrammerFromDatabase($db_connection, $episode_id)
    {
        $programmer_id = getEpisodeAttributeFromDatabase($db_connection, "programmer", $episode_id);
        return new Programmer($db_connection, $programmer_id);
    }

    function getEpisodeStartTimeFromDatabase($db_connection, $episode_id)
    {
        return getEpisodeAttributeFromDatabase($db_connection, "start_time", $episode_id);
    }

    function getEpisodeEndTimeFromDatabase($db_connection, $episode_id)
    {
        return getEpisodeAttributeFromDatabase($db_connection, "end_time", $episode_id);
    }

    function getAllEpisodesFromDatabase($db_connection) {
        $episode_ids = readEntireColumnFromTable($db_connection, "id", getEpisodeTableName());

        $episodes = array();

        if(count($episode_ids)) {
            foreach($episode_ids as $episode_row) {
                $episode = new Episode($db_connection, $episode_row["id"]);
                $episodes[$episode->getId()] = $episode;
            }
        }

        return $episodes;
    }
    //end episode-specific methods





    //begin category-specific methods
    function getCategoryNameFromDatabase($db_connection, $category_id) {
        return readFirstMatchingEntryFromTable($db_connection, "name", "category", "id", $category_id);
    }


    function getAllCategoriesFromDatabase($db_connection) {
        $category_ids = readEntireColumnFromTable($db_connection, "id", "category");

        $categories = array();
        foreach($category_ids as $category_id) {
            $category = new Category($db_connection, $category_id["id"]);
            $categories[$category->getId()] = $category->getName();
        }

        return $categories;
    }
    //end category-specific methods





    //begin program-specific methods
    function getAllProgramsFromDatabase($db_connection) {
        $program_ids = readEntireColumnFromTable($db_connection, "id", "program");

        $programs = array();
        foreach($program_ids as $program_id) {
            $program = new Program($db_connection, $program_id["id"]);
            $programs[$program->getId()] = $program->getName();
        }

        return $programs;
    }
    //end program-specific methods






    //begin playlist-specific methods
    function getPlaylistSegmentsFromDatabase($db_connection, $playlist_id)
    {
        $segment_ids = readFilteredColumnFromTable($db_connection, "segment", "playlist_segments", "playlist", $playlist_id);

        $segments = array();

        //make Segments for each segment id and store in an array (segments)
        if (count($segment_ids)) {
            foreach ($segment_ids as $segment_id) {
                $segments[$segment_id["segment"]] = new Segment($db_connection, $segment_id["segment"]);
            }
        }

        return $segments;
    }
    //end playlist-specific methods





    //begin segment-specific methods
    function getSegmentAttributeFromDatabase($db_connection, $attribute_column_name, $segment_id) {
        return readFirstMatchingEntryFromTable($db_connection, $attribute_column_name, "segment", "id", $segment_id);
    }

    function getSegmentNameFromDatabase($db_connection, $segment_id) {
        return getSegmentAttributeFromDatabase($db_connection, "name", $segment_id);
    }

    function getSegmentAlbumFromDatabase($db_connection, $segment_id) {
        return getSegmentAttributeFromDatabase($db_connection, "album", $segment_id);
    }

    function getSegmentAuthorFromDatabase($db_connection, $segment_id) {
        return getSegmentAttributeFromDatabase($db_connection, "author", $segment_id);
    }
    //end segment-specific methods






    //begin interaction with MySQL database methods
    function getEntireColumnQueryString($column_name, $table_name)
    {
        return "SELECT " . $column_name . " FROM " . $table_name;
    }

    function readEntireColumnFromTable($db_connection, $column_name, $table_name)
    {
        $sql_query_string = getEntireColumnQueryString($column_name, $table_name);
        $sql_query_stmt = $db_connection->prepare($sql_query_string);

        return readFromDatabaseWithStatement($sql_query_stmt);
    }

    function readFilteredColumnFromTable($db_connection, $column_name, $table_name, $filter_column, $filter_id_number)
    {
        $sql_query_string = getEntireColumnQueryString($column_name, $table_name) . " WHERE " . $filter_column . "=:id";
        $sql_query_stmt = $db_connection->prepare($sql_query_string);
        $sql_query_stmt->bindParam(":id", $filter_id_number, PDO::PARAM_INT);

        return readFromDatabaseWithStatement($sql_query_stmt);
    }

    function readFirstMatchingEntryFromTable($db_connection, $column_name, $table_name, $filter_column, $filter_id_number)
    {
        $all_matching_entries = readFilteredColumnFromTable($db_connection, $column_name, $table_name, $filter_column, $filter_id_number);
        return $all_matching_entries[0][$column_name];
    }

    function readFromDatabaseWithStatement($sql_query_stmt)
    {
        try {
            $sql_query_stmt->execute();
            $db_result = $sql_query_stmt->fetchAll(PDO::FETCH_ASSOC);

            return $db_result;

        } catch (Exception $error) {
            echo "Read from database failed: " . $error;
        }
    }
    //end interaction with MySQL database methods

?>