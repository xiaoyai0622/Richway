<?php
//Shortfuncs to UOU options
function uougo($func) {

    if( is_array($func) ) {

        foreach($func as $_func) {
            $return_opt[$_func] = get_option('opt_metrodir_'.$_func);
        }

    } else {
        $return_opt = get_option('opt_metrodir_'.$func);
    }
    return $return_opt;
}

//Shortfuncs to UOU default options
function uougo_def($func) {

    if($func == 'companies_per_page')
        $return_opt = 5;
    return $return_opt;
}

//Dummy array
function uouLoadDefOptions() {
    $fillDefOptionsPlugin["stars"] = array(
        "status" => "disable",
        "settings" => array(
            "holdtime" => "60",
            "rating" => array (
                "n1" => array (
                    "on" => "enable",
                    "name" => "Quality"
                ),
                "n2" => array (
                    "on" => "enable",
                    "name" => "Support"
                ),
                "n3" => array (
                    "on" => "enable",
                    "name" => "Price"
                ),
                "n4" => array (
                    "on" => "enable",
                    "name" => "Products"
                )
            )
        )
    );
    $fillDefOptionsPlugin["acc"] = array(
        "status" => "enable",
        "settings" => array (
            "role1" => array (
                "on" => "true",
                "name" => "Start",
                "price" => "10",
                "period" => "Month",
                "expr" => "0",
                "caps" => array(
                    "maxcompany" => "1",
                    "maxpost" => "1",
                    "maxevent" => "1",
                    "maxproduct" => "1"
                )
            ),
            "role2" => array (
                "on" => "true",
                "name" => "Silver",
                "price" => "19",
                "period" => "Month",
                "expr" => "0",
                "caps" => array(
                    "maxcompany" => "5",
                    "maxpost" => "5",
                    "maxevent" => "5",
                    "maxproduct" => "5"

                )
            ),
            "role3" => array (
                "on" => "true",
                "name" => "Gold",
                "price" => "29",
                "period" => "Month",
                "expr" => "0",
                "caps" => array(
                    "maxcompany" => "10",
                    "maxpost" => "10",
                    "maxevent" => "10",
                    "maxproduct" => "10"
                )
            ),
            "role4" => array (
                "on" => "true",
                "name" => "Premium",
                "price" => "49",
                "period" => "Month",
                "expr" => "0",
                "caps" => array(
                    "maxcompany" => "20",
                    "maxpost" => "20",
                    "maxevent" => "20",
                    "maxproduct" => "20"
                )
            )
        )
    );
    return $fillDefOptionsPlugin;
}

function uou_generate_query($args) {

    $query = new WP_Query($args);
    return $query;
}

// Fields Restriction Engine
function uou_rstrflds_check($name, $position = null){
    global $UouPlugins, $cand_role, $current_user;

    if ($UouPlugins->acc->settings->fields->$name->options == "private") {
        if ($position == 'be') {
            return true;
        } else {
            if (($UouPlugins->acc->settings->fields->$name->$cand_role == "enable") OR ( in_array('administrator', $current_user->roles))){
                return true;
            } else {
                return  false;
            }
        }
    } elseif ($UouPlugins->acc->settings->fields->$name->options == "custom") {
        if (($UouPlugins->acc->settings->fields->$name->$cand_role == "enable") OR ( in_array('administrator', $current_user->roles))) {
            return true;
        } else {
            if ($position == 'fe') {
                return 'removefield';
            } else {
                return false;
            }
        }
    } elseif ($UouPlugins->acc->settings->fields->$name->options == "remove") {
        return 'removefield';
    } else {
        return true;
    }

}

function uou_rstrflds_check_metabox ($fldrestr_check, $fldrestr_name, $fldrestr_id, $desc){
    global $prefix;

    if($fldrestr_check == false){
        $fldrestr_namef = array(
            'name' => __($fldrestr_name, 'metrodir'),
            'id' => $prefix . 'company_'.$fldrestr_id,
            'type' => 'errormsg',
            'desc' => __('To publish this info you need to upgrade.', 'metrodir')
        );
    } elseif ($fldrestr_check === 'removefield') {
        $fldrestr_namef = null;
    } else {
        $fldrestr_namef = array(
            'name' => __($fldrestr_name, 'metrodir'),
            'id' => $prefix . 'company_'.$fldrestr_id,
            'type' => 'text',
            'desc' => __($desc, 'metrodir')
        );
    }
    return $fldrestr_namef;
}