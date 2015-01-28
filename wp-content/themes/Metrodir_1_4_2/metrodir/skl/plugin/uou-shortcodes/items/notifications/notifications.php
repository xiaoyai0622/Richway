<?php

    // Shortcode for Notifications
	add_shortcode('notification', 'uou_sc_notification');

	function uou_sc_notification($atts, $content = null) {

        // Default Var
		extract(shortcode_atts(array(
			'type' => 'general'
		), $atts));

		$output = '<div class="notification-'.$type.'"><div class="notification-inner">';

		$output .= do_shortcode($content).'</div></div>';
		
		return $output;
		
	}

    // Add Icon
	include('tinyMCE.php');