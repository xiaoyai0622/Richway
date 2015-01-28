<?php
//Get Variables
$slider_id = get_option('opt_metrodir_home_revslider');
?>

<?php if (is_plugin_active('revslider/revslider.php')): ?>
    <!-- Slider--><div id="slider"><div class="box-container">
        <?php putRevSlider($slider_id); ?>
    </div></div><!-- /Slider-->
<?php else: ?>
    <!-- Message --><div class="notification-error"><div class="box-container">
        <?php echo '<i class="fa fa-times-circle"></i> '.__("Revolution slider is deactivate", "metrodir"); ?>
    </div></div><!-- /Message -->
<?php endif; ?>