<?php
    $languages = array(
        'en' => 'English',
        'el' => 'Ελληνικά',
        'mk' => 'македонски',
        'es' => 'Español'
    );

    $lang = 'en';
    foreach ( $languages as $code => $caption ) {
        if ( isset( $_GET[ $code ] ) ) {
            $lang = $code;
            break;
        }
    }

    ob_start();
    ?>
    <ul class='translations'>
        <?php
        foreach ( $languages as $code => $caption ) {
            ?><li class='<?php
            if ( $code == $lang ) {
                ?>selected<?php
            }
            ?>'><a href='?<?php
            echo $code;
            ?>'><?php
            echo $caption;
            ?></a></li><?php
        }
        ?><li><a href='mailto:dionyziz@gmail.com'>Help translate</a></li>
    </ul>
    <?php
    $translations = ob_get_clean();

    $article = include 'index-' . $lang . '.php';

    include 'header.php';
    echo $article[ 'content' ];
    include 'footer.php';
?>
