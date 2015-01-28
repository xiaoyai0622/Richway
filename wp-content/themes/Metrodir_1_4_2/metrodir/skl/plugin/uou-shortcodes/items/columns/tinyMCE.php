<?php
	add_action('init', 'uou_add_shortcode_sc_columns');
    // Add Button On Editor
	if(!function_exists('uou_add_shortcode_sc_columns')) {
		
		function uou_add_shortcode_sc_columns() {

             add_filter('mce_external_plugins', 'uou_add_shortcode_plugin_sc_columns');
             add_filter('mce_buttons', 'uou_add_shortcode_register_sc_columns');

		}
	
	}

    // Register Button
	if(!function_exists('uou_add_shortcode_register_sc_columns')) {
		
		function uou_add_shortcode_register_sc_columns($buttons) {
			array_push($buttons, '', "sc_columns");
			return $buttons;
		}
	}

    // Register Plugin
	if(!function_exists('uou_add_shortcode_plugin_sc_columns')) {
		
		function uou_add_shortcode_plugin_sc_columns($plugin_array) {
			
			$plugin_array['sc_columns'] = get_template_directory_uri().'/skl/plugin/uou-shortcodes/items/columns/tinyMCE.js';
			return $plugin_array; 
			
		}
	
	}