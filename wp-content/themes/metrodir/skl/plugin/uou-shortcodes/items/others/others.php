<?php

    // Shortcode for otherss
	add_shortcode('others', 'uou_sc_others');

	function uou_sc_others($atts, $content = null) {

        // Default Var
        extract(shortcode_atts(array(
            'type' => 'general'
        ), $atts));

        if ($type == "ptable") {
            echo '<div class="on-page">';
            get_template_part('/include/html/frame','pricing-plans');
            echo '</div>';
        } else {
            echo "!!!ERROR SHORTCODE!!!";
        }
	}

    // Add Icon
	include('tinyMCE.php');