<?php

function uou_init_widgets() {

    require_once metrodir_SKL . "/framework/widgets/count-companies-widget.php";

}
add_action('widgets_init', 'uou_init_widgets');


global $current_user;
$current_user = wp_get_current_user();


//Check user
if( isset( $current_user->roles ) && is_array( $current_user->roles ) && ( in_array('administrator', $current_user->roles)))  {
    require_once metrodir_SKL_plugin . "/import-company/import.php";
}

require_once metrodir_SKL_plugin . "/user-frontend/page.php";

require_once metrodir_SKL_plugin . "/admin-options/functions.php";

require_once metrodir_SKL_plugin . "/uou-shortcodes/functions.php";

require_once metrodir_SKL_plugin . "/uou-update/update.php";

require_once metrodir_SKL_plugin . "/uou-dashboard/functions.php";