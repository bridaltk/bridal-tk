<?php
/*
*
*
* Mona Wordpress Core Functions
*
* Author: Rainy <phannhpvu@gmail.com>
* Version: 1.0
* Date: 03-12-2016
* Description: Full version of core functions.  
*
*/


/*
*
* Website Core Image
*
*/
if (!function_exists('mona_get_featured_image_post')){
	function mona_get_featured_image_post( $post_id = false, $size = 'thumbnail', $return_default = true ){
		if( !$post_id )
			$post_id = get_the_ID();
		
		$post_thumbnail_id = get_post_thumbnail_id($post_id);
		
		if( $post_thumbnail_id > 0 ){
			$post_thumbnail_img = mona_get_featured_image( $post_thumbnail_id, $size );
			
			return $post_thumbnail_img;
		}
		
		return ( $return_default ) ? mona_get_featured_image_default( $size ) : false;
	}
}
if (!function_exists('mona_get_featured_image')){
	function mona_get_featured_image( $post_thumbnail_id, $size = 'thumbnail', $return_default = true ){		
		if ( $post_thumbnail_id ){
			$post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, $size);
			return $post_thumbnail_img[0];
		}
		
		return ( $return_default ) ? mona_get_featured_image_default( $size ) : false;
	}
}
if (!function_exists('mona_get_featured_image_default')){
	function mona_get_featured_image_default( $size = 'thumbnail' ) {
		global $mona_theme;
		
		$no_image = (int)( @$mona_theme['no_image'] );
		if( $no_image == 0 ){
			$size = mona_get_image_size( $size );		

			if( $size )
				return 'http://placehold.it/'.$size['width'].'x'.$size['height'];
			else
				return 'http://placehold.it/600x600';
		}else{
			return mona_get_featured_image( $no_image, $size );
		}
	}
}
if (!function_exists('mona_get_image_sizes')){
	function mona_get_image_sizes() {
		global $_wp_additional_image_sizes;

		$sizes = array();

		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
				$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
				$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
				$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes[ $_size ] = array(
					'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
					'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
				);
			}
		}

		return $sizes;
	}
}
if (!function_exists('mona_get_image_size')){
	function mona_get_image_size( $size ) {
		$sizes = mona_get_image_sizes();

		if ( isset( $sizes[ $size ] ) ) {
			return $sizes[ $size ];
		}

		return false;
	}
}



/*
*
* Website Core Taxonomy
*
*/
if (!function_exists('mona_get_current_taxonomy_id')){
	function mona_get_current_taxonomy_id( ){	
		$tax = mona_get_current_taxonomy();
		
		return $tax->term_id;
	}
}
if (!function_exists('mona_get_current_taxonomy_name')){
	function mona_get_current_taxonomy_name( ){	
		$tax = mona_get_current_taxonomy();
		
		return $tax->name;
	}
}
if (!function_exists('mona_get_current_taxonomy_description')){
	function mona_get_current_taxonomy_description( ){	
		$tax = mona_get_current_taxonomy();
		
		return $tax->description;
	}
}
if (!function_exists('mona_get_current_taxonomy_link')){
	function mona_get_current_taxonomy_link( ){	
		$tax = mona_get_current_taxonomy();
		
		return get_term_link( $tax );
	}
}
if (!function_exists('mona_get_current_taxonomy_type')){
	function mona_get_current_taxonomy_type( ){	
		$tax = mona_get_current_taxonomy();
		
		return $tax->taxonomy;
	}
}
if (!function_exists('mona_current_is_taxonomy')){
	function mona_current_is_taxonomy( ){	
		$flag = false;
		$tax = mona_get_current_taxonomy();
		
		if( $tax ){
			$flag = ( is_tax( $tax->taxonomy ) || is_category() || is_tag() );
		}
		
		return $flag;
	}
}
if (!function_exists('mona_get_current_taxonomy')){
	function mona_get_current_taxonomy( ){	
		return get_queried_object();
	}
}



/*
*
* Website Core User
*
*/
if (!function_exists('mona_get_current_user_link')){
	function mona_get_current_user_link( $user_id = false ){ 
		if( !$user_id )
			$user_id = mona_get_current_user_id();
		
		return get_author_posts_url( $user_id, mona_get_current_user_nicename( $user_id ) );
	}
}
if (!function_exists('mona_get_current_user_avatar')){
	function mona_get_current_user_avatar( $user_id = false ){ 
		if( !$user_id )
			$user_id = 	mona_get_current_user_id();
		
		return mona_render_user_avatar( $user_id );
	}
}
if (!function_exists('mona_get_current_user_description')){
	function mona_get_current_user_description( $user_id = false ){ 
		if( !$user_id )
			$user_id = 	mona_get_current_user_id();
		
		return stripcslashes( get_the_author_meta( 'description', $user_id ) );
	}
}
if (!function_exists('mona_get_current_user_login')){
	function mona_get_current_user_login( $user_id = false ){ 
		if( !$user_id )
			$user_id = 	mona_get_current_user_id();
		
		return get_the_author_meta( 'user_login', $user_id );
	}
}
if (!function_exists('mona_get_current_user_nicename')){
	function mona_get_current_user_nicename( $user_id = false ){ 
		if( !$user_id )
			$user_id = 	mona_get_current_user_id();
		
		return get_the_author_meta( 'user_nicename', $user_id );
	}
}
if (!function_exists('mona_get_current_user_display_name')){
	function mona_get_current_user_display_name( $user_id = false ){ 
		if( !$user_id )
			$user_id = 	mona_get_current_user_id();
		
		return get_the_author_meta( 'display_name', $user_id );
	}
}
if (!function_exists('mona_get_current_user_email')){
	function mona_get_current_user_email( $user_id = false ){ 
		if( !$user_id )
			$user_id = 	mona_get_current_user_id();
		
		return get_the_author_meta( 'user_email', $user_id );
	}
}
if (!function_exists('mona_get_current_user_registered')){
	function mona_get_current_user_registered( $user_id = false ){ 
		if( !$user_id )
			$user_id = 	mona_get_current_user_id();
		
		return date( 'H:i d/m/Y', strtotime( get_the_author_meta( 'user_registered', $user_id ) ) );
	}
}
if (!function_exists('mona_get_current_user_id')){
	function mona_get_current_user_id(){ 
		return get_current_user_id();
	}
}
if (!function_exists('mona_render_user_avatar')){
	function mona_render_user_avatar( $user_id ){ 		
		$user_avatar_id = get_user_meta( $user_id, 'wp_user_avatar', true );
		if( $user_avatar_id > 0 ){ 
			return mona_get_featured_image( $user_avatar_id, 'full' );		
		}
		
		return get_avatar_url( $user_id );
	}
}



/*
*
* Website Core Author
*
*/
if (!function_exists('mona_get_current_author_id')){
	function mona_get_current_author_id( ){	
		$au = mona_get_current_author();
		
		return $au->ID;
	}
}
if (!function_exists('mona_get_current_author_name')){
	function mona_get_current_author_name( ){	
		$au = mona_get_current_author();
		
		return $au->display_name;
	}
}
if (!function_exists('mona_get_current_author_description')){
	function mona_get_current_author_description( ){	
		$au = mona_get_current_author();
		
		return $au->description;
	}
}
if (!function_exists('mona_get_current_author')){
	function mona_get_current_author( ){	
		return get_queried_object();
	}
}
// regiter metabox



?>