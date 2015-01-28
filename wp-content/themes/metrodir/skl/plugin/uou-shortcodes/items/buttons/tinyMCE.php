<?php
	add_action('init', 'uou_add_shortcode_sc_buttons');
	// Add Button On Editor
	if(!function_exists('uou_add_shortcode_sc_buttons')) {

		function uou_add_shortcode_sc_buttons() {

             add_filter('mce_external_plugins', 'uou_add_shortcode_plugin_sc_buttons');
             add_filter('mce_buttons', 'uou_add_shortcode_register_sc_buttons');

		}

	}

	// Register Button
	if(!function_exists('uou_add_shortcode_register_sc_buttons')) {

		function uou_add_shortcode_register_sc_buttons($buttons) {
			array_push($buttons, '|', "sc_buttons");
			return $buttons;
		}
	}

	// Register Plugin
	if(!function_exists('uou_add_shortcode_plugin_sc_buttons')) {

		function uou_add_shortcode_plugin_sc_buttons($plugin_array) {

			$plugin_array['sc_buttons'] = get_template_directory_uri().'/skl/plugin/uou-shortcodes/items/buttons/tinyMCE.js';
			return $plugin_array;

		}

	}