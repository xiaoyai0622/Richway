<?php
/*
Template Name: Contact us
*/
get_header();
the_post();

//Get variables metrodir_Options

//company info
$opt_metrodir_company_email = get_option('opt_metrodir_company_email');
$opt_metrodir_company_phone = get_option('opt_metrodir_company_phone');
$opt_metrodir_company_fax = get_option('opt_metrodir_company_fax');
$opt_metrodir_company_address = get_option('opt_metrodir_company_address');
$opt_metrodir_company_website = get_option('opt_metrodir_company_website');
$opt_metrodir_company_address_lat = get_option('opt_metrodir_company_address_lat');
$opt_metrodir_company_address_lng = get_option('opt_metrodir_company_address_lng');
//company opening
$opt_metrodir_company_1int_day = get_option('opt_metrodir_company_1int_day');
$opt_metrodir_company_1int_hr = get_option('opt_metrodir_company_1int_hr');
$opt_metrodir_company_2int_day = get_option('opt_metrodir_company_2int_day');
$opt_metrodir_company_2int_hr = get_option('opt_metrodir_company_2int_hr');
$opt_metrodir_company_3int_day = get_option('opt_metrodir_company_3int_day');
$opt_metrodir_company_3int_hr = get_option('opt_metrodir_company_3int_hr');
$opt_metrodir_company_4int_day = get_option('opt_metrodir_company_4int_day');
$opt_metrodir_company_4int_hr = get_option('opt_metrodir_company_4int_hr');
//Sidebar options
$opt_metrodir_sidebar = get_option('opt_metrodir_sidebar');
?>

<!-- Content --><div id="content" class="contact-us">

    <?php get_template_part('/include/html/frame','breadcrumbs')?>

    <!-- Content Inner --><div id="content-inner" class="sidebar-<?php echo $opt_metrodir_sidebar; ?>"><div class="box-container">

        <!-- Sidebar --><div id="sidebar"><?php get_template_part('/include/html/frame','sidebar-single'); ?></div><!-- /Sidebar -->

        <!-- Content Center --><div id="content-center">

            <div class="title">
                <h2><?php echo __('Find Us on Map','metrodir'); ?></h2>
            </div>

            <div id="contact-page-map">
                <div id="markers_center" style="display: none">
                    <div class="latitude"><?php echo $opt_metrodir_company_address_lat;?></div>
                    <div class="longitude"><?php echo $opt_metrodir_company_address_lng;?></div>
                    <div class="marker"><?php echo get_template_directory_uri().'/images/marker.png';?></div>
                </div>
            </div>

            <div class="title">
                <h2><?php echo __('Send Us a Message','metrodir'); ?></h2>
            </div>

            <div id="contact-message">
                <form method="post" id="contact-message-form">
                    <input type="text" name="name" class="text-input-grey one-line" placeholder="<?php echo __('Name','metrodir'); ?> *" />
                    <input type="text" name="email" class="text-input-grey one-line" placeholder="<?php echo __('E-mail','metrodir'); ?> *" />
                    <div class="clear"></div>
                    <input type="text" name="website" class="text-input-grey" placeholder="<?php echo __('Website','metrodir'); ?>" />
                    <div class="clear"></div>
                    <textarea name="message" class="text-input-grey" placeholder="<?php echo __('How can we help you?','metrodir'); ?>"></textarea>
                    <div class="clear"></div>
                    <div class="submit"><i class="fa fa-sign-out"></i><input type="submit" name="submit" value="<?php echo __('Send Message','metrodir'); ?>" id="button-2-green" /></div>
                    <?php /*Use Verification form*/ wp_nonce_field('send_mail_metrodir', 'noncename_metrodir' ); ?>
                </form>
            </div>

            <div id="contact-details">

                <div class="company-address">

                    <div class="title">
                        <h2><?php echo __('Address Details','metrodir'); ?></h2>
                    </div>

                    <?php if($opt_metrodir_company_address):?>
                        <div class="detail address">
                            <div class="detail-icon"><i class="fa fa-map-marker fa-2x"></i></div>
                            <div class="detail-content"><?php echo $opt_metrodir_company_address; ?></div>
                            <div class="clear"></div>
                        </div>
                    <?php endif; ?>

                    <?php if($opt_metrodir_company_phone OR $opt_metrodir_company_fax):?>
                        <div class="detail phone">
                            <div class="detail-icon"><i class="fa fa-phone fa-2x"></i></div>
                            <div class="detail-content">
                                <?php if($opt_metrodir_company_phone): ?>
                                    <div class="detail-field"><span><?php echo __('Phone','metrodir'); ?>: </span><?php echo $opt_metrodir_company_phone; ?></div>
                                <?php endif; ?>
                                <?php if($opt_metrodir_company_fax): ?>
                                <div class="detail-field"><span><?php echo __('Fax','metrodir'); ?>: </span><?php echo $opt_metrodir_company_fax; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                    <?php endif; ?>

                    <?php if($opt_metrodir_company_email OR $opt_metrodir_company_website ):?>
                        <div class="detail email">
                            <div class="detail-icon"><i class="fa fa-envelope-o fa-2x"></i></div>
                            <div class="detail-content">
                                <?php if($opt_metrodir_company_email): ?>
                                    <div class="detail-field"><span><?php echo __('E-mail','metrodir'); ?>: </span><a href="mailto:<?php echo $opt_metrodir_company_email; ?>" class="text-green"><?php echo $opt_metrodir_company_email; ?></a></div>
                                <?php endif; ?>
                                <?php if($opt_metrodir_company_website): ?>
                                    <div class="detail-field"><span><?php echo __('Website','metrodir'); ?>: </span><a href="<?php echo $opt_metrodir_company_website; ?>" class="text-green"> <?php echo $opt_metrodir_company_website; ?></a></div>
                                <?php endif; ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="company-hours">

                    <div class="title">
                        <h2><?php echo __('Opening Hours','metrodir'); ?></h2>
                    </div>

                    <table>
                        <?php if($opt_metrodir_company_1int_day): ?>
                            <tr class="opening-period">
                                <td class="opening-label"><?php echo $opt_metrodir_company_1int_day; ?>:</td><td class="opening-hour"><?php echo $opt_metrodir_company_1int_hr; ?></td>
                            </tr>
                        <?php endif; ?>

                        <?php if($opt_metrodir_company_2int_day): ?>
                            <tr class="opening-period">
                                <td class="opening-label"><?php echo $opt_metrodir_company_2int_day; ?>:</td><td class="opening-hour"><?php echo $opt_metrodir_company_2int_hr; ?></td>
                            </tr>
                        <?php endif; ?>

                        <?php if($opt_metrodir_company_3int_day): ?>
                            <tr class="opening-period">
                                <td class="opening-label"><?php echo $opt_metrodir_company_3int_day; ?>:</td><td class="opening-hour"><?php echo $opt_metrodir_company_3int_hr; ?></td>
                            </tr>
                        <?php endif; ?>

                        <?php if($opt_metrodir_company_4int_day): ?>
                            <tr class="opening-period">
                                <td class="opening-label"><?php echo $opt_metrodir_company_4int_day; ?>:</td><td class="opening-hour"><?php echo $opt_metrodir_company_4int_hr; ?></td>
                            </tr>
                        <?php endif; ?>
                    </table>

                </div>

            </div>

        </div><!-- /Content Center -->

        <div class="clear"></div>

    </div></div><!-- /Content Inner -->

</div><!-- /Content -->

<?php get_template_part ('footer');