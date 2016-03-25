<?php
/**
 * Created by PhpStorm.
 * User: Evan
 * Date: 2016-03-24
 * Time: 7:40 PM
 */

require_once("../../digital-logsheets-res/smarty/libs/Smarty.class.php");
require_once("../../digital-logsheets-res/php/database/manageSegmentEntries.php");
require_once("../../digital-logsheets-res/php/objects/Episode.php");
require_once("../../digital-logsheets-res/php/database/connectToDatabase.php");
require_once("../../digital-logsheets-res/php/objects/logsheet-classes.php");

// create object
$smarty = new Smarty;


//database interactions
try {
    //connect to database
    $db = connectToDatabase();

    $episode_id = $_SESSION['episode_id'];
    $episode = new Episode($db, $episode_id);

    $segmentsForThisEpisode = manageSegmentEntries::getAllSegmentsForEpisodeId($db, $episode_id);

    //close database connection
    $db = NULL;

    $smarty->assign("episode", $episode);
    $smarty->assign("segments", $segmentsForThisEpisode);


    // display it
    echo $smarty->fetch('../../digital-logsheets-res/templates/finalize-logsheet.tpl');
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}