<?php

function skl_admin_options() {
//tcsssssssssssss
}


//Admin init
function uou_admin_init() {
    $opt = "uou_opt_plugins";
    register_setting($opt, $opt);



    if(isset($_GET['page']) and $_GET['page'] == 'siteoptions-plugins' and isset($_GET['settings-updated']) and $_GET['settings-updated'] == 'true'){

        ?>

        <div id="setting-error-settings_updated" class="updated settings-error">
            <p><strong><?php _e('Settings saved.', 'metrodir'); ?></strong></p>
        </div>

        <?php
        exit;
    }
}
add_action( 'admin_init', 'uou_admin_init' );




function skl_admin_options_plugin() {
global $UouPlugins;
$opt = "uou_opt_plugins";
$tabs = $_GET['tabs'];
    ?>
<div id="get_homeurl" data-homeurl="<?php echo get_template_directory_uri(); ?>"></div>

<div id="uouplugins" class="wrap">
    <div class="head">
        <div class="title">
            <span>UOU Plugins Control Panel</span>
        </div>
        <div class="tabs">
            <a href="<?php echo admin_url('admin.php?page=siteoptions'); ?>" class="a-tab">Metrodir CP</a>
            <a href="<?php echo admin_url('admin.php?page=siteoptions-plugins'); ?>" class="a-tab<?php if(!$tabs) echo " active"; ?>">Rating system</a>
            <a href="<?php echo admin_url('admin.php?page=siteoptions-plugins&tabs=acc'); ?>" class="a-tab<?php if($tabs == "acc") echo " active"; ?>">Account settings</a>
            <a href="<?php echo admin_url('admin.php?page=siteoptions-plugins&tabs=fields'); ?>" class="a-tab<?php if($tabs == "fields") echo " active"; ?>">Restriction fields</a>
        </div>
    </div>

    <form action="<?php echo admin_url('options.php'); ?>" method="post" id="settings-form">
        <?php settings_fields($opt); ?>
         <div class="uousettingsform">
            <div style="display: <?php if(!$tabs){echo " block";}else{echo " none";} ?>">
            <?php
                include_once dirname(__FILE__) . '/opt/ratings.php';
            ?>
            </div>
            <div style="display: <?php if($tabs == "acc"){echo " block";}else{echo " none";} ?>">
            <?php
                include_once dirname(__FILE__) . '/opt/accounts.php';
            ?>
            </div>
            <div style="display: <?php if($tabs == "fields"){echo " block";}else{echo " none";} ?>">
                <?php
                include_once dirname(__FILE__) . '/opt/fields.php';
                ?>
            </div>

            <div id="uousave"><input type="submit" class="save-button button-primary" value="<?php _e('Save settings','metrodir'); ?>" /></div>
        </div>


    </form>

</div>
<?php
}


