<?php
/*
Template Name: About us
*/
get_header();
the_post();
// Get variables metrodir_Options
//Site options
$opt_metrodir_boxed_version = get_option('opt_metrodir_boxed_version');
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

//Show Post
global $post;
$args = array(
    'orderby' 		=> 'name',
    'order' 		=> 'DESC',
    'numberposts'     => 0,
    'post_type'       => 'content',
    'suppress_filters' => 0
);
$portfolio_items = get_posts($args);

?>

<!-- Content --><div id="content" class="about-us">

    <?php get_template_part('/include/html/frame','breadcrumbs')?>

    <div class="box-container"><div id="about-us-block">

            <?php foreach($portfolio_items as $post ):
                setup_postdata($post);

                //Select Custom Fields
                $custom = get_post_custom($post->ID);

                //Social width
                $index = 0;
                if(isset($custom[$shortname.'_content_soc_fb'][0])) { $index++; };
                if(isset($custom[$shortname.'_content_soc_gp'][0])) { $index++; };
                if(isset($custom[$shortname.'_content_soc_tw'][0])) { $index++; };
                if(isset($custom[$shortname.'_content_soc_li'][0])) { $index++; };
                if(isset($custom[$shortname.'_content_soc_pt'][0])) { $index++; };
                if(isset($custom[$shortname.'_content_soc_dr'][0])) { $index++; };
            ?>


                <div class="person">
                    <div class="person-photo opacity">
                        <?php echo get_the_post_thumbnail($post->ID,array(300,300)); ?>
                    </div>
                    <div class="person-description">
                        <div class="name"><?php echo $custom[$shortname . '_content_name'][0]; ?></div>
                        <div class="position"><?php echo $custom[$shortname . '_content_position'][0]; ?></div>
                    </div>
                    <div class="person-social social-<?php echo $index; ?>">
                        <ul class="social-links">
                            <?php if(isset($custom[$shortname.'_content_soc_fb'][0])): ?>
                                <li class="facebook"><a href="<?php echo $custom[$shortname.'_content_soc_fb'][0]; ?>" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <?php endif; ?>
                            <?php if(isset($custom[$shortname.'_content_soc_gp'][0])): ?>
                                <li class="google"><a href="<?php echo $custom[$shortname.'_content_soc_gp'][0]; ?>" title="Google +" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                            <?php endif; ?>
                            <?php if(isset($custom[$shortname.'_content_soc_tw'][0])): ?>
                                <li class="twitter"><a href="<?php echo $custom[$shortname.'_content_soc_tw'][0]; ?>" title="Twitter" target="_blank"><i class="fa fa-twitter fa-lg"></i></a></li>
                            <?php endif; ?>
                            <?php if(isset($custom[$shortname.'_content_soc_li'][0])): ?>
                                <li class="linkedin"><a href="<?php echo $custom[$shortname.'_content_soc_li'][0]; ?>" title="Linkedin" target="_blank"><i class="fa fa-linkedin-square fa-lg"></i></a></li>
                            <?php endif; ?>
                            <?php if(isset($custom[$shortname.'_content_soc_pt'][0])): ?>
                                <li class="pinterest"><a href="<?php echo $custom[$shortname.'_content_soc_pt'][0]; ?>" title="Pinterest" target="_blank"><i class="fa fa-pinterest fa-lg"></i></a></li>
                            <?php endif; ?>
                            <?php if(isset($custom[$shortname.'_content_soc_dr'][0])): ?>
                                <li class="dribbble"><a href="<?php echo $custom[$shortname.'_content_soc_dr'][0]; ?>" title="Dribbble" target="_blank"><i class="fa fa-dribbble fa-lg"></i></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

            <?php endforeach; ?>
        <div class="clear"></div>
    </div></div>

</div><!-- /Content -->

<?php get_template_part ('footer');