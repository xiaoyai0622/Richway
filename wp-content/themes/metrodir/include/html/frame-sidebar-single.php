<?php

$opt_metrodir_sidebar_widgets = get_option('opt_metrodir_sidebar_widgets');

?>

<?php get_template_part('/include/html/frame','sidebar'); ?>

<?php if ($opt_metrodir_sidebar_widgets == "true"):
/* When we call the dynamic_sidebar() function */
if ( ! dynamic_sidebar( 'sidebar-widget-area' ) ): ?>
<?php endif; endif; // end primary widget area