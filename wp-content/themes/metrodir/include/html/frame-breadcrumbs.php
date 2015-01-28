<?php
/*
*  Metrodir breadcrumbs
*/
function uou_breadcrumbs(){

    global $rtl;

    if ($rtl) {
        $sep = ' <i class="fa fa-chevron-left"></i> '; //section sep for rtl
    } else {
        $sep = ' <i class="fa fa-chevron-right"></i> '; //section sep
    }

    $sep_term = '<span>, </span>';

    $title = get_the_title();
    $home_url = home_url();
    $home_text = __('Home', 'metrodir');
    $text_404 = __('Error 404', 'metrodir');

    $before = ''; // Before container
    $after = ''; // After container

    $before_link = '<span>'; // Before all link section
    $after_link = '</span>'; // After all link section

    $link_attr = ''; // for empty - ''

    if ($link_attr) $link_attr = ' '.$link_attr.' '; // add spaces to link attrs

    $home_link = '<a href="'.$home_url.'"'.$link_attr.'>'.$home_text.'</a>'; // Create home URL link

    if ($rtl) {
        $home = $after_link.$sep.$home_link.$before_link; // Create Block home URL link
    } else {
        $home = $before_link.$home_link.$sep.$after_link; // Create Block home URL link
    }


    // Get categories section
    if (!(isset($post))) global $post;
    if (!(isset($terms))) $terms = get_the_terms( $post->ID, 'company_category' );

    if ($terms) {
        $i=0;
        $term_section = '';
        foreach ($terms as $term ) {
            $i++;
            $term_link = '<a href="'.get_term_link(intval($term->term_id), 'company_category').'" title="'.$term->name.'"'.$link_attr.'>'.$term->name.'</a>';
            if ($i == 1) $term_section = $term_link; else $term_section .= $sep_term.$term_link;
        }
        if ($term_section) {
            if ($rtl) {
                $term = $after_link.$sep.$term_section.$before_link;
            } else {
                $term = $before_link.$term_section.$sep.$after_link;
            }
        }
    } else if ( is_404() ) {
        $title = $text_404;
    } else if ( is_single() ) {
        $term_list = get_the_category_list( ', ' );
        if ($term_list) {
            if ($rtl) {
                $term = $after_link.$sep.$term_list.$before_link;
            } else {
                $term = $before_link.$term_list.$sep.$after_link;
            }
        }
    } else if ( is_author() ){
        $title = get_the_author();
    } else if( is_year() || is_month() || is_day() ){
        $y_link = get_the_time('Y');
        $m_link = get_the_time('F');
        $d_link = get_the_time('d');
        if( is_year() ) {
            $title = $y_link;
        } else if( is_month() ) {
            $title = $m_link;
            $year_url = '<a href="'.get_year_link( $year=get_the_time('Y') ).'"'.$link_attr.'>'.$y_link.'</a>';
            if ($rtl) {
                $term = $after_link.$sep.$year_url.$before_link;
            } else {
                $term = $before_link.$year_url.$sep.$after_link;
            }
        } else if ( is_day() ) {
            $title = $d_link;
            $year_url = '<a href="'.get_year_link( $year=get_the_time('Y') ).'"'.$link_attr.'>'.$y_link.'</a>';
            $mont_url = '<a href="'.get_month_link( $year, get_the_time('m') ).'"'.$link_attr.'>'.$m_link.'</a>';
            if ($rtl) {
                $term = $after_link.$sep.$mont_url.$before_link.$after_link.$sep.$year_url.$before_link;
            } else {
                $term = $before_link.$year_url.$sep.$after_link.$before_link.$mont_url.$sep.$after_link;
            }
        }
    } else if ( single_term_title('',false) ) {
            $title = single_term_title('',false);
    }

    wp_reset_postdata();

    if ($rtl) {
        if (isset($term))
            return print $after.$title.$term.$home.$before;
        else
            return print $after.$title.$home.$before;
    } else {
        if (isset($term))
            return print $before.$home.$term.$title.$after;
        else
            return print $before.$home.$title.$after;
    }

}

?>

<!-- Breadcrumbs --><div id="breadcrumbs"><div class="box-container">

    <div class="breadcrumbs-page-title"><h1><?php wp_title("", true); ?></h1></div>
    <div class="breadcrumbs"><?php uou_breadcrumbs(); ?></div>

</div></div><!-- Breadcrumbs -->