<?php
/*
 * Resize images dynamically using wp built in functions
 * Victor Teixeira
 *
 * php 5.2+
 *
 * Exemplo de uso:
 * 
 * <?php 
 * $thumb = get_post_thumbnail_id(); 
 * $image = vt_resize( $thumb, '', 140, 110, true );
 * ?>
 * <img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" />
 *
 * @param int $attach_id
 * @param string $img_url
 * @param int $width
 * @param int $height
 * @param bool $crop
 * @return array
 */
if ( !function_exists( 'vt_resize') ) {
	
	function vt_resize( $attach_id = null, $url = null, $width = 0, $height = null, $crop = null, $single = true ) {
		
		if ( $attach_id != null ) {
 
			$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
			$url = $image_src[0];
 
			// this is not an attachment, let's use the image url
		}
		
		//validate inputs
		if(!$url OR !$width ) return get_template_directory_uri().'/images/no_image.jpg';
		
		//define upload path & dir
		$upload_info = wp_upload_dir();
		$upload_dir = $upload_info['basedir'];
		$upload_url = $upload_info['baseurl'];
		
		//check if $img_url is local
		if(strpos( $url, home_url() ) === false) return false;
		
		//define path of image
		$rel_path = str_replace( $upload_url, '', $url);
		$img_path = $upload_dir . $rel_path;
		
		//check if img path exists, and is an image indeed
		if( !file_exists($img_path) OR (file_exists($img_path) && !getimagesize($img_path)) ){
			$g_upload_dir = dirname($upload_info['basedir']).'/gallery';
			$g_upload_url = dirname($upload_info['baseurl']).'/gallery';
			
			//define path of image
			$g_rel_path = str_replace( $g_upload_url, '', $url);
			$g_img_path = $g_upload_dir . $g_rel_path;
		
			if( !file_exists($g_img_path) OR (file_exists($g_img_path) && !getimagesize($g_img_path)) ){
				return false;
			}else{
				$upload_dir = $g_upload_dir;
				$upload_url = $g_upload_url;
				$img_path = $g_img_path;
				$rel_path = $g_rel_path;
			}
		}
		
		//get image info
		$info = pathinfo($img_path);
		$ext = $info['extension'];
		list($orig_w,$orig_h) = getimagesize($img_path);
		
		//get image size after cropping
		$dims = image_resize_dimensions($orig_w, $orig_h, $width, $height, $crop);
		$dst_w = $dims[4];
		$dst_h = $dims[5];
		
		//use this to check if cropped image already exists, so we can return that instead
		$suffix = "{$dst_w}x{$dst_h}";
		$dst_rel_path = str_replace( '.'.$ext, '', $rel_path);
		$destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";
		
		//if orig size is smaller
		if($width >= $orig_w) {
			
			if(!$dst_h) :
				//can't resize, so return original url
				$img_url = $url;
				$dst_w = $orig_w;
				$dst_h = $orig_h;
				
			else :
				//else check if cache exists
				if(file_exists($destfilename) && getimagesize($destfilename)) {
					$img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
				} 
				//else resize and return the new resized image url
				else {
					$resized_img_path = image_resize( $img_path, $width, $height, $crop );
					$resized_rel_path = str_replace( $upload_dir, '', $resized_img_path);
					$img_url = $upload_url . $resized_rel_path;
				}
				
			endif;
			
		}
		//else check if cache exists
		elseif(file_exists($destfilename) && getimagesize($destfilename)) {
			$img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
		} 
		//else, we resize the image and return the new resized image url
		else {
			$resized_img_path = image_resize( $img_path, $width, $height, $crop );
			$resized_rel_path = str_replace( $upload_dir, '', $resized_img_path);
			$img_url = $upload_url . $resized_rel_path;
		}
		
		//return the output
		if($single) {
			//str return
			$image = $img_url;
		} else {
			//array return
			$image = array (
				0 => $img_url,
				1 => $dst_w,
				2 => $dst_h
			);
		}
		
		return $image;
	}
}
