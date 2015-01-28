<?php
	add_action('init', 'uou_add_shortcode_sc_notifications');
    // Add Button On Editor
	if(!function_exists('uou_add_shortcode_sc_notifications')) {
		
		function uou_add_shortcode_sc_notifications() {

             add_filter('mce_external_plugins', 'uou_add_shortcode_plugin_sc_notifications');
             add_filter('mce_buttons', 'uou_add_shortcode_register_sc_notifications');

		}
	
	}

    // Register Button
	if(!function_exists('uou_add_shortcode_register_sc_notifications')) {
		
		function uou_add_shortcode_register_sc_notifications($buttons) {
			array_push($buttons, '', "sc_notifications");
			return $buttons;
		}
	}

    // Register Plugin
	if(!function_exists('uou_add_shortcode_plugin_sc_notifications')) {
		
		function uou_add_shortcode_plugin_sc_notifications($plugin_array) {
			
			$plugin_array['sc_notifications'] = get_template_directory_uri().'/skl/plugin/uou-shortcodes/items/notifications/tinyMCE.js';
			return $plugin_array; 
			
		}
	
	}