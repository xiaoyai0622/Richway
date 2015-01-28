<?php
/**
 *
 * The template for displaying Company Profile pages.
 *
 **/
$format_single = '

#_uouImage

<div class="blog-list-title-comments">
    <div class="blog-list-title"><a>#_EVENTNAME</a></div>
</div>

<div class="blog-list-description">#_EVENTNOTES</div>

<div class="blog-list-links">
    <div class="blog-list-meta"><span><i class="fa fa-calendar"></i>#_EVENTDATES</span><span>|</span><span><i class="fa fa-clock-o"></i>#_EVENTTIMES</span><span>|</span><span><i class="fa fa-map-marker"></i>{has_location} #_LOCATIONLINK {/has_location}</span></div>
    <div class="blog-list-more-link">
        <a href="#_EVENTURL" title="#_EVENTNAME"><i class="fa fa-arrow-circle-right"></i>#_uouReadMore</a>
    </div>
</div>
';

if(isset($_GET['get']) AND $_GET['get'] == "event"){
    $post_event_id  = $_POST['idevent'];

    $arg =   array(
        'post_id'=> $post_event_id,
        'format_header' => '<div class="blog-list-preview">',
        'format' => $format_single,
        'format_footer' => '</div>',

    );
    echo EM_Events::output($arg);

    exit;
}

get_header();
the_post();
//Get Post Preload Content
global $post;
$args = array(
    'post_type'       => 'company'
);
$company_items = get_posts($args);

$terms = get_the_terms( $post->ID, 'company_category' );
$item_cats = array();
$item_cats_slugs = array();

if(is_array($terms)) {
    foreach ($terms as $term ) {
        $item_cats[] = $term->name;
        $item_cats_slugs[] = $term->slug;
    }
}
$item_cats_str = join("/", $item_cats);
$item_cats_class = join("/", $item_cats_slugs);

$custom = get_post_custom($post->ID);

//Sidebar Position
$opt_metrodir_companypage_version = get_option('opt_metrodir_companypage_version');
//Search option
$opt_metrodir_search_def = get_option('opt_metrodir_search_def');
?>

<?php if ($custom[$shortname.'_shw_strv'][0] == 'Map'): ?>

    <?php
        $center_single_company = 'ye';
        if ((isset($custom[$shortname.'_address_country_name'][0]) AND $custom[$shortname.'_address_country_name'][0]) OR ((isset($custom[$shortname.'_address_region_name'][0])) AND $custom[$shortname.'_address_region_name'][0]) OR ((isset($custom[$shortname.'_address_name'][0])) AND $custom[$shortname.'_address_name'][0]))
            $item_adrs_sng = $custom[$shortname.'_address_country_name'][0].' '.$custom[$shortname.'_address_region_name'][0].' '.$custom[$shortname.'_address_name'][0];
        if (isset($custom[$shortname . '_address_lat'][0]) AND $custom[$shortname . '_address_lat'][0])
            $item_adrs_sng_lat = $custom[$shortname . '_address_lat'][0];
        if (isset($custom[$shortname . '_address_lng'][0]) AND $custom[$shortname . '_address_lng'][0])
            $item_adrs_sng_lng = $custom[$shortname . '_address_lng'][0];
        if (isset($custom[$shortname.'_address_name'][0]) AND $custom[$shortname.'_address_name'][0])
            $center_single_company_addr = $custom[$shortname.'_address_name'][0];
        if (isset($item_cats_slugs[0]) AND $item_cats_slugs[0])
            $item_first_cat = $item_cats_slugs[0];
    ?>

    <?php if ($opt_metrodir_search_def == "true"): ?>
        <?php get_template_part('/include/html/frame','search'); ?>
    <?php endif; ?>

    <?php get_template_part('/include/php/companymarkers'); ?>

    <?php get_template_part('/include/html/str-home-map'); ?>

<?php elseif ($custom[$shortname.'_shw_strv'][0] == 'Streetview'): ?>

    <?php
        $item_adrs_sng_lat = $custom[$shortname . '_address_lat'][0];
        $item_adrs_sng_lng = $custom[$shortname . '_address_lng'][0];
    ?>
    <!-- Street View --><div id="street-view">
        <iframe width="100%" height="500" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/?ie=UTF8&amp;ll=<?php echo $item_adrs_sng_lat; ?>,<?php echo $item_adrs_sng_lng; ?>&amp;spn=<?php echo $item_adrs_sng_lat; ?>,<?php echo $item_adrs_sng_lng; ?>&amp;t=m&amp;z=4&amp;layer=c&amp;cbll=<?php echo $item_adrs_sng_lat; ?>,<?php echo $item_adrs_sng_lng; ?>&amp;cbp=12,354.15,,0,0&amp;source=embed&amp;output=svembed"></iframe>
    </div><!-- /Street View -->


<?php elseif ($custom[$shortname.'_shw_strv'][0] == 'Personal place'): ?>

    <?php
        $item_adrs_sng_lat = $custom[$shortname . '_address_lat'][0];
        $item_adrs_sng_lng = $custom[$shortname . '_address_lng'][0];
    ?>

    <?php get_template_part('/include/html/str-home-personal-place'); ?>

<?php elseif ($custom[$shortname.'_shw_strv'][0] == 'Blank'): ?>

    <?php get_template_part('/include/html/frame','breadcrumbs'); ?>

<?php endif; ?>

