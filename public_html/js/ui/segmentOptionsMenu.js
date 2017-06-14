/*
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

function generateOptionsButton() {
    var button = $('<button class="btn btn-default btn-xs dropdown-toggle" type="button" ' +
        'id="dropdownMenu1" data-toggle="dropdown" ' +
        'aria-haspopup="true" aria-expanded="true">');
    var dropdown = $('<span class="glyphicon glyphicon-option-vertical" aria-hidden="true">');

    return button.append(dropdown);
}

function generateDeleteButton(segment_id) {
    var li =  $(document.createElement("li"));
    li.append('<a href="#" data-toggle="modal" data-target="#confirmDeleteModal">Delete</a>');
    return li;
}

function generateEditButton(segment_id) {
    return $(document.createElement("li"))
        .click(function(eventObject) {
            prepareFormForEdit(eventObject);
        })
        .append('<a href="#">Edit</a>');
}