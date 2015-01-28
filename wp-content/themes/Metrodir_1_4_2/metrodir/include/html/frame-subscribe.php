<?php
global $UouPlugins;
//Package options
$opt_metrodir_home_subscribe = get_option('opt_metrodir_home_subscribe');
$opt_metrodir_home_pricing_plans = get_option('opt_metrodir_home_pricing_plans');

?>

<!-- Subscribe Block --><div id="subscribe" class="box-container">

    <?php
        $shower = true;
        if (is_front_page()) {
            if ($opt_metrodir_home_pricing_plans == "true") $shower = true;
            else $shower = false;
        }
        if (isset($UouPlugins->acc->status) AND $UouPlugins->acc->status == "enable" AND $shower == true) $shower = true; else $shower = false;
    ?>
    <?php if ($shower): ?>
        <?php get_template_part('/include/html/frame','pricing-plans'); ?>
    <?php endif ?>

    <?php
        $shower = true;
        if (is_front_page()) {
            if ($opt_metrodir_home_subscribe == "true") $shower = true;
            else $shower = false;
        } else {
            $shower = true;
        }
        if (is_user_logged_in()) $shower = false;
    ?>
    <?php if ($shower): ?>
        <?php get_template_part('/include/html/frame','register'); ?>
    <?php endif; ?>

</div><!-- /Subscribe Block -->
