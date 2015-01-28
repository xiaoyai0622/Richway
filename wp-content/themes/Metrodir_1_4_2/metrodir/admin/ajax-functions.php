<?php
function tags_search() {
	global $wpdb;
	
	$nonce = $_POST['ajaxNounce'];
	$salt = $_POST['salt'];
	
	if ( ! check_ajax_referer( 'search-ajax-nonce-'.$salt, 'ajaxNounce', false ) )
		die ( 'Invalid Ajax Call');

	if (strlen($_POST['q'])>2) {
		$limit=10;
		$s= strtolower(addslashes(mysql_real_escape_string($_POST["q"])));

		$arr = array();
		
		$tags = get_tags(array('search' => $s, 'hide_empty' => false));
		foreach ( $tags as $tag ) {
			$arr[] = array('id' => $tag->slug, 'name' => $tag->name);
		}
		
		# JSON-encode the response
		$json_response = json_encode($arr);

		# Optionally: Wrap the response in a callback function for JSONP cross-domain support
		if($_GET["callback"]) {
			$json_response = $_GET["callback"] . "(" . $json_response . ")";
		}
		
		header( "Content-Type: application/json" );

		# Return the response
		echo $json_response;

	}
	else echo '';
	exit;
}

function post_search() {
	global $wpdb;
	
	$nonce = $_POST['ajaxNounce'];
	$salt = $_POST['salt'];
	
	if ( ! check_ajax_referer( 'search-ajax-nonce-'.$salt, 'ajaxNounce', false ) )
		die ( 'Invalid Ajax Call');

	if (strlen($_POST['q'])>2) {
		$limit=10;
		$s= strtolower(addslashes(mysql_real_escape_string($_POST["q"])));
		$t= strtolower(addslashes(mysql_real_escape_string($_POST["t"])));
		
		if(!isset($t) || empty($t)){
			$t = 'post';
		}
		
		$arr = array();
		
		$querystr = "
			SELECT wposts.ID, wposts.post_title
			FROM $wpdb->posts wposts
			WHERE wposts.post_title like '%{$s}%'
			AND wposts.post_type = '{$t}'
			GROUP BY wposts.ID
			ORDER BY wposts.post_date DESC
		";

		$fields = $wpdb->get_results($querystr, ARRAY_N);
		
		foreach ($fields as $field) {
			$arr[] = array('id' => $field[0], 'name' => $field[1]);
		}
		
		# JSON-encode the response
		$json_response = json_encode($arr);

		# Optionally: Wrap the response in a callback function for JSONP cross-domain support
		if($_GET["callback"]) {
			$json_response = $_GET["callback"] . "(" . $json_response . ")";
		}
		
		header( "Content-Type: application/json" );

		# Return the response
		echo $json_response;

	}
	else echo '';
	exit;
}

function post_search_interface(){
	include('admin-select-post-type-modal.php');
	die();
}

function list_post_items(){
	global $wpdb, $wp_query;
	
	$post_type = $_REQUEST['post_type'];
	
	$search = '';
	if(isset($_REQUEST["search"]) && !empty($_REQUEST["search"])){
		$search = trim($_REQUEST["search"]);
	}

    $args = array(
        'post_type'   => $post_type,
        'post_status' => (($post_type == 'attachment')?'inherit':'publish'),
		'suppress_filters' => 1,
		's' => $search,
    );
	
	if(isset($_GET['jtSorting'])){
		$parts = explode(' ', $_GET["jtSorting"]);
		$args['orderby'] = $parts[0];
		$args['order'] = $parts[1];
	}
	if(isset($_GET['jtStartIndex']) && isset($_GET['jtPageSize'])){
		$args['offset'] = $_GET["jtStartIndex"];
		$args['posts_per_page'] = $_GET["jtPageSize"];
	}
	$temp = $wp_query;
	$wp_query = null;
	
	$wp_query = new WP_Query($args);
	
	$rows = array();
	if ( $wp_query->have_posts() ):
	while ( $wp_query->have_posts() ) : $wp_query->the_post();
		$attachment_id = get_post_thumbnail_id(get_the_ID());
		$image_url = vt_resize($attachment_id, null, 150, 150);
		$rows[] = array('ID' => get_the_ID(), 'post_title' => get_the_title(), 'thumb' => $image_url, 'attachment_id' => $attachment_id);
	endwhile;
	endif;
	wp_reset_postdata();
	
	$wp_query = $temp;
	
	$numposts = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = '{$post_type}' AND post_status = 'publish'");
	if (0 < $numposts) $numposts = number_format($numposts); 
	
	//Return result to jTable
	$jTableResult = array();
	$jTableResult['Result'] = "OK";
	$jTableResult['TotalRecordCount'] = $numposts;
	$jTableResult['Records'] = $rows;
	echo json_encode($jTableResult);
	die();
}

function list_users(){	
	$search = '';
	if(isset($_REQUEST["search"]) && !empty($_REQUEST["search"])){
		$search = trim($_REQUEST["search"].'*');
	}
	
    $args = array(
		'search' => $search,
		'count_total' => 1,
    );
	
	if(isset($_GET['jtSorting'])){
		$parts = explode(' ', $_GET["jtSorting"]);
		$args['orderby'] = $parts[0];
		$args['order'] = $parts[1];
	}
	if(isset($_GET['jtStartIndex']) && isset($_GET['jtPageSize'])){
		$args['offset'] = $_GET["jtStartIndex"];
		$args['number'] = $_GET["jtPageSize"];
	}
	$blogusers = get_users($args);
	
	$rows = array();
	foreach ($blogusers as $user) {
		$rows[] = array('ID' => $user->ID, 'post_title' => $user->display_name, 'thumb' => ajax_get_avatar_url(get_avatar( $user->ID, 150 )));
    }
	
	$result = count_users();
	$numposts = $result['total_users'];
	
	//Return result to jTable
	$jTableResult = array();
	$jTableResult['Result'] = "OK";
	$jTableResult['TotalRecordCount'] = $numposts;
	$jTableResult['Records'] = $rows;
	echo json_encode($jTableResult);
	die();
}

function ajax_get_avatar_url($get_avatar){
    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
    return $matches[1];
}

add_action( 'wp_ajax_tags_search', 'tags_search' );
add_action( 'wp_ajax_nopriv_tags_search', 'tags_search' );

add_action( 'wp_ajax_post_search_interface', 'post_search_interface' );
add_action( 'wp_ajax_post_search', 'post_search' );
add_action( 'wp_ajax_list_post_items', 'list_post_items' );
add_action( 'wp_ajax_list_users', 'list_users' );
/* add_action( 'wp_ajax_nopriv_post_search', 'post_search' ); */

