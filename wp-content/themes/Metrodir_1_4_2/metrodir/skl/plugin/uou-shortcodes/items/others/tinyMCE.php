<?php
	add_action('init', 'uou_add_shortcode_sc_others');
    // Add Button On Editor
	if(!function_exists('uou_add_shortcode_sc_others')) {
		
		function uou_add_shortcode_sc_others() {

             add_filter('mce_external_plugins', 'uou_add_shortcode_plugin_sc_others');
             add_filter('mce_buttons', 'uou_add_shortcode_register_sc_others');

		}
	
	}

    // Register Button
	if(!function_exists('uou_add_shortcode_register_sc_others')) {
		
		function uou_add_shortcode_register_sc_others($buttons) {
			array_push($buttons, '', "sc_others");
			return $buttons;
		}
	}

    // Register Plugin
	if(!function_exists('uou_add_shortcode_plugin_sc_others')) {
		
		function uou_add_shortcode_plugin_sc_others($plugin_array) {
			
			$plugin_array['sc_others'] = get_template_directory_uri().'/skl/plugin/uou-shortcodes/items/others/tinyMCE.js';
			return $plugin_array; 
			
		}
	
	}