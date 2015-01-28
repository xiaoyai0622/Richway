<?php

    // Shortcode for Tabs
    add_shortcode('tabs', 'uou_sc_tabs');
    add_shortcode('tab', 'uou_sc_tab');

    function uou_sc_tabs($atts, $content = null) {

        // Default Var
        extract( shortcode_atts( array(
            'id' => rand(100,1000)
        ), $atts ) );

        $scontent = do_shortcode($content);
        $output = '<div class="tabs" id="tabs-'.$id.'"><ul></ul>';
        $output .= $scontent;
        $output .= '</div>';

        $output .= '
        <script type="text/javascript">
            (function($){

                $(function(){

                    var $tabs = $("#tabs-'.$id.'" ),
                        $tabsList = $tabs.find("> ul"),
                        $tabDivs = $tabs.find(".tab.tab-content"),
                        tabsCount = $tabDivs.length;

                    $tabs.find("> p, > br").remove();

                    var tabId = 0;
                    $tabDivs.each(function(){
                        tabId++;
                        var tabName = "tab-'.$id.'-"+tabId;
                        var sharp = "#";
                        $(this).attr("id",tabName);
                        var tabTitle = $(this).data("tab-title");
                        $(\'<li><a class="tab-link" href="\'+sharp+tabName+\'">\'+tabTitle+\'</a></li>\').appendTo($tabsList);
                    });

                    $tabs.tabs();

                    if(typeof Cufon !== "undefined")
                        Cufon.refresh();
                });

            })(jQuery);
        </script>';

        return $output;
    }

    function uou_sc_tab($atts, $content = null) {

        // Default Var
        extract( shortcode_atts( array(
            'title' => 'title'
        ), $atts ) );

        $outputs = '<div id="tabs-content" class="tab tab-content" data-tab-title="'.esc_attr($title).'">'.do_shortcode($content).'</div>';
        return $outputs;

    }

    // Add Icon
	include('tinyMCE.php');