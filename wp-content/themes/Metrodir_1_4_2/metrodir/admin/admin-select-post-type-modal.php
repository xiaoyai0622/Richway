<?php

require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/wp-blog-header.php');

if ( ! isset( $_REQUEST['inline'] ) )
	define( 'IFRAME_REQUEST' , true );

if (!current_user_can('edit_posts'))
	wp_die(__('You do not have permission to edit posts.', 'metrodir'));

$post_type = $_REQUEST['post_type'];
$field_id = $_REQUEST['field_id'];
$post_id = $_REQUEST['post_id'];

function metrodir_modal_scripts(){
$post_type = $_REQUEST['post_type'];
$field_id = $_REQUEST['field_id'];
$post_id = $_REQUEST['post_id'];

wp_enqueue_style( 'jtable',get_template_directory_uri().'/admin/js/jtable/themes/metro/blue/jtable.css' );

wp_enqueue_script('jquery');
wp_enqueue_script('jquery-ui-core');
wp_enqueue_script('jquery-ui-tabs');
wp_enqueue_script('jquery-ui-widget');
wp_enqueue_script('jquery-ui-dialog');
wp_enqueue_script('metrodir_panel_script', get_template_directory_uri().'/admin/js/jtable/jquery.jtable.min.js', array('jquery'), null, true);

$salt = substr(str_shuffle(MD5(microtime())), 0,12);

switch($post_type){
case 'user':
	$ajaxurl = add_query_arg(
		array(
			'action' => 'list_users',
			'post_id' => $post_id,
			'post_type' => $post_type
		),
		admin_url( 'admin-ajax.php' )
	);
	break;
default:
	$ajaxurl = add_query_arg(
		array(
			'action' => 'list_post_items',
			'post_id' => $post_id,
			'post_type' => $post_type
		),
		admin_url( 'admin-ajax.php' )
	);
}

// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
if (isset($list_users))  wp_localize_script( 'metrodir_panel_script', 'ajaxHandler', array( 'ajaxurl' => $ajaxurl, 'list_users' => $list_users, 'ajaxNounce' => wp_create_nonce( 'search-ajax-nonce-'.$salt ), 'salt' => $salt, 'post_type' => $post_type ) );
else wp_localize_script( 'metrodir_panel_script', 'ajaxHandler', array( 'ajaxurl' => $ajaxurl, 'ajaxNounce' => wp_create_nonce( 'search-ajax-nonce-'.$salt ), 'salt' => $salt, 'post_type' => $post_type ) );
}
add_action('wp_enqueue_scripts', 'metrodir_modal_scripts');
?>
<!DOCTYPE html>
<html>
<head>
<?php wp_head();?>
<style>
.jtable-search{
	background-color: #127AED;
	padding-left: 10px;
}
.jtable-search label{
	color: white;
}
</style>
</head>
<body>
<?php
$obj = get_post_type_object( $post_type );
if(isset($obj->labels->name)) $type_name = $obj->labels->name;

$image_urls = array();

$meta = get_post_meta($_REQUEST['post_id'], $_REQUEST['field_id'], true);
$meta = json_decode(htmlspecialchars_decode($meta));
if(isset($meta) && !empty($meta))
foreach($meta as $single_image):
$thumb_id = $single_image;
$title = get_the_title($single_image);
if($post_type != 'attachment'):
	$thumb_id = get_post_thumbnail_id($single_image);
endif;

if($this_image = wp_get_attachment_image_src($thumb_id)) :
$image_url = vt_resizer($this_image[0], 150, 150);
$image_urls[$single_image] = array('i' => $image_url, 't' => get_the_title($single_image));
endif;
endforeach;

