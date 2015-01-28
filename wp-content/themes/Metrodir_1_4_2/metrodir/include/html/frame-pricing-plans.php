<?php global $UouPlugins;

$opt_metrodir_pp_type = get_option('opt_metrodir_pp_type');
$opt_metrodir_pp_currency = get_option('opt_metrodir_pp_currency');

if($opt_metrodir_pp_currency == "USD"){
    $opt_metrodir_pp_currency = "$";
}
elseif ($opt_metrodir_pp_currency == "EUR") {
    $opt_metrodir_pp_currency = "€";
}  elseif ($opt_metrodir_pp_currency == "GPB") {
    $opt_metrodir_pp_currency = "£";
}

if ($UouPlugins->acc->settings->role1->caps->maxcompany == -1 AND $UouPlugins->acc->settings->role2->caps->maxcompany == -1 AND $UouPlugins->acc->settings->role3->caps->maxcompany == -1 AND $UouPlugins->acc->settings->role1->caps->maxcompany == -1) {
    $opt_metrodir_acc_items = false;
} else {
    $opt_metrodir_acc_items = true;
}

if ($UouPlugins->acc->settings->role1->caps->maxpost == -1 AND $UouPlugins->acc->settings->role2->caps->maxpost == -1 AND $UouPlugins->acc->settings->role3->caps->maxpost == -1 AND $UouPlugins->acc->settings->role4->caps->maxpost == -1) {
    $opt_metrodir_acc_posts = false;
} else {
    $opt_metrodir_acc_posts = true;
}

if ($UouPlugins->acc->settings->role1->caps->maxevent == -1 AND $UouPlugins->acc->settings->role2->caps->maxevent == -1 AND $UouPlugins->acc->settings->role3->caps->maxevent == -1 AND $UouPlugins->acc->settings->role4->caps->maxevent == -1) {
    $opt_metrodir_acc_events = false;
} else {
    $opt_metrodir_acc_events = true;
}

if ($UouPlugins->acc->settings->role1->caps->maxproduct == -1 AND $UouPlugins->acc->settings->role2->caps->maxproduct == -1 AND $UouPlugins->acc->settings->role3->caps->maxproduct == -1 AND $UouPlugins->acc->settings->role4->caps->maxproduct == -1) {
    $opt_metrodir_acc_products = false;
} else {
    $opt_metrodir_acc_products = true;
}

?>

