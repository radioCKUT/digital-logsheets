/*
 * digital-logsheets: A web-based application for tracking the playback of audio segments on a community radio station.
 * Copyright (C) 2015  Mike Dean
 * Copyright (C) 2015-2016  Evan Vassallo
 * Copyright (C) 2016  James Wang
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

$(document).ready(function () {
    var prerecord_input = $("#prerecord");
    prerecord_input.change(checkPrerecordInput);
    checkPrerecordInput();
});

function checkPrerecordInput() {
    var prerecord_date = $("#prerecord_date");
    var prerecord_date_label = $("#prerecord_date_label");

    if (this.checked) {
        prerecord_date.prop('required', true);
        prerecord_date.prop('disabled', false);

    } else {
        prerecord_date.prop('required', false);
        prerecord_date.prop('disabled', true);
    }
}


