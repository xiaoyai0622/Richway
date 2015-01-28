<?php
$themename = "Metrodir";
$shortname = "metro";
$languages_domain = 'metrodir';
$version = "1.4.2";
$rtl = false;

/****************************************
* 	  RTL SUPPORT FOR PHP INDICATOR     *
****************************************/
if (get_option('opt_metrodir_site_rtl') == "true") {
    $rtl = true;
}

/******************************
* 	  DEFINE DIRECTORIES      *
******************************/
define('DS', DIRECTORY_SEPARATOR);
define('metrodir_LIB', get_template_directory().'/lib');
define('metrodir_JS', get_template_directory_uri().'/scripts');
define('metrodir_CLASS', get_template_directory().'/lib'.DS.'class');
define('metrodir_TMP', get_template_directory().'/tmp');
define('metrodir_SKL', get_template_directory().'/skl');
define('metrodir_SKL_FRAMEWORK', metrodir_SKL.'/framework');
define('metrodir_URI_TMP', get_template_directory_uri().'/tmp');
define('metrodir_LANGUAGES', get_template_directory().'/languages');
define('metrodir_PANEL', metrodir_LIB .DS.'panel');
define('metrodir_IMAGES', get_template_directory().'/images');
define('metrodir_BACKGROUNDS', metrodir_IMAGES.DS.'backgrounds');
define('metrodir_INCLUDE', get_template_directory().'/include');
define('metrodir_CSSDIR', get_template_directory_uri().'/css');
define('metrodir_ADMIN', get_template_directory_uri().'/admin');
define('metrodir_ADMINJS', get_template_directory_uri().'/admin/js');
define('metrodir_ADMINCSS', get_template_directory_uri().'/admin/css');
define('metrodir_SKL_plugin', metrodir_SKL.'/plugin');

/******************************
* 	LOAD LANGUAGES            *
******************************/
load_theme_textdomain($languages_domain, metrodir_LANGUAGES);


/******************************
* 	DEFINE URLs               *
******************************/
define('metrodir_PANEL_CSS', get_template_directory_uri(). '/lib/panel/css');
define('metrodir_PANEL_JS', get_template_directory_uri() . '/lib/panel/js');
define('metrodir_PANEL_IMAGES', get_template_directory_uri() . '/lib/panel/images');

require_once( get_template_directory(). '/chk-version.php' );
require_once(metrodir_SKL_FRAMEWORK . '/functions.php');

/******************************
 *      Fill variables        *
 ******************************/
$optionsPlugin = get_option("uou_opt_plugins");
if ($optionsPlugin != false)
    $UouPlugins = json_decode( json_encode($optionsPlugin) );
else
    $UouPlugins = json_decode( json_encode( uouLoadDefOptions() ) );


/******************************
* 	LOAD PANEL                *
******************************/
require_once(metrodir_CLASS . '/settings.php');
require_once(metrodir_CLASS . '/meta_box.php');
require_once(metrodir_PANEL . '/header.php');
require_once(metrodir_PANEL . '/index.php');
require_once(metrodir_PANEL . '/team.php');
require_once(metrodir_PANEL . '/company.php');
require_once(metrodir_PANEL . '/menus.php');
require_once(metrodir_PANEL . '/stars.php');
require_once(metrodir_PANEL . '/claim.php');

/******************************
 * 	LOAD ADMIN FRAMEWORK      *
 ******************************/
require_once(TEMPLATEPATH . '/admin/admin-functions.php');
require_once(TEMPLATEPATH . '/admin/admin-interface.php');
require_once(TEMPLATEPATH . '/admin/theme-settings.php');
require_once(TEMPLATEPATH . '/admin/ajax-functions.php');
include_once(ABSPATH . 'wp-admin/includes/plugin.php');


/******************************
 * 	LOAD SPECIFIC FUNCTIONS   *
 ******************************/
require_once dirname(__FILE__) . '/skl/functions/start.php';
require_once dirname(__FILE__) . '/skl/load.php';


/******************************
 *      Default Styles        *
 ******************************/
