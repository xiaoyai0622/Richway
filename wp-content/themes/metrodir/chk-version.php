<?php

function uou_version_init () {
    global $version;
    $uou_version = $version;
    if ( get_option( 'uou_version' ) != $uou_version ) {
        update_option( 'uou_version', $uou_version );
    }
}
add_action( 'init', 'uou_version_init', 10 );