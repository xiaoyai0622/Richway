<?php
get_header();
?>

<!-- Content --><div id="content">

    <?php get_template_part('/include/html/frame','breadcrumbs')?>

    <!-- 404 Error --><div id="error-no-found"><div class="box-container">
        <div class="title"><h1><?php echo '<strong>'.__('Error 404','metrodir').'</strong> - '.__('Page Not Found','metrodir'); ?></h1></div>
        <div class="text"><p><?php echo __('Sorry, the page you are looking for might have been removed, had its name changed, or is temporarily unavailable.','metrodir'); ?></p></div>
    </div></div><!-- /404 Error-->

</div><!-- /Content -->

<?php get_template_part ('footer');
