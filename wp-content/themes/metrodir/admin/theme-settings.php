<?php

add_action('init','propanel_of_options');

if (!function_exists('propanel_of_options')) {
function propanel_of_options(){

//Theme Shortname
$shortname = "opt_metrodir";


//Populate the options array
global $tt_options;
$tt_options = get_option('of_options');

//Access the WordPress Pages via an Array
$tt_pages = array();
$tt_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($tt_pages_obj as $tt_page) {
$tt_pages[$tt_page->ID] = $tt_page->post_name; }
$tt_pages_tmp = array_unshift($tt_pages, "Select a page:");

//Access the WordPress Categories via an Array
$tt_categories = array();  
$tt_categories_obj = get_categories(array(
    'type'                     => 'company',
    'taxonomy'                 => 'company_category'
));
foreach ($tt_categories_obj as $tt_cat) {
$tt_categories[$tt_cat->cat_ID] = $tt_cat->cat_name;}
$categories_tmp = array_unshift($tt_categories, "Select a category:");

$tt_fields = add_fields_search();
$tt_fields_type = add_type_fields_search();

if ( is_plugin_active('revslider/revslider.php') ) $tt_slider = revolutionslider_array();

//Sample Array for demo purposes
$sample_array = array("1","2","3","4","5");

//Sample Advanced Array - The actual value differs from what the user sees
$sample_advanced_array = array("image" => "The Image","post" => "The Post"); 

//Folder Paths for "type" => "images"
$sampleurl =  get_template_directory_uri().'/admin/images/sample-layouts/';
$templateurl =  get_template_directory_uri().'/images/';
$baseurl = get_template_directory_uri();


/*-----------------------------------------------------------------------------------*/
/* Create The Custom Site Options Panel
/*-----------------------------------------------------------------------------------*/
$options = array(); // do not delete this line - sky will fall

/* Option Page 1 - Basic Options */
$options[] = array( "name" => __('General Settings','metrodircp_localize'),
            "type" => "heading");

    $options[] = array("type" => "cross_line", "title" => __('General Options','metrodircp_localize'));

    $options[] = array( "name" => __('Demo Version','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_site_demo",
        "std" => "false",
        "type" => "checkbox");

    $options[] = array( "name" => __('Logo Upload','metrodircp_localize'),
        "desc" => __('Upload logo for your website (190x50 recommend).','metrodircp_localize'),
        "id" => $shortname."_site_logo",
        "std" => $templateurl."logo.png",
        "type" => "upload");

    $options[] = array( "name" => __('Favicon Site','metrodircp_localize'),
        "desc" => __('Upload a 16px x 16px image that will represent your website\'s favicon.','metrodircp_localize'),
        "id" => $shortname."_favicon",
        "std" => $baseurl."/favicon.ico",
        "type" => "upload");

    $options[] = array( "name" => __('Header Version','metrodircp_localize'),
        "id" => $shortname."_header_version",
        "std" => "1",
        "type" => "images",
        "options" => array(
            '1' => $sampleurl.'menu-1.jpg',
            '2' => $sampleurl.'menu-2.jpg'));

    $options[] = array( "name" => __('Full-Width or Boxed Version','metrodircp_localize'),
        "id" => $shortname."_boxed_version",
        "std" => "no",
        "type" => "images",
        "options" => array(
            'no' => $sampleurl.'no-boxed.jpg',
            'yes' => $sampleurl.'yes-boxed.jpg'));

    $options[] = array( "name" => __('Scroll Top Button','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_site_scroll_top",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Use Popup for User CP pages?','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_user_cp_popup",
        "std" => "true",
        "type" => "checkbox");
/*
    $options[] = array( "name" => __('Right to Left Support','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_site_rtl",
        "std" => "false",
        "type" => "checkbox");
*/
    $options[] = array( "name" => __('Custom CSS','metrodircp_localize'),
        "desc" => "We do not Recommend Using it, Use Child Theme Better.",
        "id" => $shortname."_custom_css",
        "std" => "",
        "type" => "textarea");

    $options[] = array( "name" => __('Custom JS','metrodircp_localize'),
        "desc" => "We do not Recommend Using it, Use Child Theme Better.",
        "id" => $shortname."_custom_js",
        "std" => "",
        "type" => "textarea");

    $options[] = array("type" => "cross_line", "title" => __('Theme Background Options','metrodircp_localize'));

    $options[] = array( "name" => __('Site Background for Boxed Version Upload','metrodircp_localize'),
        "desc" => __('Upload site background (1920x1080 recommend).','metrodircp_localize'),
        "id" => $shortname."_site_background",
        "std" => $templateurl."content/background.jpg",
        "type" => "upload");

    $options[] = array( "name" => __('Background Color','framework_localize'),
        "id" => $shortname."_color_bg",
        "std" => "#FFFFFF",
        "type" => "color");

    $options[] = array( "name" => __('Background Position','metrodircp_localize'),
        "desc" => __('Vertical','metrodircp_localize'),
        "id" => $shortname."_site_background_vertical",
        "std" => "top",
        "type" => "select",
        "options" => array("top","center","bottom"));

    $options[] = array( "name" => __('','metrodircp_localize'),
        "desc" => __('Horizontal','metrodircp_localize'),
        "id" => $shortname."_site_background_horizontal",
        "std" => "center",
        "type" => "select",
        "options" => array("center","left","right"));

    $options[] = array( "name" => __('Background Repeat','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_site_background_repeat",
        "std" => "repeat",
        "type" => "select",
        "options" => array("repeat","no-repeat","repeat-y"));

    $options[] = array( "name" => __('Fixed Background','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_site_background_fixed",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Enable Background For No-Boxed Version','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_site_no_boxed_bg",
        "std" => "false",
        "type" => "checkbox");

    $options[] = array("type" => "cross_line", "title" => __('Theme Colors Accents','metrodircp_localize'));

    $options[] = array( "name" => __('First Theme Color','metrodircp_localize'),
        "id" => $shortname."_color_first",
        "std" => "#7fba00",
        "type" => "color");

    $options[] = array( "name" => __('Second Theme Color','metrodircp_localize'),
        "id" => $shortname."_color_second",
        "std" => "#1570a6",
        "type" => "color");

    $options[] = array( "name" => __('Font Color Major / Some Hover Color','metrodircp_localize'),
        "id" => $shortname."_color_font",
        "std" => "#40555c",
        "type" => "color");

    $options[] = array( "name" => __('Font Color Minor','metrodircp_localize'),
        "id" => $shortname."_color_font_minor",
        "std" => "#9faaad",
        "type" => "color");

    $options[] = array( "name" => __('Some Back Color','metrodircp_localize'),
        "id" => $shortname."_color_font_back",
        "std" => "#f5f5f5",
        "type" => "color");

    $options[] = array( "name" => __('Border Color','metrodircp_localize'),
        "id" => $shortname."_color_border",
        "std" => "#dedede",
        "type" => "color");

    $options[] = array( "name" => __('Border Color Light','metrodircp_localize'),
        "id" => $shortname."_color_border_light",
        "std" => "#eaeaea",
        "type" => "color");

    $options[] = array("type" => "cross_line", "title" => __('View Options','metrodircp_localize'));

    $options[] = array( "name" => __('Home View','metrodircp_localize'),
        "desc" => __('Structure home view.','metrodircp_localize'),
        "id" => $shortname."_home_version",
        "std" => "map",
        "type" => "radio",
        "options" => array(
            'map' => 'Map',
            'strv' => 'Without map',
            'slider' => 'Revolution slider',
            'revmap' => 'Revolution slider and Map below',
            'maprev' => 'Map and Revolution slider below'));

    if ( is_plugin_active('revslider/revslider.php') ){
        $options[] = array( "name" => __('Slider','framework_localize'),
            "desc" => __('Choose Revolution Slider ID','framework_localize'),
            "id" => $shortname."_home_revslider",
            "std" => "1",
            "type" => "select",
            "options" => $tt_slider);
    }

    $options[] = array( "name" => __('Company Page Layout','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_companypage_version",
        "std" => "right",
        "type" => "radio",
        "options" => array(
            'left' => 'Left sidebar',
            'right' => 'Right sidebar'));

    $options[] = array( "name" => __('Slug for Company URL','metrodircp_localize'),
        "desc" => "After Change Slug Also You Should Save Permalink Option in Settings->Permalinks",
        "id" => $shortname."_slug_company",
        "std" => "company",
        "type" => "text");

    $options[] = array( "name" => __('Slug for Company Taxonomy URL','metrodircp_localize'),
        "desc" => "After Change Slug Also You Should Save Permalink Option in Settings->Permalinks",
        "id" => $shortname."_slug_company_tax",
        "std" => "company",
        "type" => "text");

    /* $options[] = array( "name" => __('Items to Show on "Blog List" Page','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_blog_list_count",
        "std" => "5",
        "type" => "select",
        "options" => array("All","5","10","15","20","25"));
    */

    $options[] = array( "name" => __('Items to Show on "Company List" Page','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_company_list_count",
        "std" => "5",
        "type" => "select",
        "options" => array("All","5","10","15","20","25"));

    $options[] = array("type" => "cross_line", "title" => __('Contact Options','metrodircp_localize'));

    $options[] = array( "name" => __('E-Mail Address For Contact Form','metrodircp_localize'),
        "desc" => "",
        "id" => $shortname."_email",
        "std" => "test@test.test",
        "type" => "text");

    $options[] = array( "name" => __('Subject for Contact Form','metrodircp_localize'),
        "desc" => "",
        "id" => $shortname."_email_sbj",
        "std" => "Message From Metrodir Site",
        "type" => "text");

    $options[] = array( "name" => __('Charset','metrodircp_localize'),
        "desc" => "",
        "id" => $shortname."_email_chrst",
        "std" => "UTF-8",
        "type" => "text");

    $options[] = array("type" => "cross_line", "title" => __('Footer Options','metrodircp_localize'));

    $options[] = array( "name" => __('Footer About Us Text','metrodircp_localize'),
        "desc" => "About your site.",
        "id" => $shortname."_footer_text",
        "std" => "Donec venenatis, turpis vel hendrerit interdum, dui ligula ultricies purus, sed posuere libero dui id orci. Nam congue, pede vitae dapibus aliquet, elit magna vulputate arcu, vel tempus metus leo non est. Etiam sit amet lectus quis est congue mollis.",
        "type" => "textarea");

    $options[] = array( "name" => __('Footer Widgets Area','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_footer_widget",
        "std" => "false",
        "type" => "checkbox");

    $options[] = array( "name" => __('Footer Copyright Text','metrodircp_localize'),
        "desc" => "Footer copyright",
        "id" => $shortname."_footer_copyright",
        "std" => "Copyright &copy; 2014 UOU Apps",
        "type" => "text");

    $options[] = array( "name" => __('Tracking Code','metrodircp_localize'),
        "desc" => __('Paste Google Analytics (or other) tracking code here.','metrodircp_localize'),
        "id" => $shortname."_google_analytics",
        "std" => "",
        "type" => "textarea");
/*
    $options[] = array( "name" => __('Google AdSense Code to Header *BETA*','glocalcp_localize'),
        "desc" => __('Paste Google AdSense (or other) ads code here.  Google ads support is in beta version and requires to be tested for feedback','metrodircp_localize'),
        "id" => $shortname."_google_ads",
        "std" => "",
        "type" => "textarea");
*/
/* Option Page 2 - Home page options */
$options[] = array( "name" => __('Homepage Settings','metrodircp_localize'),
    "type" => "heading");

    $options[] = array( "name" => __('Home View','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_home_view",
        "std" => "blocks",
        "type" => "radio",
        "options" => array(
            'blocks' => 'Blocks',
            'tabs' => 'Tabs'));

    $options[] = array("type" => "cross_line", "title" => __('Welcom Block','metrodircp_localize'));

    $options[] = array( "name" => __('Welcome Block Image','metrodircp_localize'),
        "desc" => __('Upload Welcome Image (90x90).','metrodircp_localize'),
        "id" => $shortname."_home_wlcm_image",
        "std" => $templateurl."logo-globe.png",
        "type" => "upload");

    $options[] = array( "name" => __('Welcome Block Image Link','metrodircp_localize'),
        "desc" => __('URL by clicking on the image','metrodircp_localize'),
        "id" => $shortname."_home_wlcm_link",
        "std" => "",
        "type" => "text");

    $options[] = array( "name" => __('Welcome Block Title','metrodircp_localize'),
        "desc" => __('h1','metrodircp_localize'),
        "id" => $shortname."_home_wlcm_title",
        "std" => "WELCOME TO <big>metro<strong>dir</strong></big>",
        "type" => "text");

    $options[] = array( "name" => __('Welcome Block Text','metrodircp_localize'),
        "desc" => __('Welcome Text','metrodircp_localize'),
        "id" => $shortname."_home_wlcm_text",
        "std" => "METRODIR IS THE BEST LOCAL DIRECTORY THAT PROVIDES YOU WITH INFORMATION COMING FROM ACROSS THE GLOBE.",
        "type" => "textarea");

    $options[] = array("type" => "cross_line", "title" => __('Categories Block','metrodircp_localize'));

    $options[] = array( "name" => __('Categories Block on Home Page','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_home_category",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Categories Block Style','metrodircp_localize'),
        "id" => $shortname."_category_version",
        "std" => "old",
        "type" => "images",
        "options" => array(
            'old' => $sampleurl.'category-1.jpg',
            'new' => $sampleurl.'category-2.jpg',
            'new-hidden' => $sampleurl.'category-3.jpg'));

    $options[] = array( "name" => __('Use Image in Categories Block','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_home_category_image",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Show/Hide Subcategories','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_home_category_sub",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array("type" => "cross_line", "title" => __('Featured Companies Block','metrodircp_localize'));

    $options[] = array( "name" => __('Featured Companies Block on Home Page','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_home_featured",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Featured Companies to show','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_home_featured_count",
        "std" => "10",
        "type" => "select",
        "options" => array("5","10","15"));

    $options[] = array("type" => "cross_line", "title" => __('Latest Companies Block','metrodircp_localize'));

    $options[] = array( "name" => __('Latest Companies Block on Home Page','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_home_latest",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Latest Companies to show','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_home_latest_count",
        "std" => "10",
        "type" => "select",
        "options" => array("5","10","15"));

    $options[] = array("type" => "cross_line", "title" => __('Subscribe Block','metrodircp_localize'));

    $options[] = array( "name" => __('Pricing Plans Block on Home Page','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_home_pricing_plans",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Registration Block on Home Page','metrodircp_localize'),
        "desc" => __('Enable. (Disable still hides the "Registration" button in "Header".)','metrodircp_localize'),
        "id" => $shortname."_home_subscribe",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array("type" => "cross_line", "title" => __('Custom Block','metrodircp_localize'));

    $options[] = array( "name" => __('Custom Block on Home Page','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_home_customblck_active",
        "std" => "false",
        "type" => "checkbox");

    $options[] = array( "name" => __('Custom Block Title','metrodircp_localize'),
        "desc" => __('h2','metrodircp_localize'),
        "id" => $shortname."_home_customblck_h2",
        "std" => "",
        "type" => "text");

    $options[] = array( "name" => __('Custom Block Body','metrodircp_localize'),
        "desc" => __('Paste HTML custom block','metrodircp_localize'),
        "id" => $shortname."_home_customblck",
        "std" => "",
        "type" => "textarea");

    $options[] = array("type" => "cross_line", "title" => __('Custom Tab','metrodircp_localize'));

    $options[] = array( "name" => __('Custom Tab on Home Page','metrodircp_localize'),
        "desc" => __('Enable. (If select Tabs home page view)','metrodircp_localize'),
        "id" => $shortname."_home_customtab_active",
        "std" => "false",
        "type" => "checkbox");

    $options[] = array( "name" => __('Custom Tab Title','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_home_customtab",
        "std" => "",
        "type" => "text");

    $options[] = array( "name" => __('Custom Tab Body','metrodircp_localize'),
        "desc" => __('Paste HTML custom block','metrodircp_localize'),
        "id" => $shortname."_home_customtab_body",
        "std" => "",
        "type" => "textarea");

/* Option Page 3 - SideBar */
$options[] = array( "name" => __('Sidebar Settings','metrodircp_localize'),
        "type" => "heading");

    $options[] = array( "name" => __('Sidebar Widgets Area (For Single and Search Pages)','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_sidebar_widgets",
        "std" => "false",
        "type" => "checkbox");

    $options[] = array( "name" => __('Where Show','metrodircp_localize'),
        "desc" => __('Where Show SideBar. (This option does not affect the position of the "Company Page")','metrodircp_localize'),
        "id" => $shortname."_sidebar",
        "std" => "right",
        "type" => "radio",
        "options" => array(
            'left' => 'Show Left',
            'right' => 'Show Right'));

    $options[] = array( "name" => __('Blog Search','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_sidebar_search",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array("type" => "cross_line", "title" => __('Featured Block','metrodircp_localize'));

    $options[] = array( "name" => __('Featured Block in SideBar','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_sidebar_featured",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Featured Companies to show','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_sidebar_featured_count",
        "std" => "2",
        "type" => "select",
        "options" => array("2","3","4","5"));

    $options[] = array("type" => "cross_line", "title" => __('Recently Added Block','metrodircp_localize'));

    $options[] = array( "name" => __('Recently Added Block in SideBar','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_sidebar_recently",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Recently Added Companies to show','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_sidebar_recently_count",
        "std" => "2",
        "type" => "select",
        "options" => array("2","3","4","5"));

    $options[] = array("type" => "cross_line", "title" => __('Sidebar Two Small Banners','metrodircp_localize'));

    $options[] = array( "name" => __('Banner 1 Upload','metrodircp_localize'),
        "desc" => __('Upload Sidebar Banner 1 (140*140 Recommended).','metrodircp_localize'),
        "id" => $shortname."_site_sidebanner_1",
        "std" => $templateurl."content/sidebar_banner_1.png",
        "type" => "upload");

    $options[] = array(
        "id" => $shortname."_site_sidebanner_1_url",
        "desc" => __("Banner 1 URL",'metrodircp_localize'),
        "std" => "#",
        "del_line" => true,
        "type" => "text");

    $options[] = array( "name" => __('Open Banner 1 URL in New Window','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_site_sidebanner_1_window",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Banner 1 Nofollow','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_site_sidebanner_1_nofollow",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Banner 2 Upload','metrodircp_localize'),
        "desc" => __('Upload Sidebar Banner 2 (140*140 Recommended).','metrodircp_localize'),
        "id" => $shortname."_site_sidebanner_2",
        "std" => $templateurl."content/sidebar_banner_2.png",
        "type" => "upload");

    $options[] = array(
        "id" => $shortname."_site_sidebanner_2_url",
        "desc" => __("Banner 2 URL",'metrodircp_localize'),
        "std" => "#",
        "del_line" => true,
        "type" => "text");

    $options[] = array( "name" => __('Open Banner 2 URL in New Window','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_site_sidebanner_2_window",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Banner 2 Nofollow','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_site_sidebanner_2_nofollow",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array("type" => "cross_line", "title" => __('Latest Posts Block','metrodircp_localize'));

    $options[] = array( "name" => __('Latest Posts Block in SideBar','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_sidebar_latest",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Latest Posts to show','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_sidebar_latest_count",
        "std" => "2",
        "type" => "select",
        "options" => array("2","3","4","5"));

    $options[] = array("type" => "cross_line", "title" => __('Sidebar Banner (Big)','metrodircp_localize'));

    $options[] = array( "name" => __('Sidebar Banner Upload','metrodircp_localize'),
        "desc" => __('Upload Sidebar Banner Big (600*500 Recommended).','metrodircp_localize'),
        "id" => $shortname."_site_sidebanner",
        "std" => $templateurl."content/sidebar_banner.png",
        "type" => "upload");

    $options[] = array(
        "id" => $shortname."_site_sidebanner_url",
        "desc" => __("Banner URL",'metrodircp_localize'),
        "std" => "#",
        "del_line" => true,
        "type" => "text");

    $options[] = array( "name" => __('Open URL in New Window','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_site_sidebanner_window",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Nofollow','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_site_sidebanner_nofollow",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array("type" => "cross_line", "title" => __('Custom Block','metrodircp_localize'));

    $options[] = array( "name" => __('Custom Block in Sidebar','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_sidebar_customblck_active",
        "std" => "false",
        "type" => "checkbox");

    $options[] = array( "name" => __('Custom Block Title','metrodircp_localize'),
        "desc" => __('h2','metrodircp_localize'),
        "id" => $shortname."_sidebar_customblck_h2",
        "std" => "",
        "type" => "text");

    $options[] = array( "name" => __('Custom Block Body','metrodircp_localize'),
        "desc" => __('Paste HTML custom block','metrodircp_localize'),
        "id" => $shortname."_sidebar_customblck",
        "std" => "",
        "type" => "textarea");

/* Option Page 4 - Map options */
$options[] = array( "name" => __('Map Settings','metrodircp_localize'),
    "type" => "heading");

    $options[] = array("type" => "cross_line", "title" => __('Map engine (uouapps Map v.2.6)','metrodircp_localize'));

    $options[] = array( "name" => __('Hidden Map on Load','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_map_hide",
        "std" => "false",
        "type" => "checkbox");

    $options[] = array( "name" => __('Draggable Map','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_map_drag",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Map Lock/Unlock Button','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_map_disablebtn",
        "std" => "false",
        "type" => "checkbox");

    $options[] = array( "name" => __('Scrollwheel Zoom Map','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_map_scroll",
        "std" => "false",
        "type" => "checkbox");

    $options[] = array( "name" => __('Map Load Zoom','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_map_zoom",
        "std" => "10",
        "type" => "select",
        "options" => array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15"));

    $options[] = array( "name" => __('Map Type','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_map_type",
        "std" => "ROADMAP",
        "type" => "radio",
        "options" => array(
            'ROADMAP' => 'Roadmap',
            'SATELLITE' => 'Satellite',
            'HYBRID' => 'Hybrid',
            'TERRAIN' => 'Terrain'));

    $options[] = array( "name" => __('Markers Type','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_markers_type",
        "std" => "html",
        "type" => "radio",
        "options" => array(
            'html' => 'Html',
            'image' => 'Image'));

    $options[] = array( "name" => __('Markers Information','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_markers_info",
        "std" => "address",
        "type" => "radio",
        "options" => array(
            'address' => 'Address',
            'desc' => 'Description',
            'phone' => 'Phone & Email'));

    $options[] = array( "name" => __('Map Centering','metrodircp_localize'),
        "desc" => __('Default map targeting.','metrodircp_localize'),
        "id" => $shortname."_map_centermap",
        "std" => "center_all",
        "type" => "radio",
        "options" => array(
            'centre_world' => 'Centre by World',
            'centre_geomap' => 'Centre by Geolocation',
            'center_all' => 'Centre by All Company\'s',
            'centre_random' => 'Centre by Random Company',
            'centre_last' => 'Centre by Last Company',
            'centre_addr' => 'Centre by Address (set below)'));

    $options[] = array( "name" => __('Default Category','framework_localize'),
        "desc" => __("Only for Home Page.",'metrodircp_localize'),
        "id" => $shortname."_home_defcat",
        "std" => "1",
        "type" => "select",
        "options" => $tt_categories);

    $options[] = array( "name" => __('Show Subcategories in Under Map Filter','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_map_subcat",
        "std" => "false",
        "type" => "checkbox");

    $options[] = array("type" => "cross_line", "title" => __('Address Centering','metrodircp_localize'));

    $options[] = array( "name" => __('Address Centering','metrodircp_localize'),
        "id" => $shortname."_company_cntr_address",
        "std" => "Belarus, Mogilev",
        "type" => "text");

    $options[] = array(
        "id" => $shortname."_company_address_gps",
        "del_line" => true,
        "type" => "gps_convert_cntr");

    $options[] = array(
        "id" => $shortname."_company_cntr_address_lat",
        "desc" => __("Latitude",'metrodircp_localize'),
        "std" => "53.9",
        "del_line" => true,
        "type" => "text");

    $options[] = array(
        "id" => $shortname."_company_cntr_address_lng",
        "desc" => __("Longitude",'metrodircp_localize'),
        "std" => "30.333333300000052",
        "del_line" => true,
        "type" => "text");

    $options[] = array("type" => "cross_line", "title" => __('Map Clusters (v.1.0)','metrodircp_localize'));

    $options[] = array( "name" => __('Map Clusters','metrodircp_localize'),
        "desc" => __('Enable. (Only for Image Markers Type)','metrodircp_localize'),
        "id" => $shortname."_map_clusters",
        "std" => "false",
        "type" => "checkbox");

    $options[] = array( "name" => __('Map Clusters Grid Size','metrodircp_localize'),
        "desc" => __('Recommended Values','metrodircp_localize'),
        "id" => $shortname."_map_clusters_grid",
        "std" => "50",
        "type" => "select",
        "options" => array("10","20","30","40","50","60","70","80","90","100"));

    $options[] = array( "name" => __('Map Clusters Min Size','metrodircp_localize'),
        "desc" => __('Recommended Values','metrodircp_localize'),
        "id" => $shortname."_map_clusters_min",
        "std" => "2",
        "type" => "select",
        "options" => array("2","4","6","8","10","16","32","64"));

    $options[] = array( "name" => __('Map Clusters Icons URL','metrodircp_localize'),
        "desc" => __("You also can change images in wp-content/themes/metrodir/images/clusters/*",'metrodircp_localize'),
        "id" => $shortname."_map_clusters_icons_url",
        "std" => $templateurl."clusters/cluster-",
        "type" => "text");

/* Option Page 5 - Search options */
$options[] = array( "name" => __('Search Settings','metrodircp_localize'),
    "type" => "heading");

    $options[] = array("type" => "cross_line", "title" => __('Search engine (uouapps Search v.1.5)','metrodircp_localize'));

    $options[] = array( "name" => __('Search','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_search_def",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Search with Fixed Map','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_search_fix_map",
        "std" => "false",
        "type" => "checkbox");

    $options[] = array( "name" => __('Fixed Map Position','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_search_fix_map_position",
        "std" => "left",
        "type" => "radio",
        "options" => array(
            'left' => 'Left',
            'right' => 'Right'));

    $options[] = array( "name" => __('Search Results Style','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_search_style",
        "std" => "default",
        "type" => "radio",
        "options" => array(
            'default' => 'Default',
            'thumb' => 'Thumb'));

    $options[] = array( "name" => __('Items to Show on "Search" Page','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_search_list_count",
        "std" => "All",
        "type" => "select",
        "options" => array("All","5","6","9","10","12","15","18","20","21","24","25"));

    $options[] = array( "name" => __('Show Search on RevSlider','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_home_search_rev",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Advanced Search','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_search_adv",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Global Search (in Header)','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_search_mega",
        "std" => "false",
        "type" => "checkbox");

    $options[] = array( "name" => __('Radius Search','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_search_radius",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Show Sidebar on Search Pages','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_search_sidebar",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Show Subcategories on Search and Categories Pages','metrodircp_localize'),
        "desc" => __('Enable.','metrodircp_localize'),
        "id" => $shortname."_search_subcat",
        "std" => "false",
        "type" => "checkbox");

    $options[] = array( "name" => __('Map Unit','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_map_kmmi",
        "std" => "km",
        "type" => "radio",
        "options" => array(
            'km' => 'Kilometers',
            'mi' => 'Miles'));

    $options[] = array( "name" => __('Slider Radius Minimal Value (km/mi)','metrodircp_localize'),
        "id" => $shortname."_search_dist_min",
        "std" => "1",
        "type" => "text");

    $options[] = array( "name" => __('Slider Radius Maximal Value (km/mi)','metrodircp_localize'),
        "id" => $shortname."_search_dist_max",
        "std" => "5000",
        "type" => "text");

    $options[] = array( "name" => __('Slider Radius Default Value (km/mi)','metrodircp_localize'),
        "id" => $shortname."_search_dist_def",
        "std" => "1500",
        "type" => "text");


    $options[] = array( "name" => __('Days Published Maximal Value','metrodircp_localize'),
        "id" => $shortname."_search_days_max",
        "std" => "30",
        "type" => "text");

    $options[] = array( "name" => __('Additional Fields','metrodircp_localize'),
        "id" => $shortname."_advsearch_fields",
        "std" => "Month",
        "type" => "multicheck",
        "options" => $tt_fields);

    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

    if ( is_plugin_active('types/wpcf.php') ){
        $options[] = array( "name" => __('Type Additional Fields','metrodircp_localize'),
            "id" => $shortname."_advsearch_fields_type",
            "std" => "Month",
            "type" => "multicheck",
            "options" => $tt_fields_type);}


/* Option Page 6 - Metrodir Company */
$options[] = array( "name" => __('Contact Details','metrodircp_localize'),
    "type" => "heading");
$options[] = array("type" => "cross_line", "title" => __('Address Details','metrodircp_localize'));

    $options[] = array( "name" => __('Email','metrodircp_localize'),
        "id" => $shortname."_company_email",
        "std" => "email@example.com",
        "type" => "text");

    $options[] = array( "name" => __('Phone','metrodircp_localize'),
        "id" => $shortname."_company_phone",
        "std" => "+1 123-456-7890",
        "type" => "text");

    $options[] = array( "name" => __('Fax','metrodircp_localize'),
        "id" => $shortname."_company_fax",
        "std" => "+1 123-456-7890",
        "type" => "text");

    $options[] = array( "name" => __('Address','metrodircp_localize'),
        "id" => $shortname."_company_address",
        "std" => "1234 Street Mountain View, CA 94043",
        "type" => "text");

    $options[] = array(
        "id" => $shortname."_company_address_gps",
        "del_line" => true,
        "type" => "gps_convert");

    $options[] = array(
        "id" => $shortname."_company_address_lat",
        "desc" => __("Latitude",'metrodircp_localize'),
        "std" => "37.3846064",
        "del_line" => true,
        "type" => "text");

    $options[] = array(
        "id" => $shortname."_company_address_lng",
        "desc" => __("Longitude",'metrodircp_localize'),
        "std" => "-122.09026970000002",
        "del_line" => true,
        "type" => "text");

    $options[] = array( "name" => __('Website','metrodircp_localize'),
        "id" => $shortname."_company_website",
        "std" => "www.example.com",
        "type" => "text");

    $options[] = array("type" => "cross_line", "title" => __('Opening Hours','metrodircp_localize'));

    $options[] = array( "name" => __('1 Opening Interval','metrodircp_localize'),
        "desc" => __("1 Day interval",'metrodircp_localize'),
        "id" => $shortname."_company_1int_day",
        "std" => "Monday-Friday",
        "type" => "text");
    $options[] = array(
        "id" => $shortname."_company_1int_hr",
        "desc" => __("1 Time interval",'metrodircp_localize'),
        "del_line" => true,
        "std" => "9am - 5pm",
        "type" => "text");

    $options[] = array( "name" => __('2 Opening Interval','metrodircp_localize'),
        "desc" => __("2 Day interval",'metrodircp_localize'),
        "id" => $shortname."_company_2int_day",
        "std" => "Saturday",
        "type" => "text");

    $options[] = array(
        "id" => $shortname."_company_2int_hr",
        "desc" => __("2 Time interval",'metrodircp_localize'),
        "del_line" => true,
        "std" => "10am - 3pm",
        "type" => "text");

    $options[] = array( "name" => __('3 Opening Interval','metrodircp_localize'),
        "desc" => __("3 Day interval",'metrodircp_localize'),
        "id" => $shortname."_company_3int_day",
        "std" => "Sunday",
        "type" => "text");

    $options[] = array(
        "id" => $shortname."_company_3int_hr",
        "desc" => __("3 Time interval",'metrodircp_localize'),
        "std" => "Closed",
        "del_line" => true,
        "type" => "text");

    $options[] = array( "name" => __('4 Opening Interval','metrodircp_localize'),
        "desc" => __("4 Day interval",'metrodircp_localize'),
        "id" => $shortname."_company_4int_day",
        "std" => "",
        "type" => "text");
    $options[] = array(
        "id" => $shortname."_company_4int_hr",
        "desc" => __("4 Time interval",'metrodircp_localize'),
        "std" => "",
        "del_line" => true,
        "type" => "text");

/* Option Page 7 - PayPal options */
$options[] = array( "name" => __('Payment Gateway','metrodircp_localize'),
    "type" => "heading");
$options[] = array("type" => "cross_line", "title" => __('PayPal settings','metrodircp_localize'));

    $options[] = array( "name" => __('Activate PayPal System','metrodircp_localize'),
        "desc" => "Enable PayPal system to buy packages",
        "id" => $shortname."_pp_act",
        "std" => "false",
        "type" => "checkbox");

    $options[] = array( "name" => __('PayPal API Environment','metrodircp_localize'),
        "desc" => __('Use sandbox (virtual) enviroment to testing paypal functionality (developer.paypal.com). <br/> Use live (real) enviroment.','metrodircp_localize'),
        "id" => $shortname."_pp_api",
        "std" => "sandbox",
        "type" => "radio",
        "options" => array(
            'sandbox' => 'SandBox (virtual)',
            'live' => 'Live (real)'));

    $options[] = array( "name" => __('PayPal Payment Type','metrodircp_localize'),
        "desc" => __('Use Single to single payments. <br/> Use Recurring to subscriptions payments','metrodircp_localize'),
        "id" => $shortname."_pp_type",
        "std" => "single",
        "type" => "radio",
        "options" => array(
            'single' => 'Single',
            'recurr' => 'Recurring'));

    $options[] = array( "name" => __('PayPal API Username','metrodircp_localize'),
        "id" => $shortname."_pp_username",
        "std" => "",
        "type" => "text");

    $options[] = array( "name" => __('PayPal API Password','metrodircp_localize'),
        "id" => $shortname."_pp_pass",
        "std" => "",
        "type" => "text");

    $options[] = array( "name" => __('PayPal API Signature','metrodircp_localize'),
        "id" => $shortname."_pp_signature",
        "std" => "",
        "type" => "text");

    $options[] = array( "name" => __('PayPal API Currency Code','metrodircp_localize'),
        "std" => "USD",
        "id" => $shortname."_pp_currency",
        "type" => "text");

    $options[] = array( "name" => __('PayPal Payment Name','metrodircp_localize'),
        "id" => $shortname."_pp_name",
        "std" => "metrodir package",
        "type" => "text");

/* Option Page 8 - Our partners */
$options[] = array( "name" => __('Partners','metrodircp_localize'),
    "type" => "heading");

    $options[] = array("type" => "cross_line", "title" => __('1 - Partner','metrodircp_localize'));

    $options[] = array( "name" => __('Display on Site','metrodircp_localize'),
        "id" => $shortname."_partner_1_dsp",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Partners Logo','metrodircp_localize'),
        "desc" => __('Recomended size 180*120.','metrodircp_localize'),
        "id" => $shortname."_partner_1",
        "std" => $templateurl."content/partner-1.jpg",
        "type" => "upload");

    $options[] = array( "name" => __('Partners Url','metrodircp_localize'),
        "id" => $shortname."_partner_1_url",
        "std" => "",
        "type" => "text");

    $options[] = array("type" => "cross_line", "title" => __('2 - Partner','metrodircp_localize'));

    $options[] = array( "name" => __('Display on Site','metrodircp_localize'),
        "id" => $shortname."_partner_2_dsp",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Partners Logo','metrodircp_localize'),
        "desc" => __('Recomended size 180*120.','metrodircp_localize'),
        "id" => $shortname."_partner_2",
        "std" => $templateurl."content/partner-2.jpg",
        "type" => "upload");

    $options[] = array( "name" => __('Partners Url','metrodircp_localize'),
        "id" => $shortname."_partner_2_url",
        "std" => "",
        "type" => "text");

    $options[] = array("type" => "cross_line", "title" => __('3 - Partner','metrodircp_localize'));

    $options[] = array( "name" => __('Display on Site','metrodircp_localize'),
        "id" => $shortname."_partner_3_dsp",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Partners Logo','metrodircp_localize'),
        "desc" => __('Recomended size 180*120.','metrodircp_localize'),
        "id" => $shortname."_partner_3",
        "std" => $templateurl."content/partner-3.jpg",
        "type" => "upload");

    $options[] = array( "name" => __('Partners Url','metrodircp_localize'),
        "id" => $shortname."_partner_3_url",
        "std" => "",
        "type" => "text");

    $options[] = array("type" => "cross_line", "title" => __('4 - Partner','metrodircp_localize'));

    $options[] = array( "name" => __('Display on Site','metrodircp_localize'),
        "id" => $shortname."_partner_4_dsp",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Partners Logo','metrodircp_localize'),
        "desc" => __('Recomended size 180*120.','metrodircp_localize'),
        "id" => $shortname."_partner_4",
        "std" => $templateurl."content/partner-4.jpg",
        "type" => "upload");

    $options[] = array( "name" => __('Partners Url','metrodircp_localize'),
        "id" => $shortname."_partner_4_url",
        "std" => "",
        "type" => "text");

    $options[] = array("type" => "cross_line", "title" => __('5 - Partner','metrodircp_localize'));

    $options[] = array( "name" => __('Display on Site','metrodircp_localize'),
        "id" => $shortname."_partner_5_dsp",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Partners Logo','metrodircp_localize'),
        "desc" => __('Recomended size 180*120.','metrodircp_localize'),
        "id" => $shortname."_partner_5",
        "std" => $templateurl."content/partner-5.jpg",
        "type" => "upload");

    $options[] = array( "name" => __('Partners Url','metrodircp_localize'),
        "id" => $shortname."_partner_5_url",
        "std" => "",
        "type" => "text");

    $options[] = array("type" => "cross_line", "title" => __('6 - Partner','metrodircp_localize'));

    $options[] = array( "name" => __('Display on Site','metrodircp_localize'),
        "id" => $shortname."_partner_6_dsp",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Partners Logo','metrodircp_localize'),
        "desc" => __('Recomended size 180*120.','metrodircp_localize'),
        "id" => $shortname."_partner_6",
        "std" => $templateurl."content/partner-5.jpg",
        "type" => "upload");

    $options[] = array( "name" => __('Partners Url','metrodircp_localize'),
        "id" => $shortname."_partner_6_url",
        "std" => "",
        "type" => "text");

    $options[] = array("type" => "cross_line", "title" => __('7 - Partner','metrodircp_localize'));

    $options[] = array( "name" => __('Display on Site','metrodircp_localize'),
        "id" => $shortname."_partner_7_dsp",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Partners Logo','metrodircp_localize'),
        "desc" => __('Recomended size 180*120.','metrodircp_localize'),
        "id" => $shortname."_partner_7",
        "std" => $templateurl."content/partner-4.jpg",
        "type" => "upload");

    $options[] = array( "name" => __('Partners Url','metrodircp_localize'),
        "id" => $shortname."_partner_7_url",
        "std" => "",
        "type" => "text");

    $options[] = array("type" => "cross_line", "title" => __('8 - Partner','metrodircp_localize'));

    $options[] = array( "name" => __('Display on Site','metrodircp_localize'),
        "id" => $shortname."_partner_8_dsp",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Partners Logo','metrodircp_localize'),
        "desc" => __('Recomended size 180*120.','metrodircp_localize'),
        "id" => $shortname."_partner_8",
        "std" => $templateurl."content/partner-3.jpg",
        "type" => "upload");

    $options[] = array( "name" => __('Partners Url','metrodircp_localize'),
        "id" => $shortname."_partner_8_url",
        "std" => "",
        "type" => "text");

    $options[] = array("type" => "cross_line", "title" => __('9 - Partner','metrodircp_localize'));

    $options[] = array( "name" => __('Display on Site','metrodircp_localize'),
        "id" => $shortname."_partner_9_dsp",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Partners Logo','metrodircp_localize'),
        "desc" => __('Recomended size 180*120.','metrodircp_localize'),
        "id" => $shortname."_partner_9",
        "std" => $templateurl."content/partner-2.jpg",
        "type" => "upload");

    $options[] = array( "name" => __('Partners Url','metrodircp_localize'),
        "id" => $shortname."_partner_9_url",
        "std" => "",
        "type" => "text");

    $options[] = array("type" => "cross_line", "title" => __('10 - Partner','metrodircp_localize'));

    $options[] = array( "name" => __('Display on Site','metrodircp_localize'),
        "id" => $shortname."_partner_10_dsp",
        "std" => "true",
        "type" => "checkbox");

    $options[] = array( "name" => __('Partners Logo','metrodircp_localize'),
        "desc" => __('Recomended size 180*120.','metrodircp_localize'),
        "id" => $shortname."_partner_10",
        "std" => $templateurl."content/partner-1.jpg",
        "type" => "upload");

    $options[] = array( "name" => __('Partners Url','metrodircp_localize'),
        "id" => $shortname."_partner_10_url",
        "std" => "",
        "type" => "text");

/* Option Page 9 - Social icons */
$options[] = array( "name" => __('Social Networks','metrodircp_localize'),
    "type" => "heading");

    $options[] = array("type" => "cross_line", "title" => __('Social Buttons','metrodircp_localize'));

    $options[] = array( "name" => __('Facebook','metrodircp_localize'),
        "id" => $shortname."_social_fb",
        "std" => "http://facebook.com",
        "social_icons" => "facebook-square",
        "type" => "text");

    $options[] = array( "name" => __('Google+','metrodircp_localize'),
        "id" => $shortname."_social_gp",
        "std" => "http://googleplus.com",
        "social_icons" => "google-plus-square",
        "type" => "text");

    $options[] = array( "name" => __('Twitter','metrodircp_localize'),
        "id" => $shortname."_social_tw",
        "std" => "http://twitter.com",
        "social_icons" => "twitter-square",
        "type" => "text");

    $options[] = array( "name" => __('LinkedIn','metrodircp_localize'),
        "id" => $shortname."_social_li",
        "std" => "http://linkedin.com",
        "social_icons" => "linkedin-square",
        "type" => "text");

    $options[] = array( "name" => __('Pinterest','metrodircp_localize'),
        "id" => $shortname."_social_pt",
        "std" => "http://pinterest.com",
        "social_icons" => "pinterest-square",
        "type" => "text");

    $options[] = array( "name" => __('Dribbble','metrodircp_localize'),
        "id" => $shortname."_social_dr",
        "std" => "http://dribbble.com",
        "social_icons" => "dribbble",
        "type" => "text");

    $options[] = array("type" => "cross_line", "title" => __('Flickr Block','metrodircp_localize'));

    $options[] = array( "name" => __('Flickr Block ID','metrodircp_localize'),
        "desc" => __('It\'s variable used on footer block widget'),
        "id" => $shortname."_flickr_id",
        "std" => "52617155@N08",
        "type" => "text");

    $options[] = array("type" => "cross_line", "title" => __('Twitter Block','metrodircp_localize'));

    $options[] = array( "name" => __('Twitter Block ID','metrodircp_localize'),
        "desc" => __('It\'s variable used on footer block widget'),
        "id" => $shortname."_twitter_id",
        "std" => "377042022453899264",
        "type" => "text");

    $options[] = array( "name" => __('Twitter Block Text','metrodircp_localize'),
        "desc" => __('It\'s variable used on footer block widget twitter custom text'),
        "id" => $shortname."_twitter_text",
        "std" => "Tweets by @uouapps",
        "type" => "text");

    $options[] = array( "name" => __('Twitter Block Link','metrodircp_localize'),
        "desc" => __('It\'s variable used on footer block widget'),
        "id" => $shortname."_twitter_link",
        "std" => "https://twitter.com/uouapps",
        "type" => "text");

/* Option Page 10 - Multilingual */
$options[] = array( "name" => __('Multilingual Settings','metrodircp_localize'),
    "type" => "heading");

    $options[] = array( "name" => __('This Theme Ready for Translate by WPML','metrodircp_localize'),
        "desc" => "",
        "id" => $shortname."_sample_callout",
        "std" => "<a href='http://wpml.org'><img src='".$templateurl."wpml.jpg' /></a>",
        "type" => "info");

    $options[] = array( "name" => __('Language Switcher Style','metrodircp_localize'),
        "desc" => __('','metrodircp_localize'),
        "id" => $shortname."_wpml_type",
        "std" => "Language code",
        "type" => "select",
        "options" => array("Language Code","Language Name","Flag","Flag and Code","Flag and Name"));


    update_option('of_template',$options);
    update_option('of_shortname',$shortname);

}
}
?>