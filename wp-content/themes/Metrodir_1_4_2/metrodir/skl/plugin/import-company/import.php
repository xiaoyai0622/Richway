<?php
/*
 *
 *  Post Type
 *
 */
class ImportCompany {

    public $id;
    public $name;
    public $default_options;
    public $meta_options;
    public $taxonomies;
    private $fw_post_types_path;

    public function __construct($id) {

        $this->default_options = array(
            'post_name' => array(
                'label' => __("Name/ID/Slug","metrodir_import"),
                'notice' => __("Name (slug) company","metrodir_import")
            ),
            'post_title' => array(
                'label' => __("Title","metrodir_import"),
                'notice' => ''
            ),
            'post_status' => array(
                'label' => __("Company status","metrodir_import"),
                'notice' => __("Available values: draft, publish, pending, future, private. Default: draft","metrodir_import")
            ),
            'post_content' => array(
                'label' => __("Content","metrodir_import"),
                'notice' => ''
            ),
            'post_excerpt' => array(
                'label' => __("Excerpt","metrodir_import"),
                'notice' => ''
            ),
            'post_author' => array(
                'label' => __("Author username","metrodir_import"),
                'notice' => __("Default author is currently user","metrodir_import")
            ),
            'post_date' => array(
                'label' => __("Date","metrodir_import"),
                'notice' => __("Date in format: Y-m-d H:i:s (example: 2013-06-12 18:12:00). Default: currently date","metrodir_import")
            ),
            'post_image' => array(
                'label' => __("Featured Image","metrodir_import"),
                'notice' => __("Slug (name) of media file","metrodir_import")
            ),
            'comment_status' => array(
                'label' => __("Comment status","metrodir_import"),
                'notice' => __("Available values: closed, open","metrodir_import")
            )
        );

        $this->options_list = array(
            'metrodir' => array(
                'wlctext_name' => array(
                    'label' => __('Welcome text','metrodir_import'),
                    'notice' => __("Welcome text company",'metrodir_import')
                ),
                'company_doc_desc' => array(
                    'label' => __('Description','metrodir_import'),
                    'notice' => __("Description company.",'metrodir_import')
                ),
                'company_image1_url' => array(
                    'label' => __('URL images company','metrodir_import'),
                    'notice' => __("URL (example: http://**.**/**.jpg)",'metrodir_import')
                ),
                'company_company_soc_fb' => array(
                    'label' => __('Social facebook','metrodir_import'),
                    'notice' => __("URL (example: http://**.**/**.jpg)",'metrodir_import')
                ),
                'company_company_soc_tw' => array(
                    'label' => __('Social twitter','metrodir_import'),
                    'notice' => __("URL (example: http://**.**/**.jpg)",'metrodir_import')
                ),
                'company_company_soc_gp' => array(
                    'label' => __('Social Google+','metrodir_import'),
                    'notice' => __("URL (example: http://**.**/**.jpg)",'metrodir_import')
                ),
                'company_company_soc_li' => array(
                    'label' => __('Social Linkedin','metrodir_import'),
                    'notice' => __("URL (example: http://**.**/**.jpg)",'metrodir_import')
                ),
                'company_company_soc_pt' => array(
                    'label' => __('Social Pinterest','metrodir_import'),
                    'notice' => __("URL (example: http://**.**/**.jpg)",'metrodir_import')
                ),
                'company_company_soc_dr' => array(
                    'label' => __('Social Dribbble','metrodir_import'),
                    'notice' => __("URL (example: http://**.**/**.jpg)",'metrodir_import')
                ),
                'address_country_name' => array(
                    'label' => __('Country','metrodir_import'),
                    'notice' => __(" ",'metrodir_import')
                ),
                'address_region_name' => array(
                    'label' => __('Region','metrodir_import'),
                    'notice' => __(" ",'metrodir_import')
                ),
                'address_name' => array(
                    'label' => __('Address','metrodir_import'),
                    'notice' => __(" ",'metrodir_import')
                ),
                'address_lat' => array(
                    'label' => __('Latitude','metrodir_import'),
                    'notice' => __("*Required ",'metrodir_import')
                ),
                'address_lng' => array(
                    'label' => __('longitude','metrodir_import'),
                    'notice' => __("*Required ",'metrodir_import')
                ),
                'shw_strv' => array(
                    'label' => __('Show Streetview instead of the map in detail','metrodir_import'),
                    'notice' => __("Available values: Map, Streetview, Blank",'metrodir_import')
                ),
                'company_doc_founded' => array(
                    'label' => __('Founded','metrodir_import'),
                    'notice' => __("Founded company.",'metrodir_import')
                ),
                'company_doc_legal' => array(
                    'label' => __('Legal Entity','metrodir_import'),
                    'notice' => __(" ",'metrodir_import')
                ),
                'company_doc_turnover' => array(
                    'label' => __('Turnover','metrodir_import'),
                    'notice' => __(" ",'metrodir_import')
                ),
                'company_doc_empl' => array(
                    'label' => __('Number of Employees','metrodir_import'),
                    'notice' => __(" ",'metrodir_import')
                ),
                'company_doc_phone' => array(
                    'label' => __('Phone','metrodir_import'),
                    'notice' => __(" ",'metrodir_import')
                ),
                'company_soc_fax' => array(
                    'label' => __('Fax','metrodir_import'),
                    'notice' => __(" ",'metrodir_import')
                ),
                'company_soc_email' => array(
                    'label' => __('E-mail','metrodir_import'),
                    'notice' => __(" ",'metrodir_import')
                ),
                'company_soc_email_form' => array(
                    'label' => __('Email contact form','metrodir_import'),
                    'notice' => __("Available values: Hide, Display",'metrodir_import')
                ),
                'company_contact_tabs_act' => array(
                    'label' => __('Contact tabs','metrodir_import'),
                    'notice' => __("Available values: Hide, Display",'metrodir_import')
                ),
                'company_soc_web' => array(
                    'label' => __('Website','metrodir_import'),
                    'notice' => __("",'metrodir_import')
                ),
                'company_soc_web' => array(
                    'label' => __('Website','metrodir_import'),
                    'notice' => __("",'metrodir_import')
                ),
                'company_tags' => array(
                    'label' => __('Range of Services tags','metrodir_import'),
                    'notice' => __("Separate by ',' ",'metrodir_import')
                ),
                'company_soc_openhrs1' => array(
                    'label' => __('Opening Hours 1:','metrodir_import'),
                    'notice' => __("1 interval, (days, hours !!Separate by , ) (example: monday, 18:00)",'metrodir_import')
                ),
                'company_soc_openhrs2' => array(
                    'label' => __('Opening Hours 2:','metrodir_import'),
                    'notice' => __("2 interval, (days, hours !!Separate by , ) (example: monday, 18:00)",'metrodir_import')
                ),
                'company_soc_openhrs3' => array(
                    'label' => __('Opening Hours 3:','metrodir_import'),
                    'notice' => __("3 interval, (days, hours !!Separate by , ) (example: monday, 18:00)",'metrodir_import')
                ),
                'company_soc_openhrs4' => array(
                    'label' => __('Opening Hours 4:','metrodir_import'),
                    'notice' => __("4 interval, (days, hours !!Separate by , ) (example: monday, 18:00)",'metrodir_import')
                )



            )
        );

        $this->meta_options = $this->options_list['metrodir'];

        $this->id = $id;
        $this->name = (isset($GLOBALS['wp_post_types'][$id]->labels->name)) ? $GLOBALS['wp_post_types'][$id]->labels->name : $id;


        $taxonomies = get_object_taxonomies($id);
        foreach ($taxonomies as $tax) {
            // exclude post_format
            if($tax != 'post_format') {
                $this->taxonomies[$tax] = new ImportCat($tax);
            }
        }

    }
}