<?php
//Get Tabs Options
$tab_portfolio_act =  $custom[$shortname . '_company_portfolio_tabs_act'][0];
$tab_contact_act =  $custom[$shortname . '_company_contact_tabs_act'][0];
$tab_events_act =  $custom[$shortname . '_events_tabs_act'][0];
$tab_blog_act =  $custom[$shortname . '_blog_tabs_act'][0];
$tab_products_act =  $custom[$shortname . '_products_tabs_act'][0];
$tab_custom_act =  $custom[$shortname . '_custom_tabs_act'][0];

if( // Tabs "Be or not to be that is the question"...
       $tab_portfolio_act == "Display"
    OR $tab_contact_act == "Display"
    OR $tab_events_act == "Display"
    OR $tab_blog_act  == "Display"
    OR $tab_products_act == "Display"
    OR $tab_custom_act  == "Display"

) $tabs = true; else $tabs = false;
?>

<!-- Content --><div id="content" class="company">

<?php if($tabs): ?>

    <!-- Company Tab Navigation --><div class="box-container"><ul id="company-tabs-active" class="company-tabs">
        <li class="active">
            <a class="company-tabs-page" href="#"><?php echo __('Company','metrodir'); ?></a>
        </li>

        <?php if($tab_portfolio_act == "Display"): ?>
            <li>
                <a class="company-tabs-portfolio" href="#"><?php echo __('Portfolio','metrodir'); ?></a>
            </li>
        <?php endif; ?>

        <?php if($tab_events_act == "Display"): ?>
            <li>
                <a class="company-tabs-events" href="#"><?php echo __('Events','metrodir'); ?></a>
            </li>
        <?php endif; ?>

        <?php if($tab_blog_act == "Display"): ?>
            <li>
                <a class="company-tabs-blog" href="#"><?php echo __('Blog','metrodir'); ?></a>
            </li>
        <?php endif; ?>

        <?php if($tab_contact_act == "Display"): ?>
            <li>
                <a class="company-tabs-contact" href="#"><?php echo __('Contact','metrodir'); ?></a>
            </li>
        <?php endif; ?>

        <?php if($tab_products_act == "Display"): ?>
            <li>
                <a class="company-tabs-product" href="#"><?php echo __('Product & Services','metrodir'); ?></a>
            </li>
        <?php endif; ?>

        <?php if($tab_custom_act == "Display"): ?>
            <li>
                <a class="company-tabs-custom" href="#"><?php $tab_custom_title =  $custom[$shortname . '_custom_tabs_title'][0]; if ($tab_custom_title) echo $tab_custom_title; else echo __('Custom','metrodir'); ?></a>
            </li>
        <?php endif; ?>

    </ul></div><!-- /Company Tab Navigation -->


    <!-- Content Inner --><div id="content-inner" class="company-tabs sidebar-<?php echo $opt_metrodir_companypage_version; ?>"><div class="box-container">

        <div id="company-tabs-page" class="company-tabs-content active">
            <?php require_once (metrodir_INCLUDE.'/html/company-tabs/company.php'); ?>
        </div>

        <?php if($tab_portfolio_act == "Display"): ?>
            <div id="company-tabs-portfolio" class="company-tabs-content">
                <?php require_once (metrodir_INCLUDE.'/html/company-tabs/portfolio.php'); ?>
            </div>
        <?php endif; ?>

        <?php if($tab_events_act == "Display"): ?>
            <div id="company-tabs-events" class="company-tabs-content">
                <?php if ( is_plugin_active('events-manager/events-manager.php') ): ?>
                    <?php require_once (metrodir_INCLUDE.'/html/company-tabs/events.php'); ?>
                <?php else: ?>
                    <!-- Message --><div id="message" class="error"><div class="box-container">
                        <?php echo '<i class="fa fa-times-circle"></i> '.__("Events Manager Plugin is deactivate", "metrodir").'. <a href="http://wordpress.org/plugins/events-manager/">'.__("Install and Activate", "metrodir").'</a>'; ?>
                    </div></div><!-- /Message -->
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if($tab_blog_act == "Display"): ?>
            <div id="company-tabs-blog" class="company-tabs-content">
                <?php require_once (metrodir_INCLUDE.'/html/company-tabs/blog.php'); ?>
            </div>
        <?php endif; ?>

        <?php if($tab_contact_act == "Display"): ?>
            <div id="company-tabs-contact" class="company-tabs-content">
                <?php require_once (metrodir_INCLUDE.'/html/company-tabs/contact.php'); ?>
            </div>
        <?php endif; ?>

        <?php if($tab_products_act == "Display"): ?>
            <div id="company-tabs-product" class="company-tabs-content">
                <?php require_once (metrodir_INCLUDE.'/html/company-tabs/product.php'); ?>
            </div>
        <?php endif; ?>

        <?php if($tab_custom_act == "Display"): ?>
            <div id="company-tabs-custom" class="company-tabs-content">
                <?php require_once (metrodir_INCLUDE.'/html/company-tabs/custom.php'); ?>
            </div>
        <?php endif; ?>

    </div></div><!-- /Content Inner -->

<?php else: ?>

    <!-- Content Inner --><div id="content-inner" class="company-single sidebar-<?php echo $opt_metrodir_companypage_version; ?>"><div class="box-container">
        <?php require_once (metrodir_INCLUDE.'/html/company-tabs/company.php'); ?>
    </div></div><!-- /Content Inner -->

<?php endif; ?>

</div><!-- /Content -->

<?php get_template_part ('footer');