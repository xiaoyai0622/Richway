<?php
/*
Template Name: Submit listing
*/
get_header();
the_post();

global $UouPlugins;
?>

<!-- Content --><div id="content" class="price">

<?php get_template_part('/include/html/frame','breadcrumbs')?>

<?php get_template_part('/include/html/frame','subscribe')?>

<?php if ($UouPlugins->acc->status != "enable"): ?>
    <div class="box-container">
        <div class="notification-error">
            <i class="fa fa-times-circle"></i> <?php echo __('Users Role Capabilities is disabled','metrodir'); ?>
        </div>
    </div>
<?php endif; ?>

</div><!-- /Content -->

<?php get_template_part ('footer');