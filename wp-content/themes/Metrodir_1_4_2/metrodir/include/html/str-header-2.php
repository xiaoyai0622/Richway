<?php
//Get variables metrodir_Options
$opt_metrodir_rtl =  get_option('opt_metrodir_rtl');
//Social links
$opt_metrodir_social_fb = get_option('opt_metrodir_social_fb');
$opt_metrodir_social_gp = get_option('opt_metrodir_social_gp');
$opt_metrodir_social_tw = get_option('opt_metrodir_social_tw');
$opt_metrodir_social_li = get_option('opt_metrodir_social_li');
$opt_metrodir_social_pt = get_option('opt_metrodir_social_pt');
$opt_metrodir_social_dr = get_option('opt_metrodir_social_dr');
//Site logo
$opt_metrodir_logo = get_option('opt_metrodir_site_logo');
//Search
$opt_metrodir_search_mega = get_option('opt_metrodir_search_mega');
//
//  Code header style.-2
//
?>

<div id="header-style-two">

    <div id="user-links-panel"<?php if ($opt_metrodir_search_mega == "true") echo ' class="with-search"'; ?>>

        <!-- User Links --><div class="user-links-container">
            <?php
            if ( is_user_logged_in() )
            {
                require_once get_template_directory().'/include/php/logout-form.php';
            }
            else
            {
                require_once get_template_directory().'/include/php/login-form.php';
            };
            ?>
        </div><!-- /User Links -->

        <script type="text/javascript">
            try{document.getElementById('user_login').focus();}catch(e){}
        </script>

        <!-- Social Links --><ul class="social-links">
            <?php if($opt_metrodir_social_fb): ?>
                <li class="facebook"><a href="<?php echo $opt_metrodir_social_fb; ?>" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <?php endif; ?>
            <?php if($opt_metrodir_social_gp): ?>
                <li class="google"><a href="<?php echo $opt_metrodir_social_gp; ?>" title="Google +" target="_blank"><i class="fa fa-google-plus"></i></a></li>
            <?php endif; ?>
            <?php if($opt_metrodir_social_tw): ?>
                <li class="twitter"><a href="<?php echo $opt_metrodir_social_tw; ?>" title="Twitter" target="_blank"><i class="fa fa-twitter fa-lg"></i></a></li>
            <?php endif; ?>
            <?php if($opt_metrodir_social_li): ?>
                <li class="linkedin"><a href="<?php echo $opt_metrodir_social_li; ?>" title="Linkedin" target="_blank"><i class="fa fa-linkedin-square fa-lg"></i></a></li>
            <?php endif; ?>
            <?php if($opt_metrodir_social_pt): ?>
                <li class="pinterest"><a href="<?php echo $opt_metrodir_social_pt; ?>" title="Pinterest" target="_blank"><i class="fa fa-pinterest fa-lg"></i></a></li>
            <?php endif; ?>
            <?php if($opt_metrodir_social_dr): ?>
                <li class="dribbble"><a href="<?php echo $opt_metrodir_social_dr; ?>" title="Dribbble" target="_blank"><i class="fa fa-dribbble fa-lg"></i></a></li>
            <?php endif; ?>
        </ul><!-- /Social Links -->

        <!-- Language Bar --><div class="lang-bar">
            <?php languages_list();  ?>
        </div><!-- /Language Bar -->

        <div class="clear"></div>

    </div>

    <div class="clear"></div>

    <?php if ($opt_metrodir_search_mega == "true"): ?>

        <?php get_template_part('/include/html/frame','search-mega'); ?>

        <div class="clear"></div>

    <?php endif; ?>

    <div id="navigation">

        <!-- Logo --><div id="logo">
            <a href="<?php echo home_url(); ?>">
                <?php if($opt_metrodir_logo){ $logo_url = $opt_metrodir_logo; } else {$logo_url = get_template_directory_uri().'/images/logo.png';}?>
                <img class="opacity" src="<?php echo $logo_url; ?>" alt="" />
            </a>
        </div><!-- /Logo -->

        <!-- Main Menu --><div id="main-menu">
            <?php wp_nav_menu(array('theme_location' => 'primary', 'menu_id' => 'sf-menu', 'walker' => new header_two_uou_nav_menu) );?>
        </div><!-- /Main Menu -->

        <div class="clear"></div>

    </div>

    <div class="clear"></div>

</div>