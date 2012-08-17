var donate = document.getElementById( 'donate' ),
    donateBubble = document.getElementById( 'donate-bubble' ),
    donateInput = document.getElementById( 'donate-input' );

document.body.onclick = function() {
    donateBubble.style.display = 'none';
};

donateBubble.onclick = function( e ) {
    e.stopPropagation();
};

donate.onclick = function( e ) {
    donateBubble.style.display = 'block';
    donateInput.select();
    donateInput.focus();
    e.stopPropagation();
    return false;
}
