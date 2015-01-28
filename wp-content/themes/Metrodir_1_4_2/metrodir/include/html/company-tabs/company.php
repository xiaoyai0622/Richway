<?php

//Not Found used variables, maybe it use in other tabs...

$opt_metrodir_stars_act = get_option('opt_metrodir_stars_act');

if (isset($custom[$shortname . '_company_type'][0])) $item_type = $custom[$shortname . '_company_type'][0];

if (isset($custom[$shortname . '_company_position'][0])) $item_position = $custom[$shortname . '_company_position'][0];

if (isset($custom[$shortname . '_company_doc_profile_desc'][0])) $item_profile_desc = $custom[$shortname . '_company_doc_profile_desc'][0];

if (isset($custom[$shortname . '_shw_strv'][0])) $item_shwstrv = $custom[$shortname . '_shw_strv'][0];

?>

<!-- Sidebar --><div id="sidebar">

    <?php if (isset($custom[$shortname.'_address_lat'][0]) AND isset($custom[$shortname.'_address_lng'][0]) and $custom[$shortname.'_address_lat'][0] and $custom[$shortname.'_address_lng'][0]): ?>
        <!-- Company Map --><div id="company-page-map">
            <div id="markers_center" style="display: none">
                <div class="latitude"><?php echo $custom[$shortname.'_address_lat'][0]; ?></div>
                <div class="longitude"><?php echo $custom[$shortname.'_address_lng'][0]; ?></div>
                <div class="marker"><?php echo get_template_directory_uri().'/images/marker.png';?></div>
            </div>
        </div><!-- /Company Map -->
    <?php endif; ?>

    <?php $user = new WP_User(intval($GLOBALS['wp_query']->post->post_author));
    $already_claimed = isMetrodirUser($user);
    if(($UouPlugins->claim->status == "enable") && (!$already_claimed)): ?>

        <div id="claim-company"><i class="fa fa-chevron-circle-down"></i>&nbsp;&nbsp;<?php echo __('Own This Company?','metrodir'); ?></div>

        <div id="claim-company-form" style="display: none;" data-post-id="<?php echo $post->ID; ?>">
            <div class="title">
                <h2><?php echo __('Claim This','metrodir'); ?></h2>
            </div>
            <div style="display: none;" class="message error">
                <div class="notification-error">
                    <div class="notification-inner"><i class="fa fa-times-circle"></i> <?php echo __('Please complete the required fields','metrodir'); ?></div>
                </div>
            </div>
            <div style="display: none;" class="message success">
                <div class="notification-success">
                    <div class="notification-inner"><i class="fa fa-exclamation-circle"></i> <?php echo __('Claim has been successfully sent','metrodir'); ?></div>
                </div>
            </div>
            <div class="comment-message singlemail">
                <div id="claim-company-submint">
                    <input id="claim-name" type="text" name="name" class="name" placeholder="<?php echo __('Name','metrodir'); ?> *" />
                    <input id="claim-email" type="text" name="email" class="email" placeholder="<?php echo __('E-mail','metrodir'); ?> *" />
                    <input id="claim-login" type="text" name="username" class="website" placeholder="<?php echo __('Username','metrodir'); ?> *" />
                    <textarea id="claim-comm" name="message" class="comment-message-main" placeholder="<?php echo __('Claim Comments','metrodir'); ?>"></textarea>
                    <div class="submit"><i class="fa fa-arrow-circle-right"></i><input type="submit" name="submit" value="Send Message" id="send-claim" /></div>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <?php //Get variables
        $id = get_the_ID();
        $item = new stdClass();
        $item->rating = get_post_meta( $id, 'rating', true );
    ?>
    <?php if((isset($UouPlugins->stars->status) AND $UouPlugins->stars->status == "enable") and ($item->rating)): ?>
        <!-- Company Rating --><div id="company-page-rating">

            <div class="title">
                <h2><?php echo __('Rating','metrodir'); ?></h2>
            </div>

            <?php if ($item->rating): ?>
                <div class="rating-stars-box">
                    <?php for ($i = 1; $i <= $item->rating['max']; $i++): ?>
                        <i class="fa <?php if (($item->rating['val'] + 1 - $i) >= 1) echo "fa-star"; else if (($item->rating['val'] + 1 - $i) >= 0.5) echo "fa-star-half-o"; else echo 'fa-star-o'; ?> fa-lg"></i>
                    <?php endfor; ?>
                    <div class="clear"></div>
                </div>
            <?php endif; ?>

        </div><!-- /Company Rating -->
    <?php endif; ?>

    <!-- Company Details --><div id="company-page-contact-details">

        <div class="title">
            <h2><?php echo __('Contact Details','metrodir'); ?></h2>
        </div>

        <table>

            <tr class="detail">
                <td class="detail-label"><?php echo __('Name','metrodir'); ?></td>
                <td class="detail"><?php the_title(); ?></td>
            </tr>

            <?php if (isset($custom[$shortname.'_company_doc_founded'][0]) and $custom[$shortname.'_company_doc_founded'][0]) $item_founded = $custom[$shortname.'_company_doc_founded'][0]; if(isset($item_founded)): ?>
                <?php $fldrestr_fe_founded_check = uou_rstrflds_check('founded','fe'); if ($fldrestr_fe_founded_check !== 'removefield'): ?>
                    <tr class="detail">
                        <td class="detail-label"><?php echo __('Founded','metrodir'); ?></td>
                        <td class="detail">
                            <?php if($fldrestr_fe_founded_check == false): ?>
                                <?php get_template_part('/include/html/frame','notice'); ?>
                            <?php else: ?>
                                <?php echo $item_founded; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($custom[$shortname.'_company_doc_legal'][0]) and $custom[$shortname.'_company_doc_legal'][0]) $item_legal = $custom[$shortname.'_company_doc_legal'][0]; if(isset($item_legal)): ?>
                <?php $fldrestr_fe_legal_check = uou_rstrflds_check('legal','fe'); if ($fldrestr_fe_legal_check !== 'removefield'): ?>
                    <tr class="detail">
                        <td class="detail-label"><?php echo __('Legal Entity','metrodir'); ?></td>
                        <td class="detail">
                            <?php if($fldrestr_fe_legal_check == false): ?>
                                <?php get_template_part('/include/html/frame','notice'); ?>
                            <?php else: ?>
                                <?php echo $item_legal; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($custom[$shortname.'_company_doc_turnover'][0]) and $custom[$shortname.'_company_doc_turnover'][0]) $item_turnover = $custom[$shortname.'_company_doc_turnover'][0]; if(isset($item_turnover)): ?>
                <?php $fldrestr_fe_turnover_check = uou_rstrflds_check('turnover','fe'); if ($fldrestr_fe_turnover_check !== 'removefield'): ?>
                    <tr class="detail">
                        <td class="detail-label"><?php echo __('Turnover','metrodir'); ?></td>
                        <td class="detail">
                            <?php if($fldrestr_fe_turnover_check == false): ?>
                                <?php get_template_part('/include/html/frame','notice'); ?>
                            <?php else: ?>
                                <?php echo $item_turnover; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($custom[$shortname.'_company_doc_empl'][0]) and $custom[$shortname.'_company_doc_empl'][0]) $item_empl = $custom[$shortname.'_company_doc_empl'][0]; if(isset($item_empl)): ?>
                <?php $fldrestr_fe_nempls_check = uou_rstrflds_check('nempls','fe'); if ($fldrestr_fe_nempls_check !== 'removefield'): ?>
                    <tr class="detail">
                        <td class="detail-label"><?php echo __('Number of Employees','metrodir'); ?></td>
                        <td class="detail">
                            <?php if($fldrestr_fe_nempls_check == false): ?>
                                <?php get_template_part('/include/html/frame','notice'); ?>
                            <?php else: ?>
                                <?php echo $item_empl; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>

            <?php //Get variables
                if (isset($custom[$shortname . '_address_country_name'][0]) and $custom[$shortname . '_address_country_name'][0]) $item_adrs_country = $custom[$shortname . '_address_country_name'][0];
                if (isset($custom[$shortname . '_address_region_name'][0]) and $custom[$shortname . '_address_region_name'][0]) $item_adrs_region = $custom[$shortname . '_address_region_name'][0];
                if (isset($custom[$shortname . '_address_name'][0]) and $custom[$shortname . '_address_name'][0]) $item_adrs = $custom[$shortname . '_address_name'][0];
            ?>
            <?php if(isset($item_adrs_country) OR isset($item_adrs_region) OR isset($item_adrs)): ?>
                <tr class="detail">
                    <td class="detail-label"><?php echo __('Full Address','metrodir'); ?></td>
                    <td class="detail"><?php if (isset($item_adrs_country)) {echo $item_adrs_country.', ';} if (isset($item_adrs_region)) {echo $item_adrs_region.', ';} if (isset($item_adrs)) {echo $item_adrs;} ?></td>
                </tr>
            <?php endif; ?>

            <?php if (isset($custom[$shortname.'_address_zip'][0]) and $custom[$shortname.'_address_zip'][0]) $item_adrs_zip = $custom[$shortname.'_address_zip'][0]; if(isset($item_adrs_zip)): ?>
                <tr class="detail">
                    <td class="detail-label"><?php echo __('ZIP code','metrodir'); ?></td>
                    <td class="detail"><?php echo $item_adrs_zip; ?></td>
                </tr>
            <?php endif; ?>

            <?php if (isset($custom[$shortname.'_company_doc_phone'][0]) and $custom[$shortname.'_company_doc_phone'][0]) $item_phone = $custom[$shortname.'_company_doc_phone'][0]; if(isset($item_phone)): ?>
                <?php $fldrestr_fe_phone_check = uou_rstrflds_check('phone','fe'); if ($fldrestr_fe_phone_check !== 'removefield'): ?>
                    <tr class="detail">
                        <td class="detail-label"><?php echo __('Phone','metrodir'); ?></td>
                        <td class="detail">
                            <?php if($fldrestr_fe_phone_check == false): ?>
                                <?php get_template_part('/include/html/frame','notice'); ?>
                            <?php else: ?>
                                <?php $strlen_ip = strlen ($item_phone);
                                    if($strlen_ip >= "20") {
                                        $newtext_ph = wordwrap($item_phone, 15, "\n", true);
                                        echo "$newtext_ph\n";
                                    } else {
                                        echo $item_phone;
                                    }
                                ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($custom[$shortname.'_company_soc_fax'][0]) and $custom[$shortname.'_company_soc_fax'][0]) $item_fax = $custom[$shortname.'_company_soc_fax'][0]; if(isset($item_fax)): ?>
                <?php $fldrestr_fe_fax_check = uou_rstrflds_check('fax','fe'); if ($fldrestr_fe_fax_check !== 'removefield'): ?>
                    <tr class="detail">
                        <td class="detail-label"><?php echo __('Fax','metrodir'); ?></td>
                        <td class="detail">
                            <?php if($fldrestr_fe_fax_check == false): ?>
                                <?php get_template_part('/include/html/frame','notice'); ?>
                            <?php else: ?>
                                <?php $strlen_ip = strlen ($item_fax);
                                if($strlen_ip >= "20") {
                                    $newtext_ph = wordwrap($item_fax, 15, "\n", true);
                                    echo "$newtext_ph\n";
                                } else {
                                    echo $item_fax;
                                }
                                ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($custom[$shortname.'_company_soc_web'][0]) and $custom[$shortname.'_company_soc_web'][0]) $item_website = $custom[$shortname.'_company_soc_web'][0]; if(isset($item_website)): ?>
                <?php $fldrestr_fe_website_check = uou_rstrflds_check('website','fe'); if ($fldrestr_fe_website_check !== 'removefield'): ?>
                    <tr class="detail">
                        <td class="detail-label"><?php echo __('Website','metrodir'); ?></td>
                        <td class="detail">
                            <?php if($fldrestr_fe_website_check == false): ?>
                                <?php get_template_part('/include/html/frame','notice'); ?>
                            <?php else: ?>
                                <a href="<?php echo $item_website; ?>">
                                    <?php $check_http_str  = substr($item_website,0,5);
                                        if ($check_http_str == "http:")
                                            $item_website = substr($item_website,7);

                                        $strlen_ws = strlen ( $item_website );

                                        if($strlen_ws >= "22") {
                                            echo __('Visit Site','metrodir');
                                        } else {
                                            echo $item_website;
                                        }
                                    ?>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($custom[$shortname.'_company_soc_email'][0]) and $custom[$shortname.'_company_soc_email'][0]) $item_email = $custom[$shortname.'_company_soc_email'][0]; if(isset($item_email)): ?>
                <?php $fldrestr_fe_email_check = uou_rstrflds_check('email','fe'); if ($fldrestr_fe_email_check !== 'removefield'): ?>
                    <tr class="detail">
                        <td class="detail-label"><?php echo __('E-mail','metrodir'); ?></td>
                        <td class="detail">
                            <?php if($fldrestr_fe_email_check == false): ?>
                                <?php get_template_part('/include/html/frame','notice'); ?>
                            <?php else: ?>
                                <a href="mailto:<?php echo $item_email; ?>">
                                    <?php $strlen_ml = strlen ( $item_email );
                                        if($strlen_ml >= "22") {
                                            echo __('Send E-mail','metrodir');
                                        } else {
                                            echo $item_email;
                                        }
                                    ?>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>

            <?php $cf_array = json_decode(htmlspecialchars_decode(get_post_meta(get_the_ID(), 'uou_custom_fields', true))); ?>

            <?php if(is_object($cf_array)): ?>
                <?php foreach($cf_array as $_field) : ?>
                    <tr class="detail">
                        <td class="detail-label"><?php echo __($_field->label,'metrodir'); ?></td>
                        <td class="detail">
                            <?php

                            $text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1:", $_field->value);

                            $ret = ' ' . $text;
                            $ret = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"\\2\" target=\"_blank\" rel=\"nofollow\">\\2</a>", $ret);
                            $ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"http://\\2\" target=\"_blank\" rel=\"nofollow\">\\2</a>", $ret);
                            $ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
                            $ret = substr($ret, 1);
                            echo $ret;

                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); ?>

            <?php if ( is_plugin_active('types/wpcf.php') ): ?>

                <?php // Get Fields
                    $meta_key_used= get_post_custom_keys($post->ID);
                    $i=0;
                    $fields = array();
                    foreach ($meta_key_used as $meta_key) {
                        $check = strtolower('wpcf-');
                        $check_key = $meta_key;
                        $result_check =  strpos($check_key, $check, 0);
                        if ($result_check !== false){
                            $field = substr($meta_key, 5);
                            $fields[$i] = $field;
                            $i++;
                        }
                    }
                    $fields_arr_num = count($fields); $num = 0;
                ?>

                <?php for ($index = 0; $index < count($fields); $index++): ?>
                    <tr class="detail">
                        <td class="detail-label">
                            <?php $name = types_render_field($fields[$index], array("output"=>"normal", "show_name"=>true)); ?>
                            <?php $namearr = explode(':', $name); echo $namearr[0]; ?>
                        </td>
                        <td class="detail"><?php echo types_render_field($fields[$index], array("output"=>"html")) ?></td>
                    </tr>
                <?php endfor; ?>

            <?php endif; ?>

        </table>

    </div><!-- /Company Details -->

    <?php //Get variables
        if (isset($custom[$shortname.'_company_soc_openhrs1'][0]) and $custom[$shortname.'_company_soc_openhrs1'][0]) $item_dayint1 = $custom[$shortname.'_company_soc_openhrs1'][0];
        if (isset($custom[$shortname.'_company_soc_openhrs2'][0]) and $custom[$shortname.'_company_soc_openhrs2'][0]) $item_dayint2 = $custom[$shortname.'_company_soc_openhrs2'][0];
        if (isset($custom[$shortname.'_company_soc_openhrs3'][0]) and $custom[$shortname.'_company_soc_openhrs3'][0]) $item_dayint3 = $custom[$shortname.'_company_soc_openhrs3'][0];
        if (isset($custom[$shortname.'_company_soc_openhrs4'][0]) and $custom[$shortname.'_company_soc_openhrs4'][0]) $item_dayint4 = $custom[$shortname.'_company_soc_openhrs4'][0];
    ?>
    <?php if (isset($item_dayint1) OR isset($item_dayint2) OR isset($item_dayint3) OR isset($item_dayint4)): ?>
        <!-- Company Opening Hours --><div id="company-page-opening-hours">

            <div class="title">
                <h2><?php echo __('Opening Hours','metrodir'); ?></h2>
            </div>

            <table>

                <?php if (isset($item_dayint1)): ?>
                    <?php $dayint1arr = explode(',', $item_dayint1); ?>
                    <tr class="detail">
                        <td class="detail-label"><?php echo $dayint1arr[0]; ?></td>
                        <td class="detail"><?php echo $dayint1arr[1]; ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($item_dayint2)): ?>
                    <?php $dayint2arr = explode(',', $item_dayint2); ?>
                    <tr class="detail">
                        <td class="detail-label"><?php echo $dayint2arr[0]; ?></td>
                        <td class="detail"><?php echo $dayint2arr[1]; ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($item_dayint3)): ?>
                    <?php $dayint3arr = explode(',', $item_dayint3); ?>
                    <tr class="detail">
                        <td class="detail-label"><?php echo $dayint3arr[0]; ?></td>
                        <td class="detail"><?php echo $dayint3arr[1]; ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($item_dayint4)): ?>
                    <?php $dayint4arr = explode(',', $item_dayint4); ?>
                    <tr class="detail">
                        <td class="detail-label"><?php echo $dayint4arr[0]; ?></td>
                        <td class="detail"><?php echo $dayint4arr[1]; ?></td>
                    </tr>
                <?php endif; ?>

            </table>

        </div><!-- /Company Opening Hours -->

    <?php endif; ?>

    <?php if (isset($custom[$shortname.'_company_contact_tabs_act'][0]) and $custom[$shortname.'_company_contact_tabs_act'][0]) $tab_contact_act = $custom[$shortname.'_company_contact_tabs_act'][0]; if (isset($tab_contact_act) AND $tab_contact_act == "Hide"): ?>
        <?php if (isset($custom[$shortname.'_company_contact_tabs_act'][0])) $item_email_form = $custom[$shortname.'_company_soc_email_form'][0]; if (isset($item_email_form) AND $item_email_form == "Display"): ?>
            <?php if(isset($item_email)): ?>
                <!-- Company Contact Form --><div class="company-page-contact-sidebar">

                    <div class="title">
                        <h2><?php echo __('Message Us','metrodir'); ?></h2>
                    </div>

                    <div id="company-page-comment-message">
                        <form method="post" id="contact-single-message-form">
                            <input type="text" name="name" class="text-input-grey name" placeholder="<?php echo __('Name','metrodir').' / '.__('Company Name','metrodir').' *'; ?>" />
                            <input type="text" name="email" class="text-input-grey email" placeholder="<?php echo __('Your E-mail','metrodir').' *'; ?>" />
                            <input type="text" name="website" class="text-input-grey website" placeholder="<?php echo __('Subject','metrodir'); ?>" />
                            <textarea name="message" class="text-input-grey comment-message-main" placeholder="<?php echo __('How can we help You?','metrodir'); ?>"></textarea>
                            <input type="text" name="mailto" value="<?php if(isset($item_email)) echo $item_email; ?>" style="display:none" readonly/>
                            <div class="submit"><i class="fa fa-arrow-circle-right"></i><input type="submit" name="submit" value="<?php echo __('Send Message','metrodir'); ?>" id="button-2-green" /></div>
                        </form>
                    </div>

                </div><!-- /Company Contact Form -->
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php $opt_metrodir_sidebanner = get_option('opt_metrodir_site_sidebanner'); if(isset($opt_metrodir_sidebanner)): ?>
        <!-- SideBar Banner --><div id="one-image-banner">
            <a class="opacity" href="<?php echo get_option('opt_metrodir_site_sidebanner_url'); ?>" style="background-image: url(<?php echo $opt_metrodir_sidebanner; ?>);"></a>
        </div><!-- /SideBar Banner -->
    <?php endif; ?>

