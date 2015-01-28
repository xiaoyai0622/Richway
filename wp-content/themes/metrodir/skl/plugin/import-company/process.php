<?php
class CompanyImport {

	/**
	 * Instance of this class.
	 */
	protected static $instance = null;

	/**
	 * Save Empty String
	 */
	protected $save_empty_values = false;

	public $post_types = array();

	private function __construct() {
		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_import_admin_menu' ) );
		$this->post_types = $this->get_theme_custom_types();
	}

	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	*  Add Importer Link In Admin Panel
	*/
	public function add_import_admin_menu() {
		if( is_admin() ) {
			add_menu_page(__('Metrodir CSV Companies Bulk Import', 'metrodircp_localize'),__('Companies Import', 'metrodircp_localize'),'read', 'company-import',array( $this, 'render_importer_page' ));
		}
	}

	/**
	 * Render Page Importer
	 */
	public function render_importer_page() {
		include_once( 'tpl/admin.php' ); //load template
	}

	public function get_theme_custom_types() {
		$post_types_import = array();
        $post_types_import[] = new ImportCompany('company');
		return $post_types_import;
	}

	/**
	 * Importer Company From CSV
	 */
	public function import_csv($type, $file, $duplicate) {

		$encoding_id = intval( get_option( 'import_encoding', '25' ) );
		$encoding_list = mb_list_encodings();
		$encoding = $encoding_list[$encoding_id];
		$header_line = 1;
		$default_options = array();
		$meta_options = array();
		$taxonomies = array();
		$tax_pre = 'tax-';
		$post_type = new ImportCompany($type);
		$num_imported = 0;
		$num_updated = 0;
		$num_ignored = 0;
		$row = 1;
        $delim = get_option('import_delim');
        if(!$delim) {
            $delim = ";";
        }
		if (($handle = fopen($file, "r")) !== FALSE) {
			while (($data_row = fgetcsv($handle, 10000, $delim, '"')) !== FALSE) {
				$ignore = false;
				// MS Office check
				if ($row == 1 && isset($data_row[0]) && trim($data_row[0]) == 'sep=;') {
					$header_line = 2;
				}
				if ($row == $header_line) {
					$cols = count($data_row);
					for ($c=0; $c < $cols; $c++) {
						if (in_array($data_row[$c],array_keys($post_type->default_options))){
							$default_options[$c] = $data_row[$c];
						} elseif (!strncmp($data_row[$c], $tax_pre, strlen($tax_pre))) {
							$taxonomies[$c] = substr($data_row[$c], strlen($tax_pre));
						} else {
							$meta_options[$c] = $data_row[$c];
						}
					}
				}
				if ($row > $header_line) {
					$attrs = array();
					foreach ($default_options as $key => $opt) {
						$attrs[$opt] = ($encoding == 'UTF-8') ? $data_row[$key] : mb_convert_encoding($data_row[$key],'UTF-8',$encoding);
					}
					$attrs['post_type'] = $type;
					if (isset($attrs['post_image'])) {
						$image_slug = $attrs['post_image'];
						unset($attrs['post_image']);
					}
					// check if post existing
					global $wpdb;
					if ($duplicate == '2' || $duplicate == '3') {
						if (isset($attrs['post_name']) && !empty($attrs['post_name'])) {
							$slug = $attrs['post_name'];
							$finded_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '$slug'");
						}
						if (isset($finded_id) && $finded_id) {
							if ($duplicate == '3') {
								// igonre this row
								$num_ignored++;
								$ignore = true;
							}
							$attrs['ID'] = $finded_id;
						}
					}

					if (!$ignore) {
						// parent
						if (isset($attrs['post_parent']) && !empty($attrs['post_parent'])) {
							$parent = $attrs['post_parent'];
							$parent_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '$parent'");
						}
						if (isset($parent_id)) {
							$attrs['post_parent'] = $parent_id;
						}
						// author
						if (isset($attrs['post_author']) && !empty($attrs['post_author'])) {
							$author = get_user_by( 'login', $attrs['post_author'] );
						}
						if (isset($author)) {
							if ($author){
								$attrs['post_author'] = $author->ID;
							} else {
								unset($attrs['post_author']);
							}
						}
						
						// insert or update
						$post_id = wp_insert_post( $attrs, true );

						if ( is_wp_error($post_id) ){
							echo '<div class="error"><p>' . $post_id->get_error_message() . '</p></div>';
						} else {
							// incerment count
							if(isset($finded_id) && $finded_id) {
								$num_updated++;
							} else {
								$num_imported++;
							}
							// set featured image
							if (isset($image_slug) && !empty($image_slug)) {
								$slug = trim($image_slug);
								$finded_image_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '$slug'");
								if (isset($finded_image_id) && $finded_image_id) {
									update_post_meta( $post_id, '_thumbnail_id', $finded_image_id);
								}
							}
							// insert meta
							if(count($meta_options) > 0){
								$meta_key = '_'.$type;
								$meta_attrs = array();
								foreach ($meta_options as $key => $opt) {
									if(!$this->save_empty_values) { 
										if(!empty($data_row[$key])) {
											$meta_attrs[$opt] = ($encoding == 'UTF-8') ? $data_row[$key] : mb_convert_encoding($data_row[$key],'UTF-8',$encoding);
                                            $key_id = 'metro_'.$opt;
                                            update_post_meta( $post_id, $key_id, $meta_attrs[$opt] );
										}
									} else {
										$meta_attrs[$opt] = ($encoding == 'UTF-8') ? $data_row[$key] : mb_convert_encoding($data_row[$key],'UTF-8',$encoding);

									}
								}

							}
							// set terms
							foreach ($taxonomies as $key => $tax) {
								$terms = explode(",",trim($data_row[$key]));
								foreach ($terms as $key_term => $term) {
									$term_id = get_term_by('slug', $term, $tax);
									if ($term_id){
										$result = wp_set_post_terms($post_id, $term_id->term_id, $tax, true);
									}
								}
							}
						}
					}
				}
				$row++;
			}
			fclose($handle);
			echo '<div class="updated"><p>' . $num_imported . __(' items was successfully imported. ','metrodir_import') . $num_updated .  __(' items updated. ','metrodir_import') . $num_ignored . __(' items ignored.','metrodir_import') . 'delimiter' .$delim .'</p></div>';
		}		
	}

