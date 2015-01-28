<?php

function UOUTopBarMenu($TopBarLinks)
{

    $adminUrl = get_admin_url(0, 'admin.php?page=');
    $rootId = 'siteoptions';

    $TopBarLinks->add_node(array(
        'id' => $rootId,
        'title' => __('UOU Admin', 'metrodir'),
        'href' => $adminUrl . $rootId
    ));

    $TopBarLinks->add_node(array(
        'id' => "metrodircp",
        'parent' => $rootId,
        'title' => 'Metrodir CP',
        'href' => $adminUrl . 'siteoptions'
    ));

    $TopBarLinks->add_node(array(
        'id' => "uouaddons",
        'parent' => $rootId,
        'title' => 'UOU addons',
        'href' => $adminUrl . 'siteoptions-plugins'
    ));

        $TopBarLinks->add_node(array(
            'id' => "uouaddons-stars",
            'parent' => 'uouaddons',
            'title' => 'Rating Settings',
            'href' => $adminUrl . 'siteoptions-plugins'
        ));

        $TopBarLinks->add_node(array(
            'id' => "uouaddons-acc",
            'parent' => 'uouaddons',
            'title' => 'Account Settings',
            'href' => $adminUrl . 'siteoptions-plugins&tabs=acc'
        ));

        $TopBarLinks->add_node(array(
            'id' => "uouaddons-fld",
            'parent' => 'uouaddons',
            'title' => 'Restriction Fields',
            'href' => $adminUrl . 'siteoptions-plugins&tabs=fields'
        ));

    $TopBarLinks->add_node(array(
        'id' => "uouupdate",
        'parent' => $rootId,
        'title' => 'UOU Update',
        'href' => $adminUrl . 'siteoptions-update'
    ));

    $TopBarLinks->add_node(array(
        'id' => "uouapps",
        'parent' => $rootId,
        'title' => 'UOUapps',
        'href' => 'http://themeforest.net/user/uouapps/'
    ));

    /*    $TopBarLinks->add_node(array(
            'id' => "uouapps-vimeo",
            'parent' => 'uouapps',
            'title' => 'Metrodir Video Tutorial',
            'href' => 'https://vimeo.com/groups/metrodirwp'
        )); */

        $TopBarLinks->add_node(array(
            'id' => "uouapps-portfolio",
            'parent' => 'uouapps',
            'title' => 'UOUapps Portfolio',
            'href' => 'http://themeforest.net/user/uouapps/portfolio'
        ));

}

function UOUTopBarIcon()
{
    $icon = get_template_directory_uri().'/skl/framework/img/skl.png';
    echo "
<style>
    #wpadminbar #wp-admin-bar-siteoptions >.ab-item { background-image: url('{$icon}');background-repeat: no-repeat;background-position: 0.85em 50%;padding-left: 32px;}
</style>
";
}

function addUOUtoTopBar()
{
    add_action('admin_bar_menu', 'UOUTopBarMenu', 35);
    add_action('admin_head', 'UOUTopBarIcon');
    add_action('wp_head', 'UOUTopBarIcon');
}

addUOUtoTopBar();

function addUOUtoTopBarCompany_pending($buble) {

    $args = array(
        'post_type' => 'company',
        'posts_per_page' => -1,
        'post_status' => 'pending',
    );

    $q = new WP_Query($args);

    $pending_listings = $q->found_posts;

    set_transient('sf_spots_pending', $pending_listings, (10 * MINUTE_IN_SECONDS));

    if($pending_listings > 0) {
        $buble = $buble.'<span style="background: #d54e21; color: white; font-size: 9px; line-height: 17px; display: inline-block; width: 17px; text-align: center; margin: -1px 0 0 5px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -ms-border-radius: 20px; -o-border-radius: 20px; border-radius: 20px;">'.$pending_listings.'</span>';
    }

    return $buble;

}

function addUOUtoTopBarCompany(){
    global $wp_admin_bar;

    add_filter('addUOUtoTopBarCompany_link', 'addUOUtoTopBarCompany_pending', 10, 1);

    $wp_admin_bar->add_menu(array(

        'parent' => false,
        'id' => 'uou_comapny',
        'title' => apply_filters('addUOUtoTopBarCompany_link', 'Company'),
        'href' => admin_url('edit.php?post_type=company'),

    ));

    $wp_admin_bar->add_menu(array(

        'parent' => 'uou_comapny',
        'id' => 'uou_comapny_add',
        'title' => 'Add new',
        'href' => admin_url('post-new.php?post_type=company'),

    ));

    $pending_spots = get_transient('sf_spots_pending');
    if(!$pending_spots) { $pending_spots = 0; }

    if($pending_spots > 0) {

        $wp_admin_bar->add_menu(array(

            'parent' => 'uou_comapny',
            'id' => 'uou_comapny_pending',
            'title' => apply_filters('addUOUtoTopBarCompany_link', 'Pending Review'),
            'href' => admin_url('edit.php?post_status=pending&post_type=company'),

        ));

    }

    $wp_admin_bar->add_menu(array(

        'parent' => 'uou_comapny',
        'id' => 'uou_comapny_vall',
        'title' => 'View all',
        'href' => admin_url('edit.php?post_type=company'),

    ));
}

add_action('wp_before_admin_bar_render', 'addUOUtoTopBarCompany');