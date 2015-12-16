function musicCategory() {
    $('#author_group').show();
    $('#author_input').prop('required', true);
    $('#album_group').show();
    $('#album_input').prop('required', true);
    $('#can_con_group').show();
    $('#new_release_group').show();
    $('#french_vocal_music_group').show();
}

function nonMusicCategory() {
    $('#author_input').prop('required', false);
    $('#album_input').prop('required', false);
    $('#can_con_group').hide();
    $('#new_release_group').hide();
    $('#french_vocal_music_group').hide();
}

function setupCat1Fields() {
    nonMusicCategory();
    $('#author_group').show();
    $('#album_group').show();
}

function setupCat2Fields() {
    musicCategory();
}

function setupCat3Fields() {
    musicCategory();
}

function setupCat4Fields() {
    nonMusicCategory();
    $('#author_group').hide();
    $('#album_group').hide();
}

function setupCat5Fields() {
    nonMusicCategory();
    $('#author_group').hide();
    $('#album_group').hide();
}