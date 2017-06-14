<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2017  Evan Vassallo
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

/**
 * Created by PhpStorm.
 * User: baikdonghee
 * Date: 2017-06-12
 * Time: 12:12 PM
 */

include_once(dirname(__FILE__) . "/../database/connectToDatabase.php");

class Statistic
{
    private $id,$station_id,$ad_number,$name,$album,$author,$approx_duration_mins,$start_time,$category,$can_con,$new_release,$french_vocal_music;

    function __construct($id=null,$station_id=null,$ad_number=null,$name=null,$album=null,$author=null,
                         $approx_duration_mins=null,$start_time=null,$category=null,$can_con=null,
                         $new_release=null,$french_vocal_music=null)
    {
        $this->id = $id;
        $this->station_id = $station_id;
        $this->ad_number = $ad_number;
        $this->name = $name;
        $this->album=$$album;
        $this->author=$author;
        $this->approx_duration_mins=$approx_duration_mins;
        $this->start_time=$start_time;
        $this->category=$category;
        $this->can_con=$can_con;
        $this->new_release=$new_release;
        $this->french_vocal_music=$french_vocal_music;

    }
    function getId(){return $this->id;}
    function getStation_id(){return $this->station_id;}
    function getAd_number(){return $this->ad_number;}
    function getName(){return $this->name;}
    function getAlbum(){return $this->album;}
    function getAuthor(){return $this->author;}
    function getApprox_duration_mins(){return $this->approx_duration_mins;}
    function getStart_time(){return $this->start_time;}
    function getCategory(){return $this->category;}
    function getCan_con(){return $this->can_con;}
    function getNew_release(){return $this->new_release;}
    function getFrench_vocal_music(){return $this->french_vocal_music;}

    function setId($Id){$this->id=$Id;}
    function setStation_id($Station_id){$this->station_id=$Station_id;}
    function setAd_number($Ad_number){$this->ad_number=$Ad_number;}
    function setName($Name){$this->name=$Name;}
    function setAlbum($Album){$this->album=$Album;}
    function setAuthor($Author){$this->author=$Author;}
    function setApprox_duration_mins($Approx_duration_mins){$this->approx_duration_mins=$Approx_duration_mins;}
    function setStart_time($Start_time){$this->start_time=$Start_time;}
    function setCategory($Category){$this->category=$Category;}
    function setCan_con($Can_con){$this->can_con=$Can_con;}
    function setNew_release($New_release){return $this->new_release=$New_release;}
    function setFrench_vocal_music($French_vocal_music){return $this->french_vocal_music=$French_vocal_music;}



    function getAllCan_Con($db, $startdate, $enddate,$category)
    {

        $db = getPDOStatementWithLogin();
        $counter = 0;
        $query = "SELECT count(id) as id_count, album , sum(approx_duration_mins) as total_mins 
                  from segment where can_con = 0 and category = '" . $category . "' and start_time BETWEEN '" . $startdate . "' AND '" . $enddate .
            "' group by album ORDER BY COUNT(approx_duration_mins) DESC";

        $prepQuery = $db->prepare($query);
        $prepQuery->bindValue(':category', $category, PDO::PARAM_STR);
        $prepQuery->bindValue(':startdate', $startdate, PDO::PARAM_STR);
        $prepQuery->bindValue(':enddate', $enddate, PDO::PARAM_STR);
        $prepQuery->execute();
        $result = $prepQuery->fetchAll();
        $aObj = "";
        $counter = 0;
        if (count($result) > 0) {
            foreach ($db->query($query) as $rec) {
                $aObj = new Statistic();
                $aObj->id = $rec["id_count"];
                $aObj->album = $rec["album"];
                $aObj->approx_duration_mins = $rec["total_mins"];

                $arrAd[$counter++] = $aObj;
            }
            return $arrAd;
        }else{

            //echo " no data output ";
        }
    }

    function getMostPlayedAlbum($db, $startdate, $enddate) {

        $db = getPDOStatementWithLogin();
        $counter = 0;
        //$query = "SELECT album, author, count(id) as id_count FROM segment GROUP BY album, author ORDER BY `id_count` DESC limit 30";
        $query = "SELECT album, author, count(id) as id_count FROM segment 
where start_time BETWEEN '" . $startdate . "' AND '" . $enddate . "' GROUP BY album, author ORDER BY `id_count` DESC limit 30";

        foreach ($db->query($query) as $rec) {
            $aObj = new Statistic();
            $aObj->id = $rec["id_count"];
            $aObj->album = $rec["album"];
            $aObj->author = $rec["author"];

            $arrAd[$counter++] = $aObj;
        }
        return $arrAd;
    }
    function getAdFrequency($db, $startdate, $enddate) {

        $db = getPDOStatementWithLogin();
        $counter = 0;
        //$query = "SELECT count(id) as id_count, ad_number from segment   group by ad_number ORDER BY COUNT(id) DESC ";

        $query = "SELECT count(id) as id_count, ad_number from segment
where start_time BETWEEN '" . $startdate . "' AND '" . $enddate . "' group by ad_number ORDER BY COUNT(id) DESC ";

        foreach ($db->query($query) as $rec) {
            $aObj = new Statistic();
            $aObj->id = $rec["id_count"];
            $aObj->ad_number = $rec["ad_number"];

            $arrAd[$counter++] = $aObj;
        }
        return $arrAd;
    }
    function getAllStationId($db,$startdate, $enddate) {

        $db = getPDOStatementWithLogin();
        $counter = 0;
       // $query = "SELECT count(id) as id_count, station_id from segment group by station_id ORDER BY COUNT(id) DESC ";
        $query = "SELECT count(id) as id_count, station_id from segment 
where start_time BETWEEN '" . $startdate . "' AND '" . $enddate . "' group by station_id ORDER BY COUNT(id) DESC ";

        foreach ($db->query($query) as $rec) {
            $aObj = new Statistic();
            $aObj->id = $rec["id_count"];
            $aObj->ad_number = $rec["station_id"];

            $arrAd[$counter++] = $aObj;
        }
        return $arrAd;
    }

}

?>