?>
<script type="text/javascript">
function executeFunctionByName(functionName, context /*, args */) {
  var args = Array.prototype.slice.call(arguments).splice(2);
  var namespaces = functionName.split(".");
  var func = namespaces.pop();
  for(var i = 0; i < namespaces.length; i++) {
    context = context[namespaces[i]];
  }
  return context[func].apply(this, args);
}
var selected = [];
var thumbs = [];
var visibleRows = [];
console.info(<?php echo json_encode($image_urls);?>);
var image_urls = <?php echo json_encode($image_urls);?>;
jQuery(document).ready(function(){
	<?php if(isset($_REQUEST['curr_callback']) && !empty($_REQUEST['curr_callback'])){?>
	var current_callback = "<?php echo $_REQUEST['curr_callback'];?>";
	selected = executeFunctionByName(current_callback, window.parent, '<?php echo $field_id; ?>');
	<?php } ?>

	jQuery("#TB_closeWindowButton", window.parent.document).click(function() {
		<?php if(isset($_REQUEST['update_callback']) && !empty($_REQUEST['update_callback'])){?>
		var update_callback = "<?php echo $_REQUEST['update_callback'];?>";
		executeFunctionByName(update_callback, window.parent, selected, '<?php echo $field_id; ?>');
		<?php } ?>
		<?php if(isset($_REQUEST['items_callback']) && !empty($_REQUEST['items_callback'])){?>
		var items_callback = "<?php echo $_REQUEST['items_callback'];?>";
		console.info(selected);
		console.info(image_urls);
		for(var i in selected){
			console.info(i, image_urls[selected[i]]);
			var obj = {'id': selected[i], 'post_type': '<?php echo $post_type; ?>', 'thumb': image_urls[selected[i]].i, 'title': image_urls[selected[i]].t};

			executeFunctionByName(items_callback, window.parent, obj, '<?php echo $field_id; ?>');
		}
		<?php } ?>
	});

	var canCheck = false;

	//Prepare jTable
	jQuery('#resultsContainer').jtable({
		title: false,
		paging: true, //Enable paging
		sorting: true, //Enable sorting
		selecting: true, //Enable sorting
		columnResizable: false, //Disable column resizing
		columnSelectable: false, //Disable column selecting
		defaultSorting: 'id DESC',
		multiselect : true,
		selectingCheckboxes: true,
		actions: {
			listAction: ajaxHandler.ajaxurl
		},
		fields: {
			ID: {
				key: true,
				list: false
			},
			thumb: {
				title: 'Thumb',
				width: '10%',
				sorting : false,
				display: function(data){
					return '<img src="'+data.record.thumb+'" width="50" height="50"/>';
				}
			}
			,
			post_title: {
				title: 'Title',
				width: '90%'
			},
			attachment_id: {
				list: false
			}
		},
		loadingRecords: function(event, data){
			canCheck = false;
			updateSelection();
		},
		recordsLoaded: function(event, data){
			canCheck = false;
			visibleRows.length = 0;
			for(var i in data.records){
				visibleRows.push(data.records[i].ID);
			}

			var to_select = jQuery.grep(selected, function(n, i){
			  return jQuery.inArray(n, visibleRows) > -1;
			});

			if(selected.length > 0){
				var rows_to_select = [];
				for(var i in to_select){
					$row = jQuery('#resultsContainer').jtable('getRowByKey', to_select[i]);
					$row.addClass('jtable-row-selected');
					$row.find('td.jtable-selecting-column input').attr('checked', true);
				}
			}
			updateSelection();
			canCheck = true;
		},
		selectionChanged:function(event, data){
			if(!canCheck) return;
			updateSelection();
		}
	});

	function getCurrentSelectedRowsInTable(){
		var $selectedRows = jQuery('#resultsContainer').jtable('selectedRows');
		var tableSelection = [];
		$selectedRows.each(function () {
			var record = jQuery(this).data('record');
			image_urls[record.ID] = {i: record.thumb, t: record.post_title};
			tableSelection.push(record.ID);
		});
		return tableSelection;
	}

	function updateSelection(){
		var tableSelection = getCurrentSelectedRowsInTable();
		var safe_selected = jQuery.grep(selected, function(n, i){
		  return jQuery.inArray(n, visibleRows) == -1;
		});

		selected = safe_selected.concat(tableSelection);
	}

	 //Re-load records when user click 'load records' button.
        jQuery('#LoadRecordsButton').click(function (e) {
            e.preventDefault();
            jQuery('#resultsContainer').jtable('load', {
                search: jQuery('#search').val()
            });
        });

	//Load person list from server
	jQuery('#resultsContainer').jtable('load');

	jQuery('#selectItems').click(function (e) {
		e.preventDefault();
		closeWindow();
	});

	function closeWindow(){
		jQuery("#TB_closeWindowButton", window.parent.document)[0].click();
	}
});

</script>
<div class="jtable-main-container">
<div class="jtable-title" style="display: inline-block; width:100%; padding: 0px;"><div class="jtable-title-text" style="float: left; display: inline-block; padding: 0px; margin-left: 10px;"><?php if (isset($type_name)) echo 'Select '.$type_name;?></div>
<div class="jtable-title-text" style="float: right; display: inline-block; margin-right: 10px;">
<form>
	<label for="search">Filter:</label> <input type="text" name="search" id="search" />
	<button type="submit" id="LoadRecordsButton">Filter</button>
</form></div></div></div>
<div id="resultsContainer" style="width: 100%; clear:both;"></div>
<div class="jtable-main-container">
<div class="jtable-title" style="display: inline-block; width:100%; padding: 0px;">
<div class="jtable-title-text" style="float: right; display: inline-block; margin-right: 10px;">
<form>
	<button type="submit" id="selectItems">Select</button>
</form></div></div></div>
<?php wp_footer(); ?>
</body>
</html>