<div id="pricing-plans">
    <div class="title">
        <h2><?php echo __('Pricing Plans','metrodir'); ?></h2>
    </div>

    <div class="pricing-table">

        <?php if($UouPlugins->acc->settings->role1->on == "true"):?>
            <div class="pricing-column opacity">
                <div class="pricing-header first"><?php echo $UouPlugins->acc->settings->role1->name; ?></div>
                <div class="pricing-cost"><?php if($UouPlugins->acc->settings->role1->price == "0"){ echo '<div class="price-free">'.__('Free','metrodir').'</div>'; }else {echo '<div class="price-currency">'.$opt_metrodir_pp_currency.'</div>'; echo '<div class="price-big">'; if (($UouPlugins->acc->settings->role1->price - floor($UouPlugins->acc->settings->role1->price)) >= 0.5) echo number_format($UouPlugins->acc->settings->role1->price, 0, '', ' ') - 1; else echo number_format($UouPlugins->acc->settings->role1->price, 0, '', ' '); echo '</div>'; echo '<div class="price-small">'; if (($UouPlugins->acc->settings->role1->price - floor($UouPlugins->acc->settings->role1->price)) == 0) { echo "00";} else if (($UouPlugins->acc->settings->role1->price - floor($UouPlugins->acc->settings->role1->price)) < 0.1) echo '0'.number_format(($UouPlugins->acc->settings->role1->price - floor($UouPlugins->acc->settings->role1->price))*100, 0, '', ''); else {echo  number_format(($UouPlugins->acc->settings->role1->price - floor($UouPlugins->acc->settings->role1->price))*100, 0, '', '');} echo '</div>'; } if (($opt_metrodir_pp_type != "single") && ($UouPlugins->acc->settings->role1->price != "0")) {echo '<div class="price-period">/'; echo __($UouPlugins->acc->settings->role1->period, 'metrodir'); echo '</div>';}?></div>
                <?php if ($opt_metrodir_acc_items): ?>
                    <div class="pricing-cell"><?php if($UouPlugins->acc->settings->role1->caps->maxcompany == "0"){echo __('Unlimited','metrodir');}else if ($UouPlugins->acc->settings->role1->caps->maxcompany == -1 ){echo 'No';}else{echo $UouPlugins->acc->settings->role1->caps->maxcompany;}?> <?php if ($UouPlugins->acc->settings->role1->caps->maxcompany == 1) echo __('Company','metrodir'); else echo __('Companies','metrodir'); ?></div>
                <?php endif; ?>
                <?php if ($opt_metrodir_acc_posts): ?>
                    <div class="pricing-cell"><?php if($UouPlugins->acc->settings->role1->caps->maxpost == "0"){echo __('Unlimited','metrodir');}else if ($UouPlugins->acc->settings->role1->caps->maxpost == -1 ){echo 'No';}else{echo $UouPlugins->acc->settings->role1->caps->maxpost;}?> <?php if ($UouPlugins->acc->settings->role1->caps->maxpost == 1) echo __('Post','metrodir'); else echo __('Posts','metrodir'); ?></div>
                <?php endif; ?>
                <?php if ($opt_metrodir_acc_events AND is_plugin_active('events-manager/events-manager.php')): ?>
                    <div class="pricing-cell"><?php if($UouPlugins->acc->settings->role1->caps->maxevent == "0"){echo __('Unlimited','metrodir');}else if ($UouPlugins->acc->settings->role1->caps->maxevent == -1 ){echo 'No';}else{echo $UouPlugins->acc->settings->role1->caps->maxevent;}?> <?php if ($UouPlugins->acc->settings->role1->caps->maxevent == 1) echo __('Event','metrodir'); else echo __('Events','metrodir'); ?></div>
                <?php endif; ?>
                <?php if ($opt_metrodir_acc_products AND is_plugin_active('woocommerce/woocommerce.php')): ?>
                    <div class="pricing-cell"><?php if($UouPlugins->acc->settings->role1->caps->maxproduct == "0"){echo __('Unlimited','metrodir');}else if ($UouPlugins->acc->settings->role1->caps->maxproduct == -1 ){echo 'No';}else{echo $UouPlugins->acc->settings->role1->caps->maxproduct;}?> <?php if ($UouPlugins->acc->settings->role1->caps->maxproduct == 1) echo __('Product','metrodir'); else echo __('Products','metrodir'); ?></div>
                <?php endif; ?>
                <?php  if ($UouPlugins->stars->restriction == "enable" AND $UouPlugins->acc->settings->role1->caps->rating == "enable"): ?>
                    <div class="pricing-cell"><?php echo __('Can rate company','metrodir'); ?></div>
                <?php endif; ?>
                <?php if ($opt_metrodir_pp_type == "single"): ?>
                    <div class="pricing-cell"><?php echo __('Period of use ','metrodir'); ?> <?php if($UouPlugins->acc->settings->role1->expr == "0"){ echo __('Unlimited','metrodir');}else{ echo $UouPlugins->acc->settings->role1->expr.__(' days','metrodir');} ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if($UouPlugins->acc->settings->role2->on == "true"):?>
            <div class="pricing-column opacity">
                <div class="pricing-header second"><?php echo $UouPlugins->acc->settings->role2->name; ?></div>
                <div class="pricing-cost"><?php if($UouPlugins->acc->settings->role2->price == "0"){ echo '<div class="price-free">'.__('Free','metrodir').'</div>'; }else {echo '<div class="price-currency">'.$opt_metrodir_pp_currency.'</div>'; echo '<div class="price-big">'; if (($UouPlugins->acc->settings->role2->price - floor($UouPlugins->acc->settings->role2->price)) >= 0.5) echo number_format($UouPlugins->acc->settings->role2->price, 0, '', ' ') - 1; else echo number_format($UouPlugins->acc->settings->role2->price, 0, '', ' '); echo '</div>'; echo '<div class="price-small">'; if (($UouPlugins->acc->settings->role2->price - floor($UouPlugins->acc->settings->role2->price)) == 0) { echo "00";} else if (($UouPlugins->acc->settings->role2->price - floor($UouPlugins->acc->settings->role2->price)) < 0.1) echo '0'.number_format(($UouPlugins->acc->settings->role2->price - floor($UouPlugins->acc->settings->role2->price))*100, 0, '', ''); else {echo  number_format(($UouPlugins->acc->settings->role2->price - floor($UouPlugins->acc->settings->role2->price))*100, 0, '', '');} echo '</div>'; } if (($opt_metrodir_pp_type != "single") && ($UouPlugins->acc->settings->role2->price != "0")) {echo '<div class="price-period">/'; echo __($UouPlugins->acc->settings->role2->period, 'metrodir'); echo '</div>';}?></div>
                <?php if ($opt_metrodir_acc_items): ?>
                    <div class="pricing-cell"><?php if($UouPlugins->acc->settings->role2->caps->maxcompany == "0"){echo __('Unlimited','metrodir');}else if ($UouPlugins->acc->settings->role2->caps->maxcompany == -1 ){echo 'No';}else{echo $UouPlugins->acc->settings->role2->caps->maxcompany;}?> <?php if ($UouPlugins->acc->settings->role2->caps->maxcompany == 1) echo __('Company','metrodir'); else echo __('Companies','metrodir'); ?></div>
                <?php endif; ?>
                <?php if ($opt_metrodir_acc_posts): ?>
                    <div class="pricing-cell"><?php if($UouPlugins->acc->settings->role2->caps->maxpost == "0"){echo __('Unlimited','metrodir');}else if ($UouPlugins->acc->settings->role2->caps->maxpost == -1 ){echo 'No';}else{echo $UouPlugins->acc->settings->role2->caps->maxpost;}?> <?php if ($UouPlugins->acc->settings->role2->caps->maxpost == 1) echo __('Post','metrodir'); else echo __('Posts','metrodir'); ?></div>
                <?php endif; ?>
                <?php if ($opt_metrodir_acc_events AND is_plugin_active('events-manager/events-manager.php')): ?>
                    <div class="pricing-cell"><?php if($UouPlugins->acc->settings->role2->caps->maxevent == "0"){echo __('Unlimited','metrodir');}else if ($UouPlugins->acc->settings->role2->caps->maxevent == -1 ){echo 'No';}else{echo $UouPlugins->acc->settings->role2->caps->maxevent;}?> <?php if ($UouPlugins->acc->settings->role2->caps->maxevent == 1) echo __('Event','metrodir'); else echo __('Events','metrodir'); ?></div>
                <?php endif; ?>
                <?php if ($opt_metrodir_acc_products AND is_plugin_active('woocommerce/woocommerce.php')): ?>
                    <div class="pricing-cell"><?php if($UouPlugins->acc->settings->role2->caps->maxproduct == "0"){echo __('Unlimited','metrodir');}else if ($UouPlugins->acc->settings->role2->caps->maxproduct == -1 ){echo 'No';}else{echo $UouPlugins->acc->settings->role2->caps->maxproduct;}?> <?php if ($UouPlugins->acc->settings->role2->caps->maxproduct == 1) echo __('Product','metrodir'); else echo __('Products','metrodir'); ?></div>
                <?php endif; ?>
                <?php  if ($UouPlugins->stars->restriction == "enable" AND $UouPlugins->acc->settings->role2->caps->rating == "enable"): ?>
                    <div class="pricing-cell"><?php echo __('Can rate company','metrodir'); ?></div>
                <?php endif; ?>
                <?php if ($opt_metrodir_pp_type == "single"): ?>
                    <div class="pricing-cell"><?php echo __('Period of use ','metrodir'); ?> <?php if($UouPlugins->acc->settings->role2->expr == "0"){ echo __('Unlimited','metrodir');}else{ echo $UouPlugins->acc->settings->role2->expr.__(' days','metrodir');} ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if($UouPlugins->acc->settings->role3->on == "true"):?>
            <div class="pricing-column opacity">
                <div class="pricing-header third"><?php echo $UouPlugins->acc->settings->role3->name; ?></div>
                <div class="pricing-cost"><?php if($UouPlugins->acc->settings->role3->price == "0"){ echo '<div class="price-free">'.__('Free','metrodir').'</div>'; }else {echo '<div class="price-currency">'.$opt_metrodir_pp_currency.'</div>'; echo '<div class="price-big">'; if (($UouPlugins->acc->settings->role3->price - floor($UouPlugins->acc->settings->role3->price)) >= 0.5) echo number_format($UouPlugins->acc->settings->role3->price, 0, '', ' ') - 1; else echo number_format($UouPlugins->acc->settings->role3->price, 0, '', ' '); echo '</div>'; echo '<div class="price-small">'; if (($UouPlugins->acc->settings->role3->price - floor($UouPlugins->acc->settings->role3->price)) == 0) { echo "00";} else if (($UouPlugins->acc->settings->role3->price - floor($UouPlugins->acc->settings->role3->price)) < 0.1) echo '0'.number_format(($UouPlugins->acc->settings->role3->price - floor($UouPlugins->acc->settings->role3->price))*100, 0, '', ''); else {echo  number_format(($UouPlugins->acc->settings->role3->price - floor($UouPlugins->acc->settings->role3->price))*100, 0, '', '');} echo '</div>'; } if (($opt_metrodir_pp_type != "single") && ($UouPlugins->acc->settings->role3->price != "0")) {echo '<div class="price-period">/'; echo __($UouPlugins->acc->settings->role3->period, 'metrodir'); echo '</div>';}?></div>
                <?php if ($opt_metrodir_acc_items): ?>
                    <div class="pricing-cell"><?php if($UouPlugins->acc->settings->role3->caps->maxcompany == "0"){echo __('Unlimited','metrodir');}else if ($UouPlugins->acc->settings->role3->caps->maxcompany == -1 ){echo 'No';}else{echo $UouPlugins->acc->settings->role3->caps->maxcompany;}?> <?php if ($UouPlugins->acc->settings->role3->caps->maxcompany == 1) echo __('Company','metrodir'); else echo __('Companies','metrodir'); ?></div>
                <?php endif; ?>
                <?php if ($opt_metrodir_acc_posts): ?>
                    <div class="pricing-cell"><?php if($UouPlugins->acc->settings->role3->caps->maxpost == "0"){echo __('Unlimited','metrodir');}else if ($UouPlugins->acc->settings->role3->caps->maxpost == -1 ){echo 'No';}else{echo $UouPlugins->acc->settings->role3->caps->maxpost;}?> <?php if ($UouPlugins->acc->settings->role3->caps->maxpost == 1) echo __('Post','metrodir'); else echo __('Posts','metrodir'); ?></div>
                <?php endif; ?>
                <?php if ($opt_metrodir_acc_events AND is_plugin_active('events-manager/events-manager.php')): ?>
                    <div class="pricing-cell"><?php if($UouPlugins->acc->settings->role3->caps->maxevent == "0"){echo __('Unlimited','metrodir');}else if ($UouPlugins->acc->settings->role3->caps->maxevent == -1 ){echo 'No';}else{echo $UouPlugins->acc->settings->role3->caps->maxevent;}?> <?php if ($UouPlugins->acc->settings->role3->caps->maxevent == 1) echo __('Event','metrodir'); else echo __('Events','metrodir'); ?></div>
                <?php endif; ?>
                <?php if ($opt_metrodir_acc_products AND is_plugin_active('woocommerce/woocommerce.php')): ?>
                    <div class="pricing-cell"><?php if($UouPlugins->acc->settings->role3->caps->maxproduct == "0"){echo __('Unlimited','metrodir');}else if ($UouPlugins->acc->settings->role3->caps->maxproduct == -1 ){echo 'No';}else{echo $UouPlugins->acc->settings->role3->caps->maxproduct;}?> <?php if ($UouPlugins->acc->settings->role3->caps->maxproduct == 1) echo __('Product','metrodir'); else echo __('Products','metrodir'); ?></div>
                <?php endif; ?>
                <?php  if ($UouPlugins->stars->restriction == "enable" AND $UouPlugins->acc->settings->role3->caps->rating == "enable"): ?>
                    <div class="pricing-cell"><?php echo __('Can rate company','metrodir'); ?></div>
                <?php endif; ?>
                <?php if ($opt_metrodir_pp_type == "single"): ?>
                    <div class="pricing-cell"><?php echo __('Period of use ','metrodir'); ?> <?php if($UouPlugins->acc->settings->role3->expr == "0"){ echo __('Unlimited','metrodir');}else{ echo $UouPlugins->acc->settings->role3->expr.__(' days','metrodir');} ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if($UouPlugins->acc->settings->role4->on == "true"):?>
            <div class="pricing-column opacity">
                <div class="pricing-header fourth"><?php echo $UouPlugins->acc->settings->role4->name; ?></div>
                <div class="pricing-cost"><?php if($UouPlugins->acc->settings->role4->price == "0"){ echo '<div class="price-free">'.__('Free','metrodir').'</div>'; }else {echo '<div class="price-currency">'.$opt_metrodir_pp_currency.'</div>'; echo '<div class="price-big">'; if (($UouPlugins->acc->settings->role4->price - floor($UouPlugins->acc->settings->role4->price)) >= 0.5) echo number_format($UouPlugins->acc->settings->role4->price, 0, '', ' ') - 1; else echo number_format($UouPlugins->acc->settings->role4->price, 0, '', ' '); echo '</div>'; echo '<div class="price-small">'; if (($UouPlugins->acc->settings->role4->price - floor($UouPlugins->acc->settings->role4->price)) == 0) { echo "00";} else if (($UouPlugins->acc->settings->role4->price - floor($UouPlugins->acc->settings->role4->price)) < 0.1) echo '0'.number_format(($UouPlugins->acc->settings->role4->price - floor($UouPlugins->acc->settings->role4->price))*100, 0, '', ''); else {echo  number_format(($UouPlugins->acc->settings->role4->price - floor($UouPlugins->acc->settings->role4->price))*100, 0, '', '');} echo '</div>'; } if (($opt_metrodir_pp_type != "single") && ($UouPlugins->acc->settings->role4->price != "0")) {echo '<div class="price-period">/'; echo __($UouPlugins->acc->settings->role4->period, 'metrodir'); echo '</div>';}?></div>
                <?php if ($opt_metrodir_acc_items): ?>
                    <div class="pricing-cell"><?php if($UouPlugins->acc->settings->role4->caps->maxcompany == "0"){echo __('Unlimited','metrodir');}else if ($UouPlugins->acc->settings->role4->caps->maxcompany == -1 ){echo 'No';}else{echo $UouPlugins->acc->settings->role4->caps->maxcompany;}?> <?php if ($UouPlugins->acc->settings->role4->caps->maxcompany == 1) echo __('Company','metrodir'); else echo __('Companies','metrodir'); ?></div>
                <?php endif; ?>
                <?php if ($opt_metrodir_acc_posts): ?>
                    <div class="pricing-cell"><?php if($UouPlugins->acc->settings->role4->caps->maxpost == "0"){echo __('Unlimited','metrodir');}else if ($UouPlugins->acc->settings->role4->caps->maxpost == -1 ){echo 'No';}else{echo $UouPlugins->acc->settings->role4->caps->maxpost;}?> <?php if ($UouPlugins->acc->settings->role4->caps->maxpost == 1) echo __('Post','metrodir'); else echo __('Posts','metrodir'); ?></div>
                <?php endif; ?>
                <?php if ($opt_metrodir_acc_events AND is_plugin_active('events-manager/events-manager.php')): ?>
                    <div class="pricing-cell"><?php if($UouPlugins->acc->settings->role4->caps->maxevent == "0"){echo __('Unlimited','metrodir');}else if ($UouPlugins->acc->settings->role4->caps->maxevent == -1 ){echo 'No';}else{echo $UouPlugins->acc->settings->role4->caps->maxevent;}?> <?php if ($UouPlugins->acc->settings->role4->caps->maxevent == 1) echo __('Event','metrodir'); else echo __('Events','metrodir'); ?></div>
                <?php endif; ?>
                <?php if ($opt_metrodir_acc_products AND is_plugin_active('woocommerce/woocommerce.php')): ?>
                    <div class="pricing-cell"><?php if($UouPlugins->acc->settings->role4->caps->maxproduct == "0"){echo __('Unlimited','metrodir');}else if ($UouPlugins->acc->settings->role4->caps->maxproduct == -1 ){echo 'No';}else{echo $UouPlugins->acc->settings->role4->caps->maxproduct;}?> <?php if ($UouPlugins->acc->settings->role4->caps->maxproduct == 1) echo __('Product','metrodir'); else echo __('Products','metrodir'); ?></div>
                <?php endif; ?>
                <?php  if ($UouPlugins->stars->restriction == "enable" AND $UouPlugins->acc->settings->role4->caps->rating == "enable"): ?>
                    <div class="pricing-cell"><?php echo __('Can rate company','metrodir'); ?></div>
                <?php endif; ?>
                <?php if ($opt_metrodir_pp_type == "single"): ?>
                    <div class="pricing-cell"><?php echo __('Period of use ','metrodir'); ?> <?php if($UouPlugins->acc->settings->role4->expr == "0"){ echo __('Unlimited','metrodir');}else{ echo $UouPlugins->acc->settings->role4->expr.__(' days','metrodir');} ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="clear"></div>

    </div>

</div>