function setupMusicCatFields() {
    $('#author_group').show();
    $('#author_input').prop('required', true);
    $('#album_group').show();
    $('#album_input').prop('required', true);
    $('#can_con_group').show();
    $('#new_release_group').show();
    $('#french_vocal_music_group').show();
}

function setupNonMusicCatFields() {
    $('#author_input').prop('required', false);
    $('#album_input').prop('required', false);
    $('#can_con_group').hide();
    $('#new_release_group').hide();
    $('#french_vocal_music_group').hide();
}

function setupCat1Fields() {
    setupNonMusicCatFields();
    $('#author_group').show();
    $('#album_group').show();
    $('#name_label').text("Description:");
}

function setupCat2Fields() {
    setupMusicCatFields();
    $('#name_label').text("Name:");
}

function setupCat3Fields() {
    setupMusicCatFields();
    $('#name_label').text("Name:");
}

function setupCat4Fields() {
    setupNonMusicCatFields();
    $('#author_group').hide();
    $('#album_group').hide();

    $('#name_label').text("Name:");
}

function setupCat5Fields() {
    setupNonMusicCatFields();
    $('#author_group').hide();
    $('#album_group').hide();

    $('#name_label').text("Ad Number:");
}