</div><!-- /Sidebar -->

<!-- Content Center --><div id="content-center">

    <?php if (isset($custom[$shortname . '_company_image1_url'][0]) and $custom[$shortname . '_company_image1_url'][0]) $item_img1 = $custom[$shortname . '_company_image1_url'][0]; if(isset($item_img1)): ?>
        <!-- Company Photo --><div id="company-page-photo">
            <a class="colorbox" href="<?php echo $item_img1; ?>" title="<?php the_title(); ?>" ><div class="opacity" style="background-image: url(<?php echo $item_img1; ?>);"></div></a>
        </div><!-- /Company Photo -->
    <?php endif; ?>

    <!-- Company Info --><div id="company-page-info">

        <div class="company-page-thumabnail-social">

            <?php if( has_post_thumbnail()): ?>
                <div class="company-page-thumabnail">
                    <?php the_post_thumbnail(array(120,120)); ?>
                </div>
            <?php endif; ?>

            <?php   $social = 0;    if(isset($custom[$shortname . '_company_soc_fb'][0]) and $custom[$shortname . '_company_soc_fb'][0]) $social++;
                                    if(isset($custom[$shortname . '_company_soc_gp'][0]) and $custom[$shortname . '_company_soc_gp'][0]) $social++;
                                    if(isset($custom[$shortname . '_company_soc_tw'][0]) and $custom[$shortname . '_company_soc_tw'][0]) $social++;
                                    if(isset($custom[$shortname . '_company_soc_li'][0]) and $custom[$shortname . '_company_soc_li'][0]) $social++;
                                    if(isset($custom[$shortname . '_company_soc_pt'][0]) and $custom[$shortname . '_company_soc_pt'][0]) $social++;
                                    if(isset($custom[$shortname . '_company_soc_dr'][0]) and $custom[$shortname . '_company_soc_dr'][0]) $social++;
                    if ($social != 0): ?>
            <div class="company-page-social">
                <!-- Social Links --><ul class="social-links">
                    <?php if(isset($custom[$shortname . '_company_soc_fb'][0]) and $custom[$shortname . '_company_soc_fb'][0]) $item_soc_fb = $custom[$shortname . '_company_soc_fb'][0]; if(isset($item_soc_fb)): ?>
                        <li class="facebook"><a href="<?php echo $item_soc_fb; ?>" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    <?php endif; ?>
                    <?php if(isset($custom[$shortname . '_company_soc_gp'][0]) and $custom[$shortname . '_company_soc_gp'][0]) $item_soc_gp = $custom[$shortname . '_company_soc_gp'][0]; if(isset($item_soc_gp)): ?>
                        <li class="google"><a href="<?php echo $item_soc_gp; ?>" title="Google +" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                    <?php endif; ?>
                    <?php if(isset($custom[$shortname . '_company_soc_tw'][0]) and $custom[$shortname . '_company_soc_tw'][0]) $item_soc_tw = $custom[$shortname . '_company_soc_tw'][0]; if(isset($item_soc_tw)): ?>
                        <li class="twitter"><a href="<?php echo $item_soc_tw; ?>" title="Twitter" target="_blank"><i class="fa fa-twitter fa-lg"></i></a></li>
                    <?php endif; ?>
                    <?php if(isset($custom[$shortname . '_company_soc_li'][0]) and $custom[$shortname . '_company_soc_li'][0]) $item_soc_li = $custom[$shortname . '_company_soc_li'][0]; if(isset($item_soc_li)): ?>
                        <li class="linkedin"><a href="<?php echo $item_soc_li; ?>" title="Linkedin" target="_blank"><i class="fa fa-linkedin-square fa-lg"></i></a></li>
                    <?php endif; ?>
                    <?php if(isset($custom[$shortname . '_company_soc_pt'][0]) and $custom[$shortname . '_company_soc_pt'][0]) $item_soc_pt = $custom[$shortname . '_company_soc_pt'][0]; if(isset($item_soc_pt)): ?>
                        <li class="pinterest"><a href="<?php echo $item_soc_pt; ?>" title="Pinterest" target="_blank"><i class="fa fa-pinterest fa-lg"></i></a></li>
                    <?php endif; ?>
                    <?php if(isset($custom[$shortname . '_company_soc_dr'][0]) and $custom[$shortname . '_company_soc_dr'][0]) $item_soc_dr = $custom[$shortname . '_company_soc_dr'][0]; if(isset($item_soc_dr)): ?>
                        <li class="dribbble"><a href="<?php echo $item_soc_dr; ?>" title="Dribbble" target="_blank"><i class="fa fa-dribbble fa-lg"></i></a></li>
                    <?php endif; ?>
                </ul><!-- /Social Links -->
                <div class="clear"></div>
            </div>
            <?php endif; ?>

        </div>

        <div class="company-page-info-description">

            <div class="company-page-title">
                <?php the_title(); ?>
            </div>

            <?php if (isset($terms) and $terms): ?>
                <?php $i=0; foreach ($terms as $term ): ?>
                    <?php $i++; if ($i == 1) { $item_cats = '<a href="'.get_term_link(intval($term->term_id), 'company_category').'" title="'.$term->name.'">'.$term->name.'</a>'; } else { $item_cats .= '<span>, </span><a href="'.get_term_link(intval($term->term_id), 'company_category').'" title="'.$term->name.'">'.$term->name.'</a>'; } ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if ($item_cats): ?>
                <div class="company-page-categories">
                    <?php echo $item_cats; ?>
                </div>
            <?php endif; ?>

            <?php if(isset($custom[$shortname . '_wlctext_name'][0]) and $custom[$shortname . '_wlctext_name'][0]) $item_wlctext = $custom[$shortname . '_wlctext_name'][0]; if (isset($item_wlctext)):  ?>
                <div class="company-page-representation">
                    <?php echo $item_wlctext; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($custom[$shortname . '_company_doc_desc'][0]) and $custom[$shortname . '_company_doc_desc'][0]) $item_desc = $custom[$shortname . '_company_doc_desc'][0]; if (isset($item_desc)): ?>
                <div class="company-page-description">
                    <?php echo $item_desc; ?>
                </div>
            <?php endif; ?>

        </div>

    </div><!-- /Company Info -->

    <!-- Company Content --><div class="company-page-content">

        <div class="title">
            <h2><?php echo __('Profile Description','metrodir'); ?></h2>
        </div>

        <div class="company-page-body body">
            <?php the_content(); ?>
        </div>

    </div><!-- /Company Content -->

    <?php if (isset($custom[$shortname . '_company_tags'][0]) and $custom[$shortname . '_company_tags'][0]) $item_tags = $custom[$shortname . '_company_tags'][0]; if(isset($item_tags)): ?>
        <!-- Company Tags--><div class="company-page-tags">

            <div class="title">
                <h2><?php echo __('Range of Services','metrodir'); ?></h2>
            </div>

            <div class="company-page-range-of-services-content">
                <ul>
                    <?php $tags = explode(',', $item_tags); foreach($tags as $tag): ?>
                        <li><?php echo $tag; ?></li>
                    <?php endforeach; ?>
                </ul>
                <div class="clear"></div>
            </div>

        </div><!-- /Company Tags -->
    <?php endif; ?>

    <!-- Company Rating --><?php if(isset($UouPlugins->stars->status) AND $UouPlugins->stars->status == "enable") getSklStars( $post->ID ); //Company rating ?><!-- /Company Rating -->

    <?php if ( comments_open() ): ?>
        <!-- Company Comments --><div id="comments" class="comment-message<?php if ($UouPlugins->stars->status == "enable") echo ' with-rating'; ?>">
            <?php comments_template( '' ); //Call Comments Template ?>
        </div><!-- /Company Comments -->
    <?php endif; ?>

</div><!-- /Content Center -->

<div class="clear"></div>
