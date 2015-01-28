<?php

    // Shortcode for Lists
	add_shortcode('list', 'uou_sc_lists');

	//Our Funciton
	function uou_sc_lists($atts, $content = null) {

        // Default Var
		extract(shortcode_atts(array(
			'type' => 'general',
            'title' => ''
		), $atts));

		$output = '<div class="list-title">'.$title.'</div>';

        $output .=  str_replace('<ul', '<ul class="list-'.$type.'"', do_shortcode($content));

		return $output;

	}

    // Add Icon
	include('tinyMCE.php');