$def_cat_style = array(
    'default'       => array('icon' => 'fa-map-marker',     'color' => '#267aac',   'marker' => '/images/markers/default.png'),
    'advertising'   => array('icon' => 'fa-star',           'color' => '#00bcf2',   'marker' => '/images/markers/advertising.png'),
    'airport'       => array('icon' => 'fa-plane',          'color' => '#ea3e23',   'marker' => '/images/markers/airport.png'),
    'cars'          => array('icon' => 'fa-tachometer',     'color' => '#68217a',   'marker' => '/images/markers/cars.png'),
    'education'     => array('icon' => 'fa-users',          'color' => '#0f7b0f',   'marker' => '/images/markers/education.png'),
    'entertainment' => array('icon' => 'fa-magic',          'color' => '#1570a6',   'marker' => '/images/markers/entertainment.png'),
    'garden'        => array('icon' => 'fa-leaf',           'color' => '#39a65b',   'marker' => '/images/markers/garden.png'),
    'industry'      => array('icon' => 'fa-cogs',           'color' => '#f25022',   'marker' => '/images/markers/industry.png'),
    'libraries'     => array('icon' => 'fa-book',           'color' => '#7fba00',   'marker' => '/images/markers/libraries.png'),
    'mechanic'      => array('icon' => 'fa-wrench',         'color' => '#2338a1',   'marker' => '/images/markers/mechanic.png'),
    'offices'       => array('icon' => 'fa-briefcase',      'color' => '#ea3e23',   'marker' => '/images/markers/offices.png'),
    'postal'        => array('icon' => 'fa-envelope',       'color' => '#68217a',   'marker' => '/images/markers/postal.png'),
    'realestate'    => array('icon' => 'fa-home',           'color' => '#750000',   'marker' => '/images/markers/realestate.png'),
    'restaurant'    => array('icon' => 'fa-coffee',         'color' => '#1570a6',   'marker' => '/images/markers/restaurant.png'),
    'shop'          => array('icon' => 'fa-shopping-cart',  'color' => '#ffb802',   'marker' => '/images/markers/shop.png'),
    'sport'         => array('icon' => 'fa-flag-checkered', 'color' => '#f25022',   'marker' => '/images/markers/sport.png'),
);

/******************************
* 	  THEME FUNCTIONS         *
******************************/
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'woocommerce' );

add_filter('login_redirect', '_uou_lgn_redirect'); function _uou_lgn_redirect() { return home_url(); }

if ( !stristr( get_option( 'permalink_structure' ), '%postname%' ) ) {
    add_action( 'admin_notices', 'uouapps_permalink_nag', 3 );
}

