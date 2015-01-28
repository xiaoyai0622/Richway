<?php
	add_action('init', 'uou_add_shortcode_sc_lists');
    // Add Button On Editor
	if(!function_exists('uou_add_shortcode_sc_lists')) {
		
		function uou_add_shortcode_sc_lists() {

             add_filter('mce_external_plugins', 'uou_add_shortcode_plugin_sc_lists');
             add_filter('mce_buttons', 'uou_add_shortcode_register_sc_lists');
			
        }

	}

    // Register Button
	if(!function_exists('uou_add_shortcode_register_sc_lists')) {
		
		function uou_add_shortcode_register_sc_lists($buttons) {
			array_push($buttons, '', "sc_lists");
			return $buttons;
		}
	}

    // Register Plugin
	if(!function_exists('uou_add_shortcode_plugin_sc_lists')) {
		
		function uou_add_shortcode_plugin_sc_lists($plugin_array) {
			
			$plugin_array['sc_lists'] = get_template_directory_uri().'/skl/plugin/uou-shortcodes/items/lists/tinyMCE.js';
			return $plugin_array; 
			
		}
	
	}