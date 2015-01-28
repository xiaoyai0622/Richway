<?php
$opt_metrodir_user_cp_popup = get_option('opt_metrodir_user_cp_popup');
if ($opt_metrodir_user_cp_popup == "true") {
    $opt_metrodir_user_cp_popup = true;
} else {
    $opt_metrodir_user_cp_popup = false;
}

global $current_user;
$current_user = wp_get_current_user();

if( isset( $current_user->roles ) && is_array( $current_user->roles ) && ( in_array('subscriber', $current_user->roles) || in_array('metrodir_role_1', $current_user->roles) || in_array('metrodir_role_2', $current_user->roles) || in_array('metrodir_role_3', $current_user->roles) || in_array('metrodir_role_4', $current_user->roles) || in_array('metrodir_role_5', $current_user->roles) ) ) {
    $class_index = true;
} else {
    $class_index = false;
}
$class = ' class="colorbox-popup"';

// Blocking options
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
<ul class="user-links login-user">
    <?php if ($class_index): ?>
        <li class="user">
            <a<?php if ($class_index AND $opt_metrodir_user_cp_popup) echo $class; ?> href="<?php echo admin_url('profile.php'); ?>"><i class="fa fa-male"></i><span><?php echo __('My Account','metrodir')?></span></a>
        </li>
        <li class="my-plan">
            <a href="<?php echo admin_url('profile.php?page=metrodir-account'); ?>"><i class="fa fa-credit-card"></i><span><?php echo __('My Plan','metrodir'); ?></span></a>
        </li>
    <?php else: ?>
        <li class="control-panel">
            <a href="<?php echo admin_url('admin.php?page=siteoptions#general'); ?>"><i class="fa fa-cogs"></i><span><?php echo __('Metrodir CP','metrodir')?></span></a>
        </li>
    <?php endif; ?>
    <li class="items">
        <a<?php if ($class_index AND $opt_metrodir_user_cp_popup) echo $class; ?> href="<?php echo admin_url('edit.php?post_type=company'); ?>"><i class="fa fa-book"></i><span><?php echo __('Items','metrodir'); ?></span></a>
        <?php if ($class_index): ?>
            <ul class="user-links-items">
                <?php if ($opt_metrodir_acc_items): ?>
                    <li><a<?php if ($class_index AND $opt_metrodir_user_cp_popup) echo $class; ?> href="<?php echo admin_url('edit.php?post_type=company'); ?>"><?php echo __('Companies','metrodir'); ?></a></li>
                <?php endif; ?>
                <?php if ($opt_metrodir_acc_posts): ?>
                    <li><a<?php if ($class_index AND $opt_metrodir_user_cp_popup) echo $class; ?> href="<?php echo admin_url('edit.php?post_type=post'); ?>"><?php echo __('Posts','metrodir'); ?></a></li>
                <?php endif; ?>
                <?php if ($opt_metrodir_acc_events AND is_plugin_active('events-manager/events-manager.php')): ?>
                    <li><a<?php if ($class_index AND $opt_metrodir_user_cp_popup) echo $class; ?> href="<?php echo admin_url('edit.php?post_type=event'); ?>"><?php echo __('Events','metrodir'); ?></a></li>
                <?php endif; ?>
                <?php if ($opt_metrodir_acc_products AND is_plugin_active('woocommerce/woocommerce.php')): ?>
                    <li><a<?php if ($class_index AND $opt_metrodir_user_cp_popup) echo $class; ?> href="<?php echo admin_url('edit.php?post_type=product'); ?>"><?php echo __('Products','metrodir'); ?></a></li>
                <?php endif; ?>
            </ul>
        <?php else: ?>
            <ul class="user-links-items">
                <li><a href="<?php echo admin_url('edit.php?post_type=company'); ?>"><?php echo __('Companies','metrodir'); ?></a></li>
                <li><a href="<?php echo admin_url('edit-tags.php?taxonomy=company_category&post_type=company'); ?>"><?php echo __('Categories','metrodir'); ?></a></li>
                <li><a href="<?php echo admin_url('edit.php?post_type=post'); ?>"><?php echo __('Posts','metrodir'); ?></a></li>
                <?php if ( is_plugin_active('events-manager/events-manager.php') ): ?>
                    <li><a href="<?php echo admin_url('edit.php?post_type=event'); ?>"><?php echo __('Events','metrodir'); ?></a></li>
                <?php endif; ?>
                <?php if ( is_plugin_active('woocommerce/woocommerce.php') ): ?>
                    <li><a href="<?php echo admin_url('edit.php?post_type=product'); ?>"><?php echo __('Products','metrodir'); ?></a></li>
                <?php endif; ?>
                <li><a href="<?php echo admin_url('edit.php?post_type=page'); ?>"><?php echo __('Pages','metrodir'); ?></a></li>
                <li><a href="<?php echo admin_url('edit.php?post_type=content'); ?>"><?php echo __('Teams','metrodir'); ?></a></li>
            </ul>
        <?php endif; ?>
    </li>
    <li class="logout">
        <a href="<?php echo wp_logout_url( home_url() ); ?>"><i class="fa fa-power-off"></i><span><?php echo __('Logout','metrodir'); ?></span></a>
    </li>
</ul>