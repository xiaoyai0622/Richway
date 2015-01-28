<?php
/*
Template Name: Home with Visual Composer
*/
get_header();
the_post();
//Get variables Metrodir_Options
//Site options
$opt_metrodir_home_version = get_option('opt_metrodir_home_version');
$opt_metrodir_search_def = get_option('opt_metrodir_search_def');

?>

<?php
if($register_error_string){

    if ( is_wp_error( $register_error_string ) ) {
        $register_error_string = $register_error_string->get_error_message();
        echo '<!-- Message --><div class="notification-error"><div class="box-container"><i class="fa fa-times-circle"></i> ' . $register_error_string . '</div></div><!-- /Message -->';
    } else {
        echo '<!-- Message --><div class="notification-error"><div class="box-container"><i class="fa fa-times-circle"></i> ' . $register_error_string . '</div></div><!-- /Message -->';
    }
}
if($registerMessages){
    echo '<!-- Message --><div class="notification-success"><div class="box-container"><i class="fa fa-exclamation-circle"></i> ' . $registerMessages . '</div></div><!-- /Message -->';
}
?>

<?php if ($opt_metrodir_home_version == 'map' OR $opt_metrodir_home_version == 'maprev'): ?>

    <?php if ($opt_metrodir_search_def == "true"): ?>
        <?php get_template_part('/include/html/frame','search'); ?>
    <?php endif; ?>

    <?php get_template_part ('/include/html/str-home', 'map'); ?>

    <?php get_template_part('/include/php/companymarkers'); ?>

<?php elseif ($opt_metrodir_home_version == 'slider' OR $opt_metrodir_home_version == 'revmap'): ?>

    <?php if ($opt_metrodir_home_version == 'slider'): ?>

        <?php if ($opt_metrodir_search_def == "true"): ?>
            <?php get_template_part('/include/html/frame','search'); ?>
        <?php endif; ?>

        <?php get_template_part ('/include/html/str-home', 'slider'); ?>

        <?php get_template_part('/include/php/companymarkers'); ?>

    <?php elseif ($opt_metrodir_home_version == 'revmap'): ?>

        <?php get_template_part ('/include/html/str-home', 'slider'); ?>

    <?php endif; ?>

<?php else: ?>

    <?php if ($opt_metrodir_search_def == "true"): ?>
        <?php get_template_part('/include/html/frame','search'); ?>
    <?php endif; ?>

    <?php get_template_part('/include/php/companymarkers'); ?>

<?php endif; ?>

<!-- Content --><div id="content">

    <?php if ($opt_metrodir_home_version == 'maprev'): ?>

        <div class="slider-below">

            <?php get_template_part ('/include/html/str-home', 'slider'); ?>

        </div>

    <?php elseif ($opt_metrodir_home_version == 'revmap'): ?>

        <?php if ($opt_metrodir_search_def == "true"): ?>
            <?php get_template_part('/include/html/frame','search'); ?>
        <?php endif; ?>

        <?php get_template_part ('/include/html/str-home', 'map'); ?>

        <?php get_template_part('/include/php/companymarkers'); ?>

    <?php endif; ?>

    <!-- Visual Composer Content --><div id="visual-composer-inner" class="box-container">
        <?php the_content() ?>
    </div><!-- /Visual Composer Content -->

</div><!-- /Content -->

<?php get_template_part ('footer');