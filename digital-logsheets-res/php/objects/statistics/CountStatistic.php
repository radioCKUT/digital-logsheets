<?php
/**
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2017  Evan Vassallo
 * Copyright (C) 2017 Donghee Baik
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

require_once('Statistic.php');
class CountStatistic extends Statistic {
    private $count;
    private $album;
    private $author;
    private $adNumber;



    public function getCount() {
        return $this->count;
    }

    public function getAlbum() {
        return $this->album;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getAdNumber() {
        return $this->adNumber;
    }




    public function setCount($count) {
        $this->count = $count;
    }

    public function setAlbum($album) {
        $this->album = $album;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function setAdNumber($adNumber) {
        $this->adNumber = $adNumber;
    }
}
