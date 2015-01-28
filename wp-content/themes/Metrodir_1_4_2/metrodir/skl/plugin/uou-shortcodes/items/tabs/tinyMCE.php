<?php
	add_action('init', 'uou_add_shortcode_sc_tabs');
    // Add Button On Editor
	if(!function_exists('uou_add_shortcode_sc_tabs')) {
		
		function uou_add_shortcode_sc_tabs() {

             add_filter('mce_external_plugins', 'uou_add_shortcode_plugin_sc_tabs');
             add_filter('mce_buttons', 'uou_add_shortcode_register_sc_tabs');

		}
	
	}

    // Register Button
	if(!function_exists('uou_add_shortcode_register_sc_tabs')) {
		
		function uou_add_shortcode_register_sc_tabs($buttons) {
			array_push($buttons, '', "sc_tabs");
			return $buttons;
		}
	
	}

    // Register Plugin
	if(!function_exists('uou_add_shortcode_plugin_sc_tabs')) {
		
		function uou_add_shortcode_plugin_sc_tabs($plugin_array) {
			
			$plugin_array['sc_tabs'] = get_template_directory_uri().'/skl/plugin/uou-shortcodes/items/tabs/tinyMCE.js';
			return $plugin_array; 
			
		}
	
	}