function setupAllCatHTMLValidation(adNumberInput) {
    adNumberInput.prop('required', false);
}

function setupMusicCatHTMLValidation(authorInput, albumInput) {
    authorInput.prop('required', true);
    albumInput.prop('required', true);
}

function setupNonMusicCatHTMLValidation(authorInput, albumInput) {
    authorInput.prop('required', false);
    albumInput.prop('required', false);
}

function setupCat5HTMLValidation(adNumberInput) {
    adNumberInput.prop('required', true);
}