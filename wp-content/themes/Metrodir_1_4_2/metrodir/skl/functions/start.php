<?php


function ismetrodirUser($userToTest = null) {
    global $current_user;
    $user = (isset($userToTest)) ? $userToTest : $current_user;
    if( isset( $user->roles ) && is_array( $user->roles ) ) {
        if( in_array('metrodir_role_1', $user->roles) || in_array('metrodir_role_2', $user->roles) || in_array('metrodir_role_3', $user->roles) || in_array('metrodir_role_4', $user->roles) ) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

//Load users engine

require_once dirname(__FILE__) . '/accounts.php';
