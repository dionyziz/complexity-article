<?php
    if ( isset( $_GET[ 'el' ] ) ) {
        readfile( 'index-el.html' );
    }
    else {
        readfile( 'index-en.html' );
    }
?>
