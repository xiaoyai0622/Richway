<?php
//Welcome Block
$opt_metrodir_home_wlcm_image = get_option('opt_metrodir_home_wlcm_image');
$opt_metrodir_home_wlcm_link = get_option('opt_metrodir_home_wlcm_link');
$opt_metrodir_home_wlcm_title = get_option('opt_metrodir_home_wlcm_title');
$opt_metrodir_home_wlcm_text = get_option('opt_metrodir_home_wlcm_text');
?>
<?php if ($opt_metrodir_home_wlcm_text): ?>
    <!-- Welcome --><div id="welcome"><div class="box-container">

        <?php if ($opt_metrodir_home_wlcm_image): ?>
        <div class="welcome-left">
            <?php if ($opt_metrodir_home_wlcm_link): ?>
                <a class="opacity" href="<?php echo $opt_metrodir_home_wlcm_link; ?>"><img src="<?php echo $opt_metrodir_home_wlcm_image; ?>" alt=""/></a>
            <?php else: ?>
                <img src="<?php echo $opt_metrodir_home_wlcm_image; ?>" alt=""/>
            <?php endif; ?>
        </div>

        <div class="welcome-right">
        <?php endif; ?>

            <?php if ($opt_metrodir_home_wlcm_title): ?>
                <div class="title">
                    <h1><?php echo $opt_metrodir_home_wlcm_title; ?></h1>
                </div>
            <?php endif; ?>

            <div class="welcome-text">
                <?php echo $opt_metrodir_home_wlcm_text; ?>
            </div>

        <?php if ($opt_metrodir_home_wlcm_image): ?>
        </div>

        <div class="clear"></div>
        <?php endif; ?>

    </div></div><!-- /Welcome -->
<?php endif; ?>

