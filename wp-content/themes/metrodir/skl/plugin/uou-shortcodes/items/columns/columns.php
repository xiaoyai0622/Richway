<?php

    // Shortcode for Column
	add_shortcode('column', 'uou_sc_columns');

	//Our Funciton
	function uou_sc_columns($atts, $content = null) {

        // Default Var
		extract(shortcode_atts(array(
			'type' => 'full'
		), $atts));

		$output = '<div class="text-column column-'.$type.'">';

		$output .= do_shortcode($content).'</div>';
		
		return $output;

	}

    // Add Icon
	include('tinyMCE.php');