	/**
	 * Import categories from CSV file
	 *
	 * @since 1.0.0
	 * 
	 * @param  string $type      taxonomy id
	 * @param  sting $file      url to temp csv file
	 * @param  string $duplicate how to handle duplicate categories
	 * 
	 */
    public function import_terms_csv($type, $file, $duplicate) {

        $encoding_id = intval( get_option( 'import_encoding', '25' ) );
        $encoding_list = mb_list_encodings();
        $encoding = $encoding_list[$encoding_id];

        $header_line = 1;
        $cols = 0;

        $default_options = array();
        $meta_options = array();

        $taxonomy = new ImportCat($type);

        $num_imported = 0;
        $num_updated = 0;
        $num_ignored = 0;

        $ignore = false;
        $row = 1;

        $delim = get_option('import_delim');
        if(!$delim){
            $delim = ";";
        };

        if (($handle = fopen($file, "r")) !== FALSE) {
            while (($data_row = fgetcsv($handle, 10000, $delim, '"')) !== FALSE) {
                $ignore = false;
                // if first line define separator for microsoft office
                if ($row == 1 && isset($data_row[0]) && trim($data_row[0]) == 'sep=;') {
                    $header_line = 2;
                }
                if ($row == $header_line) {
                    $cols = count($data_row);
                    for ($c=0; $c < $cols; $c++) {
                        if (in_array($data_row[$c],array_keys($taxonomy->default_options))){
                            $default_options[$c] = $data_row[$c];
                        } else {
                            $meta_options[$c] = $data_row[$c];
                        }
                    }
                }

                if ($row > $header_line) {
                    // default options
                    $attrs = array();
                    foreach ($default_options as $key => $opt) {
                        $attrs[$opt] = ($encoding == 'UTF-8') ? $data_row[$key] : mb_convert_encoding($data_row[$key],'UTF-8',$encoding);
                    }
                    if ($duplicate == '2' || $duplicate == '3') {
                        // find existing term
                        if (isset($attrs['slug']) && !empty($attrs['slug'])) {
                            $finded_term = get_term_by( 'slug', $attrs['slug'], $type );
                        }
                    }
                    if ($duplicate == '3' && isset($finded_term) && $finded_term) {
                        $num_ignored++;
                    } else {
                        // find parent term
                        if (isset($attrs['parent']) && !empty($attrs['parent'])) {
                            $parent_term = get_term_by( 'slug', $attrs['parent'], $type );
                        }
                        if (isset($parent_term) && $parent_term) {
                            $attrs['parent'] = $parent_term->term_id;
                        }

                        // title
                        if (isset($attrs['title'])) {
                            $title = $attrs['title'];
                            if($duplicate == '2') {
                                $attrs['name'] = $title;
                            }
                        } else {
                            $title = __('Category','metrodir');
                        }

                        $tax = $type;
                        if (isset($finded_term) && $finded_term) {
                            unset($attrs['slug']);
                            $term_id = wp_update_term($finded_term->term_id, $tax, $attrs);
                        } else {
                            $term_id = wp_insert_term($title, $tax, $attrs);
                        }

                        if (is_wp_error($term_id)){
                            echo '<div class="error"><p>' . $term_id->get_error_message() . '</p></div>';
                        } else {
                            if (isset($finded_term) && $finded_term) {
                                $num_updated++;
                            } else {
                                $num_imported++;
                            }
                            // insert meta
                            if(count($meta_options) > 0){
                                if($taxonomy->storage_type = 2) {
                                    foreach ($meta_options as $key => $opt) {
                                        $meta_key = "metrodir_category_" . $term_id['term_id'] . '_' . $opt;
                                        $meta_value = ($encoding == 'UTF-8') ? $data_row[$key] : mb_convert_encoding($data_row[$key],'UTF-8',$encoding);
                                        update_option( $meta_key, $meta_value );
                                    }
                                } else {

                                }
                            }
                        }
                    }
                }
                $row++;
            }
            fclose($handle);
            echo '<div class="updated"><p>' . $num_imported . __(' categories was successfully imported. ','metrodir') . $num_updated .  __(' categories updated. ','metrodir') . $num_ignored . __(' categories ignored.','metrodir') . 'delimiter' .$delim .'</p></div>';
        }

    }

}