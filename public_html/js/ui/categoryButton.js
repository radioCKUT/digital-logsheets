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

function resetAllFields() {
    $('.category').button('reset');
    $('.ad_number_group').hide();
    $('.name_group').hide();
    $('.station_id_group').hide();
    $('.author_group').hide();
    $('.album_group').hide();
    $('.can_con_group').hide();
    $('.new_release_group').hide();
    $('.french_vocal_music_group').hide();
}


function setupAllFields(addValidationChecks) {
    $('.name_group').show();
    $('.ad_number_group').hide();

    var adNumberInput = $('.ad_number_input');
    var nameInput = $('.name_input');

    if (addValidationChecks) {
        setupAllCatHTMLValidation(adNumberInput, nameInput);
    }
}

function setupMusicCatFields(addValidationChecks) {
    setupAllFields();

    if (addValidationChecks) {
        var albumInput = $('.album_input');
        var authorInput = $('.author_input');
        setupMusicCatHTMLValidation(authorInput, albumInput);
    }

    $('.station_id_group').hide();
    $('.author_group').show();
    $('.album_group').show();
    $('.can_con_group').show();
    $('.new_release_group').show();
    $('.french_vocal_music_group').show();
    $('.name_label').text("Title:");
}

function setupNonMusicCatFields(addValidationChecks) {
    setupAllFields();

    if (addValidationChecks) {
        var albumInput = $('.album_input');
        var authorInput = $('.author_input');
        setupNonMusicCatHTMLValidation(authorInput, albumInput);
    }

    $('.author_group').hide();
    $('.album_group').hide();

    $('.can_con_group').hide();
    $('.new_release_group').hide();
    $('.french_vocal_music_group').hide();
}

function setupCat1Fields(addValidationChecks) {
    setupNonMusicCatFields(addValidationChecks);

    $('.station_id_group').show();
    $('.name_label').text("Description:");
}

function setupCat2Fields(addValidationChecks) {
    setupMusicCatFields(addValidationChecks);
}

function setupCat3Fields(addValidationChecks) {
    setupMusicCatFields(addValidationChecks);
}

function setupCat4Fields(addValidationChecks) {
    setupNonMusicCatFields(addValidationChecks);

    $('.station_id_group').show();
    $('.name_label').text("Name:");
}

function setupCat5Fields(addValidationChecks) {
    setupNonMusicCatFields(addValidationChecks);
    $('.name_group').hide();
    $('.station_id_group').hide();

    $('.ad_number_group').show();

    if (addValidationChecks) {
        var adNumberInput = $('.ad_number_input');
        var nameInput = $('.name_input');
        setupCat5HTMLValidation(adNumberInput, nameInput);
    }
}