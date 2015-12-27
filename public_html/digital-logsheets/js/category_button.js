function setupAllFields() {
    $('#name_group').show();
    $('#ad_number_group').hide();

    var adNumberInput = $('#ad_number_input');
    setupAllCatHTMLValidation(adNumberInput);
}

function setupMusicCatFields() {
    setupAllFields();

    var albumInput = $('#album_input');
    var authorInput = $('#author_input');
    setupMusicCatHTMLValidation(authorInput, albumInput);

    $('#author_group').show();
    $('#album_group').show();
    $('#can_con_group').show();
    $('#new_release_group').show();
    $('#french_vocal_music_group').show();
    $('#name_label').text("Title:");
}

function setupNonMusicCatFields() {
    setupAllFields();

    var albumInput = $('#album_input');
    var authorInput = $('#author_input');
    setupNonMusicCatHTMLValidation(authorInput, albumInput);

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

    var adNumberInput = $('#ad_number_input');
    setupCat5HTMLValidation(adNumberInput);
}