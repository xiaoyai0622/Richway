<?php
//Get variables
$item_email = $custom[$shortname.'_company_soc_email'][0];
?>



<!-- Sidebar --><div id="sidebar"><?php get_template_part('/include/html/frame','sidebar')?></div><!-- /Sidebar -->

<!-- Content Center --><div id="content-center">

    <?php if ($custom[$shortname.'_address_lat'][0] AND $custom[$shortname.'_address_lng'][0]): ?>
        <div class="title">
            <h2><?php echo __('Find Us on Map','metrodir'); ?></h2>
        </div>
        <div id="contact-page-map">
            <div id="markers_center" style="display: none">
                <div class="latitude"><?php echo $custom[$shortname.'_address_lat'][0]; ?></div>
                <div class="longitude"><?php echo $custom[$shortname.'_address_lng'][0]; ?></div>
                <div class="marker"><?php echo get_template_directory_uri().'/images/marker.png';?></div>
            </div>
        </div>
    <?php endif; ?>

    <div class="title">
        <h2><?php echo __('Send Us a Message','metrodir'); ?></h2>
    </div>

    <div id="contact-message">
        <form method="post" id="contact-single-message-form">
            <input type="text" name="name" class="text-input-grey one-line" placeholder="<?php echo __('Name','metrodir').' / '.__('Company Name','metrodir').' *'; ?>" />
            <input type="text" name="email" class="text-input-grey one-line" placeholder="<?php echo __('Your E-mail','metrodir').' *'; ?>" />
            <div class="clear"></div>
            <input type="text" name="website" class="text-input-grey website" placeholder="<?php echo __('Subject','metrodir'); ?>" />
            <div class="clear"></div>
            <textarea name="message" class="text-input-grey comment-message-main" placeholder="<?php echo __('How can we help You?','metrodir'); ?>"></textarea>
            <div class="clear"></div>
            <input type="text" name="mailto" value="<?php echo $item_email; ?>" style="display:none" readonly/>
            <div class="submit"><i class="fa fa-sign-out"></i><input type="submit" name="submit" value="<?php echo __('Send Message','metrodir'); ?>" id="button-2-green" /></div>

        </form>
    </div>

    <div id="contact-details">

        <div class="company-address">

            <div class="title">
                <h2><?php echo __('Address Details','metrodir'); ?></h2>
            </div>

            <?php //Get variables
                $item_adrs_country = $custom[$shortname . '_address_country_name'][0];
                $item_adrs_region = $custom[$shortname . '_address_region_name'][0];
                $item_adrs = $custom[$shortname . '_address_name'][0];
            ?>
            <?php if($item_adrs_country OR $item_adrs_region OR $item_adrs): ?>
                <div class="detail address">
                    <div class="detail-icon"><i class="fa fa-map-marker fa-2x"></i></div>
                    <div class="detail-content"><?php if ($item_adrs_country) {echo $item_adrs_country.', ';} if ($item_adrs_region) {echo $item_adrs_region.', ';} if ($item_adrs) {echo $item_adrs;} ?></div>
                    <div class="clear"></div>
                </div>
            <?php endif; ?>

            <?php //Get variables
                $item_phone = $custom[$shortname.'_company_doc_phone'][0];
                $item_fax = $custom[$shortname.'_company_soc_fax'][0];
            ?>
            <?php if($item_phone OR $item_fax):?>
                <div class="detail phone">
                    <div class="detail-icon"><i class="fa fa-phone fa-2x"></i></div>
                    <div class="detail-content">
                        <?php if($item_phone): ?>
                            <div class="detail-field"><span><?php echo __('Phone','metrodir'); ?>: </span><?php echo $item_phone; ?></div>
                        <?php endif; ?>
                        <?php if($item_fax): ?>
                            <div class="detail-field"><span><?php echo __('Fax','metrodir'); ?>: </span><?php echo $item_fax; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php endif; ?>

            <?php $item_website = $custom[$shortname.'_company_soc_web'][0]; if($opt_metrodir_company_email OR $item_website ):?>
                <div class="detail email">
                    <div class="detail-icon"><i class="fa fa-envelope-o fa-2x"></i></div>
                    <div class="detail-content">
                        <?php if($item_email): ?>
                            <div class="detail-field"><span><?php echo __('E-mail','metrodir'); ?>: </span><a href="mailto:<?php echo $item_email; ?>" class="text-green"><?php echo $item_email; ?></a></div>
                        <?php endif; ?>
                        <?php if($item_website): ?>
                            <div class="detail-field"><span><?php echo __('Website','metrodir'); ?>: </span><a href="<?php echo $item_website; ?>" class="text-green"> <?php echo $item_website; ?></a></div>
                        <?php endif; ?>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php endif; ?>

        </div>


        <?php //Get variables
        $item_dayint1 = $custom[$shortname.'_company_soc_openhrs1'][0];
        $item_dayint2 = $custom[$shortname.'_company_soc_openhrs2'][0];
        $item_dayint3 = $custom[$shortname.'_company_soc_openhrs3'][0];
        $item_dayint4 = $custom[$shortname.'_company_soc_openhrs4'][0];
        ?>
        <?php if ($item_dayint1 OR $item_dayint2 OR $item_dayint3 OR $item_dayint4): ?>
        <div class="company-hours">

            <div class="title">
                <h2><?php echo __('Opening Hours','metrodir'); ?></h2>
            </div>

            <table>
                <?php if($item_dayint1): ?>
                    <?php $dayint1arr = explode(',', $item_dayint1); ?>
                    <tr class="opening-period">
                        <td class="opening-label"><?php echo $dayint1arr[0]; ?></td><td class="opening-hour"><?php echo $dayint1arr[1]; ?></td>
                    </tr>
                <?php endif; ?>

                <?php if($item_dayint2): ?>
                    <?php $dayint2arr = explode(',', $item_dayint2); ?>
                    <tr class="opening-period">
                        <td class="opening-label"><?php echo $dayint2arr[0]; ?></td><td class="opening-hour"><?php echo $dayint2arr[1]; ?></td>
                    </tr>
                <?php endif; ?>

                <?php if($item_dayint3): ?>
                    <?php $dayint3arr = explode(',', $item_dayint3); ?>
                    <tr class="opening-period">
                        <td class="opening-label"><?php echo $dayint3arr[0]; ?></td><td class="opening-hour"><?php echo $dayint3arr[1]; ?></td>
                    </tr>
                <?php endif; ?>

                <?php if($item_dayint4): ?>
                    <?php $dayint4arr = explode(',', $item_dayint4); ?>
                    <tr class="opening-period">
                        <td class="opening-label"><?php echo $dayint4arr[0]; ?></td><td class="opening-hour"><?php echo $dayint4arr[1]; ?></td>
                    </tr>
                <?php endif; ?>
            </table>

        </div>
        <?php endif; ?>

    </div>

</div><!-- /Content Center -->

<div class="clear"></div>

