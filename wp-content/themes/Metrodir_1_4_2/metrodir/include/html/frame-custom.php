<?php
// Get variables
$opt_metrodir_home_customblck = get_option('opt_metrodir_home_customblck');
$opt_metrodir_home_customblck_h2 = get_option('opt_metrodir_home_customblck_h2');
$opt_metrodir_home_customblck_active = get_option('opt_metrodir_home_customblck_active');
?>
<?php if ($opt_metrodir_home_customblck_active == "true"): ?>
    <!-- Custom Block --><div id="custom-home-block"><div class="box-container">

            <?php if ($opt_metrodir_home_customblck_h2): ?>
                <div class="title">
                    <h2><?php echo $opt_metrodir_home_customblck_h2; ?></h2>
                </div>
            <?php endif; ?>

            <div class="custom-home-block-text">
                <?php echo $opt_metrodir_home_customblck; ?>
            </div>

    </div></div><!-- /Custom Block -->
<?php endif; ?>