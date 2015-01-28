<?php

global $current_user;
$current_user = wp_get_current_user();

//Check user
if( isset( $current_user->roles ) && is_array( $current_user->roles ) && ( in_array('subscriber', $current_user->roles) || in_array('metrodir_role_1', $current_user->roles) || in_array('metrodir_role_2', $current_user->roles) || in_array('metrodir_role_3', $current_user->roles) || in_array('metrodir_role_4', $current_user->roles) || in_array('metrodir_role_5', $current_user->roles) ) ) {

    // hide admin bar
    show_admin_bar( false );

    // admin
    if (is_admin()) {

        // hide from backend
        function disable_admin_bar() {
            echo '
            <style>
            #wpadminbar {display:none;}
            html.wp-toolbar { padding-top: 0px !important; }
            </style>';
        }
        add_filter('admin_head','disable_admin_bar');

        /** Generate page */
        add_action('admin_head', 'ufe_style');
        function ufe_style() {
            // frontend styles
            echo '<link id="metrodir-style" rel="stylesheet" type="text/css" media="all" href="'.get_template_directory_uri().'/style.css">';
            echo '<style>';
            include_once dirname(__FILE__) . '/css/ufe.css';
            echo '</style>';
        }

        add_action('in_admin_header', 'ufe_header',1);
        function ufe_header() {
            include_once dirname(__FILE__) . '/header.php';
        }

    }
}