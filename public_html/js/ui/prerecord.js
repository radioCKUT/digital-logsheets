/*
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

$(document).ready(function () {
    var prerecordInput = $("#prerecord");
    prerecordInput.change(checkPrerecordInput);
    checkPrerecordInput(null, prerecordInput[0]);
});

function checkPrerecordInput(e, element) {
    var prerecordInput = e ? this : element;
    var prerecordDate = $("#prerecord_date");

    if (prerecordInput.checked) {
        prerecordDate.prop('required', true);
        prerecordDate.prop('disabled', false);

    } else {
        prerecordDate.prop('required', false);
        prerecordDate.prop('disabled', true);
    }
}


