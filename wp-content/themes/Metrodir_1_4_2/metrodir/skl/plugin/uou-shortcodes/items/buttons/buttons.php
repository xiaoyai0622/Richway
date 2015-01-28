<?php

	// Shortcode for Button
	add_shortcode('button', 'uou_sc_button');

	function uou_sc_button($atts, $content = null) {

		// Default Var
		extract(shortcode_atts(array(
		    'link' => '#',
			'color' => 'default',
			'type' => '',
			'target' => '',
		), $atts));

		$output = '<a href="'.$link.'" class="button-'.$class.'';

        // Set Color
	    $output .= $color.'"';

		// Set Target
		if($target != '') { $output .= ' target="'.$target.'"'; }

        // Close Tag
        $output .= '>';

        // Add Icon
        $output .= '<i class="fa fa-arrow-circle-right"></i>';

        // Set Text
	    $output .= $content.'</a>';


		// Print Button
		return $output;

	}

	// Add Icon
	include('tinyMCE.php');