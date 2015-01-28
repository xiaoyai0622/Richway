<?php
/*
Template Name: Home
*/
get_header();
the_post();
//Get variables Metrodir_Options
//Site options
$opt_metrodir_home_version = get_option('opt_metrodir_home_version');
$opt_metrodir_home_view = get_option('opt_metrodir_home_view');
$opt_metrodir_search_def = get_option('opt_metrodir_search_def');
$opt_metrodir_category_version = get_option('opt_metrodir_category_version');
?>

<?php if (isset($register_error_string) AND $register_error_string): ?>

    <?php if ( is_wp_error( $register_error_string ) ): ?>

        <?php $register_error_string = $register_error_string->get_error_message(); ?>

        <!-- Message --><div class="notification-error">
            <div class="box-container">
                <i class="fa fa-times-circle"></i>
                <?php echo ' '.$register_error_string; ?>
            </div>
        </div><!-- /Message -->

    <?php else: ?>

        <!-- Message --><div class="notification-error">
            <div class="box-container">
                <i class="fa fa-times-circle"></i>
                <?php echo ' '.$register_error_string; ?>
            </div>
        </div><!-- /Message -->

    <?php endif; ?>

<?php endif; ?>

<?php if(isset($registerMessages) AND $registerMessages): ?>

    <!-- Message --><div class="notification-success">
        <div class="box-container">
            <i class="fa fa-exclamation-circle"></i>
            <?php echo ' '.$registerMessages; ?>
        </div>
    </div><!-- /Message -->

<?php endif; ?>

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

<!-- Content --><div id="content" class="home">

    <?php if ($opt_metrodir_home_view  == "blocks"): ?>

        <?php get_template_part('/include/html/frame','welcome'); ?>

        <?php $content = get_the_content(); if ($content): ?>
            <!-- Visual Composer Content --><div id="visual-composer"><div class="box-container">
                <?php the_content();?>
            </div></div><!-- /Visual Composer Content -->
        <?php endif; ?>

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

        <?php if ($opt_metrodir_category_version == "old"): ?>
            <?php get_template_part('/include/html/frame','category'); ?>
        <?php else: ?>
            <?php get_template_part('/include/html/frame','category-new'); ?>
        <?php endif; ?>

    <?php else: ?>

        <!-- Visual Composer Content --><div id="visual-composer"><div class="box-container">
                <?php the_content() ?>
        </div></div><!-- /Visual Composer Content -->

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

        <?php
            // Welcome Block
            $opt_metrodir_home_wlcm_title = get_option('opt_metrodir_home_wlcm_title');
            $opt_metrodir_home_wlcm_text = get_option('opt_metrodir_home_wlcm_text');
            // Categories Block
            $opt_metrodir_home_category = get_option('opt_metrodir_home_category');
            $args = array(
                'type' 			=> 'company',
                'orderby' 		=> 'name',
                'order' 		=> 'ASC',
                'hide_empty'	=> 1,
                'taxonomy'		=> 'company_category',
                'parent'       => 0
            );
            $categories = get_categories($args);
            // Custom Tab
            $opt_metrodir_home_customtab_body = get_option('opt_metrodir_home_customtab_body');
            $opt_metrodir_home_customtab = get_option('opt_metrodir_home_customtab');
            $opt_metrodir_home_customtab_active = get_option('opt_metrodir_home_customtab_active');
        ?>

        <!-- Home Tab Navigation --><div class="box-container"><ul id="home-tabs-active" class="home-tabs">

            <?php if ($opt_metrodir_home_wlcm_text): ?>
                <li class="active">
                    <a class="home-tabs-welcome" href="#"><?php if ($opt_metrodir_home_wlcm_title) echo $opt_metrodir_home_wlcm_title; else echo __('Welcome', 'metrodir'); ?></a>
                </li>
            <?php endif; ?>

            <?php if ($categories && ($opt_metrodir_home_category == "true")): ?>
                <li<?php if (!$opt_metrodir_home_wlcm_text) echo ' class="active"'; ?>>
                    <a class="home-tabs-category" href="#"><?php echo __('Category','metrodir'); ?></a>
                </li>
            <?php endif; ?>

            <?php if ($opt_metrodir_home_customtab_active == "true"): ?>
                <li<?php if (!($categories && ($opt_metrodir_home_category == "true"))) echo ' class="active"'; ?>>
                    <a class="home-tabs-custom" href="#"><?php if ($opt_metrodir_home_customtab) echo $opt_metrodir_home_customtab; else echo __('Custom','metrodir'); ?></a>
                </li>
            <?php endif; ?>

        </ul></div><!-- /Home Tab Navigation -->

        <!-- Home Tab Container --><div class="box-container"><div id="home-tabs-container">

            <div id="home-tabs-welcome" class="home-tab-content">
                <?php get_template_part('/include/html/frame','welcome'); ?>
            </div>

            <div id="home-tabs-category" class="home-tab-content">
                <?php if ($opt_metrodir_category_version == "old"): ?>
                    <?php get_template_part('/include/html/frame','category'); ?>
                <?php else: ?>
                    <?php get_template_part('/include/html/frame','category-new'); ?>
                <?php endif; ?>
            </div>

            <div id="home-tabs-custom" class="home-tab-content">
                <?php echo $opt_metrodir_home_customtab_body; ?>
            </div>

        </div></div><!-- /Home Tab Container -->

    <?php endif; ?>

    <?php get_template_part('/include/html/frame','post'); ?>

    <?php get_template_part('/include/html/frame','subscribe'); ?>

    <?php get_template_part('/include/html/frame','custom'); ?>

    <?php get_template_part('/include/html/frame','partners'); ?>

</div><!-- /Content -->

<?php get_template_part ('footer');