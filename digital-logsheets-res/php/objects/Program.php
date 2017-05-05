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

include_once(dirname(__FILE__) . "/../database/manageProgramEntries.php");
    class Program extends LogsheetComponent{

        /**
         * @var String
         */
        private $name;

        public function __construct($db, $componentId) {
            parent::__construct($db, $componentId);

            if ($this->id != null) {
                $this->name = manageProgramEntries::getProgramNameFromDatabase($db, $this->id);
            }
        }
        
        public function getName() {
            return $this->name;
        }
    }
?>