function uouapps_permalink_nag() {

    if ( current_user_can( 'manage_options' ) )
        $msg = sprintf( __( 'You need to set your <a href="%1$s">permalink structure</a> to at least contain <b>/&#37;postname&#37;/</b> before WP MetroDir will work properly.', 'metrodir' ), 'options-permalink.php' );

    echo "<div class='error fade'><p>$msg</p></div>";
}

    if ( ! function_exists( 'metrodir_posted_on' ) ) :
        /**
         * Prints HTML With Meta Information For The Post date/time/author.
         *
         * @since metrodir 1.0
         */
        function metrodir_posted_on() {
            printf( __( '%2$s', 'metrodir' ),
                'meta-prep meta-prep-author',
                sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
                    get_permalink(),
                    esc_attr( get_the_time() ),
                    get_the_date()
                ),
                sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
                    get_author_posts_url( get_the_author_meta( 'ID' ) ),
                    esc_attr( sprintf( __( 'View all posts by %s', 'metrodir' ), get_the_author() ) ),
                    get_the_author()
                )
            );
        }

        // Author post
        function metrodir_posted_author() {
            printf( __( '%3$s', 'metrodir' ),
                'meta-prep meta-prep-author',
                sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
                    get_permalink(),
                    esc_attr( get_the_time() ),
                    get_the_date()
                ),
                sprintf( '<span class="vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
                    get_author_posts_url( get_the_author_meta( 'ID' ) ),
                    esc_attr( sprintf( __( 'View all posts by %s', 'metrodir' ), get_the_author() ) ),
                    get_the_author()
                )
            );
        }
    endif;

    /**
     *
     * Comment style.
     *
     */
    if ( ! function_exists( 'metrodir_comment' ) ) :

        /**
         * Template For Comments.
         *
         * Used as a callback by wp_list_comments() for displaying the comments.
         *
         * @since metrodir 1.0
         */
        function metrodir_comment( $comment, $args, $depth ) {
            $GLOBALS['comment'] = $comment;
            switch ( $comment->comment_type ) :
                case '' : ?>
                    <li class="comment">
                        <div class="comment" id="comment-<?php comment_ID(); ?>">
                            <div class="comment-user-picture">
                                <?php echo get_avatar( $comment, 80 ); ?>
                            </div>
                            <div class="comment-body">
                                <div class="comment-links">
                                    <?php edit_comment_link( __( 'Edit', 'metrodir' ), ' ' ); ?>
                                    <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                                </div>
                                <div class="comment-author">
                                    <span><?php printf( __( '%s', 'metrodir' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?></span>
                                    <span>-</span>
                                    <span><?php printf( __( '%1$s at %2$s', 'metrodir' ), get_comment_date(),  get_comment_time() ); ?></a></span>
                                </div>
                                <div class="comment-text">
                                    <?php comment_text(); ?>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </li>
                    <?php
                    break;
                        case 'pingback'  :
                        case 'trackback' :
                    ?>
                    <div><?php _e( 'Pingback:', 'metrodir' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'metrodir' ), ' ' ); ?></div>
                    <?php
                    break;
            endswitch;
        }
    endif;


// Get queried user id
function dp_get_queried_user_id() {
    $user = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));

    return $user->ID;
}

    /**
     *
     * Widget init.
     *
     */
    function metrodir_widgets_init() {
        // Area
        register_sidebar( array(
            'name' => __( 'Primary Widget Area', 'metrodir' ),
            'id' => 'primary-widget-area',
            'description' => __( 'The primary widget area', 'metrodir' ),
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '<div class="block-title"><h3>',
            'after_title' => '</h3></div>',
        ) );


        register_sidebar( array(
            'name' => __( 'Footer Widget Area', 'metrodir' ),
            'id' => 'footer-widget-area',
            'description' => __( 'The footer widget area', 'metrodir' ),
            'before_widget' => '<div class="footer-widget block">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="title"><h3>',
            'after_title' => '</h3></div><div class="block-content">',
        ) );

        register_sidebar( array(
            'name' => __( 'Sidebar Widget Area', 'metrodir' ),
            'id' => 'sidebar-widget-area',
            'description' => __( 'The footer widget area', 'metrodir' ),
            'before_widget' => '<div>',
            'after_widget' => '</div>',
            'before_title' => '<div class="block-title"><h3>',
            'after_title' => '</h3></div>',
        ) );
    }

    /**
     *
     * JS scripts
     *
     * @param $shortname
     */
    function metrodir_enqueue_scripts($shortname)
    {
        if (is_admin()) {
            add_action('admin_head', 'metrodir_wpadmin_head');

            if (!empty($_GET['page']))
                if ('metrodir_cp' == $_GET['page']) {
                    add_action('admin_head', 'metrodir_panel_head');

                    wp_enqueue_script('jquery.ui.1.8.17.js', metrodir_PANEL_JS . '/jquery.ui.1.8.17.js', array('jquery'), false, true);
                    wp_enqueue_script('jquery.elastic.source.js', metrodir_PANEL_JS . '/jquery.elastic.source.js', array('jquery'), false, true);
                    wp_enqueue_script('jquery.filter.input.js', metrodir_PANEL_JS . '/jquery.filter.input.js', array('jquery'), false, true);
                    wp_enqueue_script('jquery.placeholder.min.js', metrodir_PANEL_JS . '/jquery.placeholder.min.js', array('jquery'), false, true);
                    wp_enqueue_script('jquery.ui.select.js', metrodir_PANEL_JS . '/jquery.ui.select.js', array('jquery'), false, true);
                    wp_enqueue_script('jquery.ui.spinner.js', metrodir_PANEL_JS . '/jquery.ui.spinner.js', array('jquery'), false, true);
                    wp_enqueue_script('jquery.metadata.js', metrodir_PANEL_JS . '/jquery.metadata.js', array('jquery'), false, true);
                    wp_enqueue_script('jquery.validate.min.js', metrodir_PANEL_JS . '/jquery.validate.min.js', array('jquery'), false, true);
                    wp_enqueue_script('jquery.customInput.js', metrodir_PANEL_JS . '/jquery.customInput.js', array('jquery'), false, true);
                    wp_enqueue_script('jquery.filestyle.mini.js', metrodir_PANEL_JS . '/jquery.filestyle.mini.js', array('jquery'), false, true);
                    wp_enqueue_script('jquery.tmpl.min.js', metrodir_PANEL_JS . '/jquery.tmpl.min.js', array('jquery'), false, true);
                    wp_enqueue_script('jquery.tipsy.js', metrodir_PANEL_JS . '/jquery.tipsy.js', array('jquery'), false, true);
                    wp_enqueue_script('jquery.colorpicker.js', metrodir_PANEL_JS . '/jquery.colorpicker.js', array('jquery'), false, true);
                    wp_enqueue_script('jquery.mobilemenu.min.js', metrodir_PANEL_JS . '/jquery.mobilemenu.min.js', array('jquery'), false, true);
                    wp_enqueue_script('ajaxupload.js', metrodir_PANEL_JS . '/ajaxupload.js', array('jquery'), false, true);
                    wp_enqueue_script('metrodir_panel_script', metrodir_PANEL_JS . '/custom.js', array('jquery'), false, true);

                    //Admin JAVASCRIPT localization
                    function localize_vars()
                    {
                        global $shortname;
                        return array(
                            'ARE_YOU_SURE' => __('Are you sure ?', 'metrodir' ),
                            'ONLY_IMAGES_ALLOWED' => __('Error: only images are allowed', 'metrodir' ),
                            'ONLY_ICO_ALLOWED' => __('Error: only .ico are allowed', 'metrodir' ),
                            'ONLY_ZIP_ALLOWED' => __('Error: only .zip are allowed', 'metrodir' ),
                            'RELOAD_PAGE' => __('Refresh the page ?', 'metrodir' ),
                            'UPLOADING' => __('Uploading ...', 'metrodir' ),
                            'ADD_NEW_BACKGROUND' => __('Add new background', 'metrodir' ),
                            'CHANGE' => __('Change', 'metrodir' ),
                            'EXPAND' => __('Expand', 'metrodir' ),
                            'COLLAPSE' => __('Collapse', 'metrodir' ),
                            'EDIT' => __('Edit', 'metrodir' )
                        );
                    } //End localize_vars
                    wp_localize_script('metrodir_panel_script', 'metrodir_LANG', localize_vars());

                    wp_enqueue_script('jquery');
                }
                if (isset($_GET['post_type']) OR isset($_GET['action'])){
                            if (((isset($_GET['post_type']) AND 'company' == $_GET['post_type']) OR (isset($_GET['action']) AND 'edit' == $_GET['action']))){
                                wp_enqueue_script('maps.google', 'http://maps.google.com/maps/api/js?sensor=false', array('jquery'), false, true);
                                wp_enqueue_script('gps_converter', metrodir_PANEL_JS . '/gps_converter.js', array('jquery'), false, true);
                                wp_enqueue_script('skl', metrodir_PANEL_JS . '/skl.js', array('jquery'), false, true);
                                wp_localize_script( 'skl', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'ajaxnonce' => wp_create_nonce('ajax-nonce') ) );
                            }
                }
        } else {
            wp_enqueue_script('maps.google', 'https://maps.google.com/maps/api/js?sensor=false', array('jquery'), false, true);
            wp_enqueue_script('jquery-ui-1.10.4.custom.min.js', get_template_directory_uri() . '/scripts/jquery-ui-1.10.4.custom.min.js', array('jquery'), false, true);
            wp_enqueue_script('jquery.colorbox-min.js', get_template_directory_uri() . '/scripts/jquery.colorbox-min.js', array('jquery'), false, true);
            wp_enqueue_script('jquery.flexslider-min.js', get_template_directory_uri() . '/scripts/jquery.flexslider-min.js', array('jquery'), false, true);
            wp_enqueue_script('jquery.selectbox-0.6.1.js', get_template_directory_uri() . '/scripts/jquery.selectbox-0.6.1.js', array('jquery'), false, true);
            wp_enqueue_script('jquery.tweet.js', get_template_directory_uri() . '/scripts/jquery.tweet.js', array('jquery'), false, true);
            wp_enqueue_script('jquery.mobilemenu.min.js', get_template_directory_uri() . '/scripts/jquery.mobilemenu.min.js', array('jquery'), false, true);
            wp_enqueue_script('jquery.placeholder.min.js', get_template_directory_uri() . '/scripts/jquery.placeholder.min.js', array('jquery'), false, true);
            wp_enqueue_script('jquery.ui.autocomplete.min.js', get_template_directory_uri() . '/scripts/jquery.ui.autocomplete.min.js', array('jquery'), false, true);
            wp_enqueue_script('jquery.sheepItPlugin', get_template_directory_uri() . '/scripts/jquery.sheepItPlugin.js', array('jquery'), false, true);
            wp_enqueue_script('jquery.gomap-1.3.2.min.js', get_template_directory_uri() . '/scripts/jquery.gomap-1.3.2.min.js', array('jquery'), false, true);
            wp_enqueue_script('jquery.gmap.min.js', get_template_directory_uri() . '/scripts/jquery.gmap.min.js', array('jquery'), false, true);
            wp_enqueue_script('map.js', get_template_directory_uri() . '/scripts/map.js#asyncload', array('jquery'), false, true);
            wp_enqueue_script('markerclusterer.js', get_template_directory_uri() . '/scripts/markerclusterer.js#asyncload', array('jquery'), false, true);
            wp_enqueue_script('ajax_search.js', get_template_directory_uri() . '/scripts/ajax_search.js#asyncload', array('jquery'), false, true);
            wp_enqueue_script('jflickrfeed.min.js', get_template_directory_uri() . '/scripts/jflickrfeed.min.js', array('jquery'), false, true);
            wp_enqueue_script('superfish.js', get_template_directory_uri() . '/scripts/superfish.js', array('jquery'), false, true);
            wp_enqueue_script('rating.js', get_template_directory_uri() . '/scripts/rating.js', array('jquery'), false, true);
            wp_enqueue_script('scripts.js', get_template_directory_uri() . '/scripts/scripts.js', array('jquery'), false, true);
            if ( is_singular() ) wp_enqueue_script( "comment-reply" );
            //JAVASCRIPT Variables
            function localize_vars()
            {
                global $shortname, $settings;
                if (isset($settings['metrodircompany']['adress'])) {
                    return array(
                        'MAP_ADRESS' => $settings['metrodircompany']['adress'],
                        'ICONURL' => 'index.php',
                        'AJAXURL' => 'index.php' //admin_url('admin-ajax.php')

                    );
                }

            }

            wp_localize_script('metrodir_script', 'metrodir_SETTINGS', localize_vars());

            wp_enqueue_script('jquery');
            wp_localize_script( 'scripts.js', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'ajaxnonce' => wp_create_nonce('ajax-nonce') ) );
        }
    }

    if ( ! isset( $content_width ) ) $content_width = 900;

    add_action('wp_enqueue_scripts', 'metrodir_enqueue_scripts');
    add_action('admin_enqueue_scripts', 'metrodir_enqueue_scripts');


    // stylesheet include
    function metrodir_stylesheet() {
        wp_enqueue_style( 'colorbox', get_template_directory_uri() . '/css/colorbox.css' );
        wp_enqueue_style( 'jquery-selectbox', get_template_directory_uri() . '/css/jquery-selectbox.css' );
        wp_enqueue_style( 'style', get_stylesheet_uri() );
        wp_enqueue_style( 'responsive', get_template_directory_uri() . '/css/responsive.css' );
        wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css' );
        wp_enqueue_style( 'images', get_template_directory_uri() . '/css/images.css' );
        wp_enqueue_style( 'theme-color', get_template_directory_uri() . '/css/color.css' );
    }
    add_action('wp_enqueue_scripts', 'metrodir_stylesheet');

    function upload_scripts() {
        wp_enqueue_script('media-upload');
    }

    function upload_styles() {
        wp_enqueue_style('thickbox');
    }

    add_action('admin_print_scripts', 'upload_scripts');
    add_action('admin_print_styles', 'upload_styles');

    /** Register sidebars */
    add_action( 'widgets_init', 'metrodir_widgets_init' );


    /**
     * This theme uses wp_nav_menu() in one location.
     **/

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'metrodir' ),
    ) );


    /**
     *
     * Return var
     *
     */
    function return_settings()
    {
        global $settings;

        return $settings;
    }
    function return_single_company()
    {
        global $center_single_company;

        return $center_single_company;
    }
    function return_item_adrs_sng_lat()
    {
        global $item_adrs_sng_lat;
        return $item_adrs_sng_lat;
    }
    function return_item_adrs_sng_lng()
    {
        global $item_adrs_sng_lng;
        return $item_adrs_sng_lng;
    }
    function return_item_first_cat()
    {
        global $item_first_cat;
        return $item_first_cat;
    }
   function return_search_s()
    {
        global $metrodir_search_s;
        return $metrodir_search_s;
    }
    function return_search_location()
    {
        global $metrodir_search_location;
        return $metrodir_search_location;
    }
    function return_search_category()
    {
        global $metrodir_search_category;
        return $metrodir_search_category;
    }


    /**
     *
     * Pagination company.
     *
     */

    function metrodir_pagenavi($pages = '', $range = 2)
    {
        $showitems = ($range * 2)+1;

        global $paged;

        if(empty($paged)) $paged = 1;

        if($pages == '')
        {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if(!$pages)
            {
                $pages = 1;
            }
        }

        if(1 != $pages)
        {
            echo "<div class='pager'><ul class='pager-buttons'>";
            if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link(1)."'>&laquo;</a></li>";
            if($paged > 1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a></li>";
            for ($i=1; $i <= $pages; $i++)
            {
                if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
                {
                    echo ($paged == $i)? "<li><a href='#' class='current-page'>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>";
                }
            }
            if ($paged < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a></li>";
            if ($paged < $pages-1 && $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."'>&raquo;</a></li>";
            echo "</ul></div>";
        }
    }

    function metrodir_pagenavi_search($pages = '', $range = 2)
    {
        $showitems = ($range * 2)+1;

        $paged = $_GET['pageds'];

        if(empty($paged)) $paged = 1;

        if($pages == '')
        {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if(!$pages)
            {
                $pages = 1;
            }
        }

        if(1 != $pages)
        {
            echo "<div class='pager'><ul class='pager-buttons'>";
            if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".add_query_arg( 'pageds', 1)."'>&laquo;</a></li>";
            if($paged > 1 && $showitems < $pages) echo "<li><a href='".add_query_arg( 'pageds', $paged - 1)."'>&lsaquo;</a></li>";
            for ($i=1; $i <= $pages; $i++)
            {
                if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
                {
                    echo ($paged == $i)? "<li><a href='#' class='current-page'>".$i."</a></li>":"<li><a href='".add_query_arg( 'pageds', $i)."' class='inactive' >".$i."</a></li>";
                }
            }
            if ($paged < $pages && $showitems < $pages) echo "<li><a href='".add_query_arg( 'pageds', $paged + 1)."'>&rsaquo;</a></li>";
            if ($paged < $pages-1 && $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".add_query_arg( 'pageds', $pages)."'>&raquo;</a></li>";
            echo "</ul></div>";
        }
    }

    /**
     *
     * MultiPostThumbnails plugin add.
     *
     */
    if (class_exists('MultiPostThumbnails')) {

        new MultiPostThumbnails(array(
            'label' => '1 Image',
            'id' => '1-image',
            'post_type' => 'company'
        ) );

        new MultiPostThumbnails(array(
            'label' => '2 Image',
            'id' => '2-image',
            'post_type' => 'company'
        ) );

        new MultiPostThumbnails(array(
            'label' => '3 Image',
            'id' => '3-image',
            'post_type' => 'company'
        ) );

        new MultiPostThumbnails(array(
            'label' => '4 Image',
            'id' => '4-image',
            'post_type' => 'company'
        ) );

        new MultiPostThumbnails(array(
            'label' => '5 Image',
            'id' => '5-image',
            'post_type' => 'company'
        ) );
        new MultiPostThumbnails(array(
            'label' => '6 Image',
            'id' => '6-image',
            'post_type' => 'company'
        ) );
        new MultiPostThumbnails(array(
            'label' => '6 Image',
            'id' => '6-image',
            'post_type' => 'company'
        ) );
        new MultiPostThumbnails(array(
            'label' => '7 Image',
            'id' => '7-image',
            'post_type' => 'company'
        ) );
        new MultiPostThumbnails(array(
            'label' => '8 Image',
            'id' => '8-image',
            'post_type' => 'company'
        ) );
    }


    /**
     *
     * Custom login/admin style.
     *
     */


function add_theme_caps() {
    $capability_type = 'company';
    $capabilitiesAdmin = array(
        "edit_{$capability_type}" => true,
        "read_{$capability_type}" => true,
        "delete_{$capability_type}" => true,
        "edit_{$capability_type}s" => true,
        "edit_others_{$capability_type}s" => true,
        "publish_{$capability_type}s" => true,
        "read_private_{$capability_type}s" => true,
        "delete_{$capability_type}s" => true,
        "delete_private_{$capability_type}s" => true,
        "delete_published_{$capability_type}s" => true,
        "delete_others_{$capability_type}s" => true,
        "edit_private_{$capability_type}s" => true,
        "edit_published_{$capability_type}s" => true,
        "assign_company_category" => true
    );

    // set admin capability
    $adminRole = get_role( 'administrator' );
    foreach ($capabilitiesAdmin as $key => $value) {
        $adminRole->add_cap( $key );
    }
}
add_action( 'admin_init', 'add_theme_caps');

    function metrodir_login_styles()
    {
           echo '<style type="text/css">
           body.login { background: #f4f4f4; margin: 50px 0px; padding-bottom: 50px; }

           h1 a { background: url("'.get_template_directory_uri().'/images/logo-globe.png") no-repeat top center !important; width: 100px !important; height: 100px !important; }

          </style>
           <meta name="robots" content="noindex,nofollow" />';
    }

    add_action('login_head', 'metrodir_login_styles');

    require_once metrodir_SKL_FRAMEWORK.'/admin/class-tgm-plugin-activation.php';

    add_action( 'tgmpa_register', 'metrodir_register_required_plugins' );


    /**
     * Register the required plugins for this theme.
     *
     * In this example, we register two plugins - one included with the TGMPA library
     * and one from the .org repo.
     *
     * The variable passed to tgmpa_register_plugins() should be an array of plugin
     * arrays.
     *
     * This function is hooked into tgmpa_init, which is fired within the
     * TGM_Plugin_Activation class constructor.
     */
    function metrodir_register_required_plugins() {

        /**
         * Array of plugin arrays. Required keys are name and slug.
         * If the source is NOT from the .org repo, then source is also required.
         */
        $plugins = array(

            // This is an example of how to include a plugin pre-packaged with a theme
            array(
                'name'     				=> 'Revolution slider', // The plugin name
                'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
                'source'   				=> get_stylesheet_directory() . '/plugins/revslider.zip', // The plugin source
                'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
                'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
            ),
			array(
                'name'                  => 'WPBakery Visual Composer', // The plugin name
                'slug'                  => 'js_composer', // The plugin slug (typically the folder name)
                'source'                => get_stylesheet_directory() . '/plugins/js_composer.zip', // The plugin source
                'required'              => false, // If false, the plugin is only 'recommended' instead of required
                'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'          => '', // If set, overrides default API URL and points to an external URL
            ),
            array(
                'name'     => 'Types - Complete Solution for Custom Fields and Types',
                'slug'     => 'types',
                'required' => false, // only recommended
            ),
            array(
                'name'     => 'Kebo - Twitter Feed',
                'slug'     => 'kebo-twitter-feed',
                'required' => false, // only recommended
            ),
            array(
                'name'     => 'Events Manager',
                'slug'     => 'events-manager',
                'required' => true,
            )
        );

        // Change this to your theme text domain, used for internationalising strings
        $theme_text_domain = 'metrodir';

        /**
         * Array of configuration settings. Amend each line as needed.
         * If you want the default strings to be available under your own theme domain,
         * leave the strings uncommented.
         * Some of the strings are added into a sprintf, so see the comments at the
         * end of each line for what each argument will be.
         */
        $config = array(
            'domain'       		=> $theme_text_domain,         	// Text domain - likely want to be the same as your theme.
            'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
            'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
            'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
            'menu'         		=> 'install-required-plugins', 	// Menu slug
            'has_notices'      	=> true,                       	// Show admin notices or not
            'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
            'message' 			=> '',							// Message to output right before the plugins table
            'strings'      		=> array(
                'page_title'                       			=> __( 'Install Required Plugins', $theme_text_domain ),
                'menu_title'                       			=> __( 'Install Plugins', $theme_text_domain ),
                'installing'                       			=> __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
                'oops'                             			=> __( 'Something went wrong with the plugin API.', $theme_text_domain ),
                'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
                'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
                'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
                'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
                'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
                'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
                'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
                'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
                'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
                'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
                'return'                           			=> __( 'Return to Required Plugins Installer', $theme_text_domain ),
                'plugin_activated'                 			=> __( 'Plugin activated successfully.', $theme_text_domain ),
                'complete' 									=> __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
                'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
            )
        );

        tgmpa( $plugins, $config );

    }

// WPML support
function languages_list(){
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

    if ( is_plugin_active('sitepress-multilingual-cms/sitepress.php') ){

        $wpml_type = get_option('opt_metrodir_wpml_type');
        $opt_metrodir_rtl =  get_option('opt_metrodir_rtl');

        if(!$wpml_type){
            $wpml_type = "Language code";
        }

        $languages = icl_get_languages('skip_missing=0');
        $index = 0;
        foreach($languages as $l){
            $index++;
        }

        if ($index > 1) {

            if($wpml_type == "Language Name"){
                $languages = icl_get_languages('skip_missing=0');
                if(!empty($languages)){
                    foreach($languages as $l){
                        if ($l['active']) echo '<div class="language-label name"><i class="fa fa-globe"></i>Language:<span>'.icl_disp_language($l['translated_name'], $l['']).'</span></div>';
                    }
                    echo '<ul class="languages name">';
                    foreach($languages as $l){
                        if (!$l['active']) echo '<li><a href="'.$l['url'].'">';
                        if ($l['active']) echo '<li><a href="'.$l['url'].'" class="current">';
                        echo icl_disp_language($l['translated_name'], $l['']);
                        if ($l['active']) echo '</a></li>';
                        if (!$l['active']) echo '</a></li>';
                    }
                    echo '</ul>';
                }

            }

            if($wpml_type == "Language Code"){
                $languages = icl_get_languages('skip_missing=0');
                if(!empty($languages)){
                    foreach($languages as $l){
                        if ($l['active']) echo '<div class="language-label code"><i class="fa fa-globe"></i>Language:<span>'.icl_disp_language($l['language_code'], $l['']).'</span></div>';
                    }
                    echo '<ul class="languages code">';
                    foreach($languages as $l){
                        if (!$l['active']) echo '<li><a href="'.$l['url'].'">';
                        if ($l['active']) echo '<li><a href="'.$l['url'].'" class="current">';
                        echo icl_disp_language($l['language_code'], $l['']);
                        if ($l['active']) echo '</a></li>';
                        if (!$l['active']) echo '</a></li>';
                    }
                    echo '</ul>';
                }
            }

            if($wpml_type == "Flag"){
                $languages = icl_get_languages('skip_missing=0');
                if(!empty($languages)){
                    foreach($languages as $l){
                        if ($l['active']) echo '<div class="language-label flag"><i class="fa fa-globe"></i>Language:<span><img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" /></span></div>';
                    }
                    echo '<ul class="languages flag">';
                    foreach($languages as $l){
                        if($l['country_flag_url']){
                            if (!$l['active']) echo '<li><a href="'.$l['url'].'">';
                            if ($l['active']) echo '<li><a href="'.$l['url'].'" class="current">';
                            echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
                            if ($l['active']) echo '</a></li>';
                            if (!$l['active']) echo '</a></li>';
                        }
                    }
                    echo '</ul>';
                }
            }

            if($wpml_type == "Flag and Code"){
                $languages = icl_get_languages('skip_missing=0');
                if(!empty($languages)){
                    foreach($languages as $l){
                        if ($l['active']) echo '<div class="language-label flag-code"><i class="fa fa-globe"></i>Language:<span><img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />'.icl_disp_language($l['language_code'], $l['']).'</span></div>';
                    }
                    echo '<ul class="languages flag-code">';
                    foreach($languages as $l){
                        if($l['country_flag_url']){
                            if (!$l['active']) echo '<li><a href="'.$l['url'].'">';
                            if ($l['active']) echo '<li><a href="'.$l['url'].'" class="current">';
                            echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />'.icl_disp_language($l['language_code'], $l['']);
                            if ($l['active']) echo '</a></li>';
                            if (!$l['active']) echo '</a></li>';
                        }
                    }
                    echo '</ul>';
                }
            }

            if($wpml_type == "Flag and Name"){
                $languages = icl_get_languages('skip_missing=0');
                if(!empty($languages)){
                    foreach($languages as $l){
                        if ($l['active']) echo '<div class="language-label flag-name"><i class="fa fa-globe"></i>Language:<span><img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />'.icl_disp_language($l['translated_name'], $l['']).'</span></div>';
                    }
                    echo '<ul class="languages flag-name">';
                    foreach($languages as $l){
                        if($l['country_flag_url']){
                            if (!$l['active']) echo '<li><a href="'.$l['url'].'">';
                            if ($l['active']) echo '<li><a href="'.$l['url'].'" class="current">';
                            echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />'.icl_disp_language($l['translated_name'], $l['']);
                            if ($l['active']) echo '</a></li>';
                            if (!$l['active']) echo '</a></li>';
                        }
                    }
                    echo '</ul>';
                }
            }
        }
    }
}

function add_fields_search(){

    $tt_fields = array("Founded", "Turnover", "Number of Employees", "Range of Services tags", "Legal Entity");

    return $tt_fields;
}

function add_type_fields_search(){
global $wpdb;
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

    if ( is_plugin_active('types/wpcf.php') ){

        $types_fields = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."postmeta WHERE meta_key = '_wp_types_group_fields'");
        $fields_str = trim($types_fields->meta_value, ",") ;
        $fields_expl = explode(',', $fields_str);
        $i = 0;
        foreach($fields_expl as $tag){

            $fields[$i] =  $tag;
            $i++;
        }

        $tt_fields_type = $fields;

        return $tt_fields_type;
    }

}

function revolutionslider_array(){
global $wpdb;

    $aliases = array();

    $aliasDb = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."revslider_sliders" );
    foreach ($aliasDb as $alias) {
        array_push($aliases, $alias->alias);
    }

    $tt_slider = $aliases;
    return $tt_slider;
}

require_once('lib/class/vt_resizer.php');

function vt_resizer($img = NULL, $width = NULL, $height = NULL) {

    if($img != NULL) {

        $image = vt_resize(null, $img, $width, $height, true );

        if(is_array($image)) { return $image['url']; } else { return $image; }

    }
    else
    { return ''; }

}

// Filter for events manager

if ( is_plugin_active('events-manager/events-manager.php') ){
    add_filter('em_event_output_placeholder','my_em_styles_placeholders',1,3);
    function my_em_styles_placeholders($replace, $EM_Event, $result){
        global $wp_query, $wp_rewrite;
        switch( $result ){
            case '#_uouDateyear':
                $get_event_date = $EM_Event->event_start_date;
                $date =  array_map('trim', explode("-", $get_event_date));
                $replace = $date[0];

                break;
            case '#_uouDatemonth':
                $get_event_date = $EM_Event->event_start_date;
                $date =  array_map('trim', explode("-", $get_event_date));
                $replace = $date[1];

                break;
            case '#_uouDateday':
                $get_event_date = $EM_Event->event_start_date;
                $date =  array_map('trim', explode("-", $get_event_date));
                $replace = $date[2];

                break;
            case '#_uouCompany':
                $replace = get_the_title();

                break;
            case '#_uouReadMore':
                $replace = __('Read More','metrodir');
                break;
            case '#_uouImage':
                $id= $EM_Event->post_id;
                $image = get_post_thumbnail_id($id);
                $imgatt = wp_get_attachment_image_src($image, 'full');
                $imglink = vt_resizer($imgatt[0], 620, 330);
                if($imglink){
                    $replace = '<div class="blog-list-image"><img src="'.$imglink.'" alt="'.$EM_Event->event_name.'" title="'.$EM_Event->event_name.'" /></div>';
                } else {
                    $replace = '';
                }


                break;
        }
        return $replace;
    }
}

function uou_generate_list($categories, $company_category, $in = 0) {
    $subcat_chars = '-&nbsp;';
    $output = '';
    //Print option
    foreach ($categories as $cat) {
        $output .= '<option ';
        if ($cat->slug == $company_category) $output .= 'selected ';
        $output .= 'value="' . $cat->slug . '"';
        $indentation = '';
        for ($i=0; $i < $in; $i++) {
            $indentation .= $subcat_chars;
        }
        $output .= '>'. $indentation . $cat->name . '</option>';
        if (!empty($cat->children)) {
            $output .= uou_generate_list($cat->children, $company_category, $in + 1);
        }
    }
    return $output;
}

function uou_get_all_terms(Array &$cats, Array &$into, $parentId = 0) {
    // Generate array parrent items
    foreach ($cats as $i => $cat) {
        if ($cat->parent == $parentId) {
            $into[$cat->term_id] = $cat;
            unset($cats[$i]);
        }
    }
    // Add subcat to array for parent
    foreach ($into as $topCat) {
        $topCat->children = array();
        uou_get_all_terms($cats, $topCat->children, $topCat->term_id);
    }
}

function uou_shw_auth_posts($query)
{
    if (isMetrodirUser()) {

        if (strpos($_SERVER['PHP_SELF'],'edit.php') !== false && isset($_GET['post_type']) && ($_GET['post_type'] == 'post') OR
            strpos($_SERVER['PHP_SELF'],'edit.php') !== false && !isset($_GET['post_type']))
        {
            $query->set('author',$GLOBALS['current_user']->ID);
        }

        if(strpos($_SERVER['PHP_SELF'],'edit.php') !== false && isset($_GET['post_type']) && ($_GET['post_type'] == 'event') )
        {
            $query->set('author',$GLOBALS['current_user']->ID);
        }

        if(strpos($_SERVER['PHP_SELF'],'edit.php') !== false && isset($_GET['post_type']) && ($_GET['post_type'] == 'product') )
        {
            $query->set('author',$GLOBALS['current_user']->ID);
        }
    }


    return $query;
}

add_filter('pre_get_posts', 'uou_shw_auth_posts');
add_filter('views_edit-post', 'uou_only_show_mine_post');
add_filter('views_edit-event', 'uou_only_show_mine_post');
function uou_only_show_mine_post( $views )
{
    $current_user = wp_get_current_user();
    if ($current_user->roles != 'administrator')
    {
        unset($views['all']);
        unset($views['publish']);
    }
    return $views;
}