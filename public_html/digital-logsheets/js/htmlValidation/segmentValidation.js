function setupAllCatHTMLValidation(adNumberInput, nameInput) {
    adNumberInput.prop('required', false);
    nameInput.prop('required', true);
}

function setupMusicCatHTMLValidation(authorInput, albumInput) {
    authorInput.prop('required', true);
    albumInput.prop('required', true);
}

function setupNonMusicCatHTMLValidation(authorInput, albumInput) {
    authorInput.prop('required', false);
    albumInput.prop('required', false);
}

function setupCat5HTMLValidation(adNumberInput, nameInput) {
    adNumberInput.prop('required', true);
    nameInput.prop('required', false);
}