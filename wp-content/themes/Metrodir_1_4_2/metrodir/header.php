<?php
//Get variables metrodir_Options
//Site options
$opt_metrodir_site_logo = get_option('opt_metrodir_site_logo');
$opt_metrodir_boxed_version = get_option('opt_metrodir_boxed_version');
$opt_metrodir_favicon = get_option('opt_metrodir_favicon');
$opt_metrodir_header_version = get_option('opt_metrodir_header_version');
$opt_metrodir_rtl = get_option('opt_metrodir_site_rtl');
$opt_metrodir_google_analytics = stripslashes(get_option('opt_metrodir_google_analytics'));
$opt_metrodir_google_ads = stripslashes(get_option('opt_metrodir_google_ads'));
$demoversion = get_option('opt_metrodir_site_demo');
?>

<!doctype html>
<!--[if IE 8]><html class="no-js oldie ie8 ie" <?php language_attributes(); ?>><![endif]-->
<!--[if gte IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->

<head>
    <title><?php bloginfo('name');  echo " "; wp_title(); ?> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
    <meta name="Description" content="<?php bloginfo('description'); ?>" />
    <meta http-equiv="content-type" content="text/html; charset=<?php bloginfo('charset'); ?>"/>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php
        if ($opt_metrodir_favicon)
            {echo "<link rel='shortcut icon' type='image/x-icon' href='".$opt_metrodir_favicon ."' />";}
        else
            {echo "<link rel='shortcut icon' type='image/x-icon' href='". get_template_directory_uri()."/favicon.ico'/>";}
    ?>
    <!--[if IE]>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/styles-ie8-and-down.css" />
    <![endif]-->
    <?php echo $opt_metrodir_google_analytics; ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?><?php if ($opt_metrodir_rtl == "true") echo ' style="direction: rtl;"'; ?>>

<?php if($demoversion == "true"): ?>
    <div id="themepath" style="display: none;"><?php echo get_template_directory_uri(); ?></div>
    <div id="theme-switcher" class="theme-switcher visible">
        <div id="switcher-toggle-button" class="switcher-toggle-button"><i class="fa fa-wrench fa-2x"></i></div>
        <div class="label">Colors</div>
        <ul id="color-switcher" class="color-switcher">
            <li class="first"><div class="first-color"></div><div class="second-color"></div><i class="fa fa-check"></i></li>
            <li class="second"><div class="first-color"></div><div class="second-color"></div><i class=""></i></li>
            <li class="third"><div class="first-color"></div><div class="second-color"></div><i class=""></i></li>
            <li class="fourth"><div class="first-color"></div><div class="second-color"></div><i class=""></i></li>
        </ul>
        <div class="label">Layout</div>
        <select id="layout-switcher" class="layout-switcher" name="layout-switcher">
            <option selected="selected" value="fullscreen">Fullscreen</option>
            <option value="boxed">Boxed</option>
        </select>
        <div class="label">Background</div>
        <ul id="background-switcher" class="background-switcher">
            <li class="background-1"><i class=""></i></li>
            <li class="background-2"><i class=""></i></li>
            <li class="background-3"><i class=""></i></li>
        </ul>
    </div>
<?php endif; ?>

<!-- Background Shadow For Login Block --><div id="login-shadow"></div><!-- /Background Shadow For Login Block -->

<?php
$wrapper_class = '';
if (($opt_metrodir_boxed_version == 'yes') && ($opt_metrodir_rtl == "true")) {
    $wrapper_class = ' class="boxed rtl"';
} else if ($opt_metrodir_boxed_version == 'yes') {
    $wrapper_class = ' class="boxed no-rtl"';
} else if ($opt_metrodir_rtl == "true") {
    $wrapper_class = ' class="rtl"';
} else {
    $wrapper_class = ' class="no-rtl"';
}
?>

<!-- Section Main --><section id="main-content">

<!-- Header --><header<?php echo $wrapper_class; ?>><div id="header" class="box-container">
        <?php get_template_part ('/include/html/str-header', $opt_metrodir_header_version);?>
</div></header><!-- /Header -->

<!-- Section Wrapper --><section<?php echo $wrapper_class; ?>>