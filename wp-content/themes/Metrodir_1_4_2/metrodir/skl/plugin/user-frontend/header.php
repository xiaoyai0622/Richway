<?php
//Get variables metrodir_Options
//Site options
$screen = get_current_screen();

$opt_metrodir_user_cp_popup = get_option('opt_metrodir_user_cp_popup');
if ($opt_metrodir_user_cp_popup == "true") {
    $opt_metrodir_user_cp_popup = true;
} else {
    $opt_metrodir_user_cp_popup = false;
}

global $UouPlugins;

$opt_metrodir_acc_1_items = $UouPlugins->acc->settings->role1->caps->maxcompany;
$opt_metrodir_acc_1_posts = $UouPlugins->acc->settings->role1->caps->maxpost;
$opt_metrodir_acc_1_events = $UouPlugins->acc->settings->role1->caps->maxevent;
$opt_metrodir_acc_1_products = $UouPlugins->acc->settings->role1->caps->maxproduct;

$opt_metrodir_acc_2_items = $UouPlugins->acc->settings->role2->caps->maxcompany;
$opt_metrodir_acc_2_posts = $UouPlugins->acc->settings->role2->caps->maxpost;
$opt_metrodir_acc_2_events = $UouPlugins->acc->settings->role2->caps->maxevent;
$opt_metrodir_acc_2_products = $UouPlugins->acc->settings->role2->caps->maxproduct;

$opt_metrodir_acc_3_items = $UouPlugins->acc->settings->role3->caps->maxcompany;
$opt_metrodir_acc_3_posts = $UouPlugins->acc->settings->role3->caps->maxpost;
$opt_metrodir_acc_3_events = $UouPlugins->acc->settings->role3->caps->maxevent;
$opt_metrodir_acc_3_products = $UouPlugins->acc->settings->role3->caps->maxproduct;

$opt_metrodir_acc_4_items = $UouPlugins->acc->settings->role4->caps->maxcompany;
$opt_metrodir_acc_4_posts = $UouPlugins->acc->settings->role4->caps->maxpost;
$opt_metrodir_acc_4_events = $UouPlugins->acc->settings->role4->caps->maxevent;
$opt_metrodir_acc_4_products = $UouPlugins->acc->settings->role4->caps->maxproduct;

if ($opt_metrodir_acc_1_items == -1 AND $opt_metrodir_acc_2_items == -1 AND $opt_metrodir_acc_3_items == -1 AND $opt_metrodir_acc_1_items == -1) {
    $opt_metrodir_acc_items = false;
} else {
    $opt_metrodir_acc_items = true;
}

if ($opt_metrodir_acc_1_posts == -1 AND $opt_metrodir_acc_2_posts == -1 AND $opt_metrodir_acc_3_posts == -1 AND $opt_metrodir_acc_4_posts == -1) {
    $opt_metrodir_acc_posts = false;
} else {
    $opt_metrodir_acc_posts = true;
}

if ($opt_metrodir_acc_1_events == -1 AND $opt_metrodir_acc_2_events == -1 AND $opt_metrodir_acc_3_events == -1 AND $opt_metrodir_acc_4_events == -1) {
    $opt_metrodir_acc_events = false;
} else {
    $opt_metrodir_acc_events = true;
}

if ($opt_metrodir_acc_1_products == -1 AND $opt_metrodir_acc_2_products == -1 AND $opt_metrodir_acc_3_products == -1 AND $opt_metrodir_acc_3_products == -1) {
    $opt_metrodir_acc_products = false;
} else {
    $opt_metrodir_acc_products = true;
}

?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/color.css" />

<?php
if ($screen->base == 'profile') {
    echo '<script>';
    include_once dirname(__FILE__) . '/js/ufe.js';
    echo '</script>';
}
?>

<?php if ($screen->base == "profile_page_metrodir-account" AND $opt_metrodir_user_cp_popup): ?>

    <ul class="account-menu">
        <li><a href="<?php echo home_url(); ?>"><?php echo __('Home','metrodir_user_frontend'); ?></a></li>
        <li class="active"><a href="<?php echo admin_url('profile.php?page=metrodir-account'); ?>"><?php _e('Plan Settings','metrodir_user_frontend'); ?></a></li>
    </ul>

<?php else: ?>

    <ul class="account-menu">
        <?php if (!$opt_metrodir_user_cp_popup): ?>
            <li><a href="<?php echo home_url(); ?>"><?php echo __('Home','metrodir_user_frontend'); ?></a></li>
        <?php endif; ?>
        <?php if ($opt_metrodir_acc_items): ?>
            <li class="<?php if(($screen->base == 'edit' && $screen->post_type == 'company') OR ($screen->base == 'post' && $screen->post_type == 'company') ) echo "active";?>"><a href="<?php echo admin_url('edit.php?post_type=company'); ?>"><?php echo __('Company','metrodir_user_frontend'); ?></a></li>
        <?php endif; ?>
        <?php if ($opt_metrodir_acc_posts): ?>
            <li class="<?php if(($screen->base == 'edit' && $screen->post_type == 'post') OR ($screen->base == 'post' && $screen->post_type == 'post') ) echo "active";?>"><a href="<?php echo admin_url('edit.php'); ?>"><?php echo __('Post','metrodir_user_frontend'); ?></a></li>
        <?php endif; ?>
        <?php if ( is_plugin_active('events-manager/events-manager.php') AND $opt_metrodir_acc_events ): ?>
            <li class="<?php if(($screen->base == 'edit' && $screen->post_type == 'event') OR ($screen->base == 'post' && $screen->post_type == 'event') ) echo "active";?>"><a href="<?php echo admin_url('edit.php?post_type=event'); ?>"><?php echo __('Events','metrodir_user_frontend'); ?></a></li>
        <?php endif; ?>
        <?php if ( is_plugin_active('woocommerce/woocommerce.php') AND $opt_metrodir_acc_products ): ?>
            <li class="<?php if(($screen->base == 'edit' && $screen->post_type == 'product') OR ($screen->base == 'post' && $screen->post_type == 'product') ) echo "active";?>"><a href="<?php echo admin_url('edit.php?post_type=product'); ?>"><?php echo __('Products','metrodir_user_frontend'); ?></a></li>
        <?php endif; ?>
        <li class="<?php if($screen->base == 'profile' OR $screen->base == 'profile_page_metrodir-account') echo "active";?>"><a href="<?php echo admin_url('profile.php'); ?>"><?php echo __('My Account','metrodir_user_frontend'); ?></a></li>
    </ul>

<?php endif; ?>

<?php if ( $screen->base == 'profile' AND !$opt_metrodir_user_cp_popup ): ?>
    <div class="my-plan"><a href="<?php echo admin_url('profile.php?page=metrodir-account'); ?>" class="add-item button button-primary"><?php _e('See Plan Settings','metrodir_user_frontend'); ?></a></div>
<?php endif; ?>