/*
 *
 *  Categories Type
 *
 */
class ImportCat {

    public $id;
    public $name;
    public $default_options;
    public $meta_options;
    private $options_list;

    public function __construct($id) {

        $this->id = $id;
        $this->name = (isset($GLOBALS['wp_taxonomies'][$id]->labels->name)) ? $GLOBALS['wp_taxonomies'][$id]->labels->name : $id;

        $this->default_options = array(
            'slug' => array(
                'label' => __('Name / Identifier / Slug','metrodir_import'),
                'notice' => __('Name (slug) for identifing category','metrodir_import')
            ),
            'title' => array(
                'label' => __('Title','metrodir_import'),
                'notice' => ''
            ),
            'description' => array(
                'label' => __('Description','metrodir_import'),
                'notice' => ''
            ),
            'parent' => array(
                'label' => __('Parent category','metrodir_import'),
                'notice' => __('Parent category name (slug)','metrodir_import')
            )
        );

        $this->options_list = array(
            'metrodir' => array(
                'metrodir_category' => array(
                    'color' => __('Сolor','metrodir_import'),
                    'icon' => __('Icon','metrodir_import'),
                    'image' => __('Image','metrodir_import')
                )
            )
        );

        $this->meta_options = $this->options_list['metrodir']['metrodir_category'];

    }

}



require_once( metrodir_SKL_plugin . '/import-company/process.php' ); //Process script

add_action( 'init', 'make_instance', 100 );

function make_instance() {
    CompanyImport::get_instance();
}