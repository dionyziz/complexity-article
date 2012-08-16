<?php
    $languages = array( 'el', 'en' );

    foreach ( $languages as $lang ) {
        if ( isset( $_GET[ $lang ] ) ) {
            break;
        }
    }
    if ( !isset( $_GET[ $lang ] ) ) {
        $lang = 'en';
    }

    $article = include 'index-' . $lang . '.php';

    include 'header.php';
    echo $article[ 'content' ];
    include 'footer.php';
?>
