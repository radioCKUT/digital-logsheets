function setupAllFields() {
    $('#name_group').show();
    $('#ad_number_group').hide();
    $('#ad_number_input').prop('required', false);
}

function setupMusicCatFields() {
    setupAllFields();
    $('#author_group').show();
    $('#author_input').prop('required', true);
    $('#album_group').show();
    $('#album_input').prop('required', true);
    $('#can_con_group').show();
    $('#new_release_group').show();
    $('#french_vocal_music_group').show();
    $('#name_label').text("Title:");
}

function setupNonMusicCatFields() {
    setupAllFields();
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
}

function setupCat3Fields() {
    setupMusicCatFields();
}

function setupCat4Fields() {
    setupNonMusicCatFields();
    $('#author_group').hide();
    $('#album_group').hide();

    $('#name_label').text("Name:");
}

function setupCat5Fields() {
    setupNonMusicCatFields();
    $('#name_group').hide();
    $('#author_group').hide();
    $('#album_group').hide();
    $('#ad_number_group').show();

    $('#ad_number_input').prop('required', true);
}