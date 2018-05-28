<?php

function mona_clear_head() {
    // category feeds
    // remove_action( 'wp_head', 'feed_links_extra', 3 );
    // post and comment feeds
    // remove_action( 'wp_head', 'feed_links', 2 );
    // EditURI link
    remove_action('wp_head', 'rsd_link');
    // windows live writer
    remove_action('wp_head', 'wlwmanifest_link');
    // previous link
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    // start link
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    // links for adjacent posts
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    // WP version
    remove_action('wp_head', 'wp_generator');
    // remove WP version from css
    add_filter('style_loader_src', 'mona_remove_wp_ver_css_js', 9999);
    // remove Wp version from scripts
    add_filter('script_loader_src', 'mona_remove_wp_ver_css_js', 9999);
}

/* end bones head cleanup */

// A better title
// http://www.deluxeblogtips.com/2012/03/better-title-meta-tag.html
function rw_title($title, $sep, $seplocation) {
    global $page, $paged;

    // Don't affect in feeds.
    if (is_feed())
        return $title;

    // Add the blog's name
    if ('right' == $seplocation) {
        $title .= get_bloginfo('name');
    } else {
        $title = get_bloginfo('name') . $title;
    }

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo('description', 'display');

    if ($site_description && ( is_home() || is_front_page() )) {
        $title .= " {$sep} {$site_description}";
    }

    // Add a page number if necessary:
    if ($paged >= 2 || $page >= 2) {
        $title .= " {$sep} " . sprintf(__('Page %s', 'dbt'), max($paged, $page));
    }

    return $title;
}

// end better title
// remove WP version from RSS
function mona_rss_version() {
    return '';
}

// remove WP version from scripts
function mona_remove_wp_ver_css_js($src) {
    if (strpos($src, 'ver='))
        $src = remove_query_arg('ver', $src);
    return $src;
}

// remove injected CSS for recent comments widget
function mona_remove_wp_widget_recent_comments_style() {
    if (has_filter('wp_head', 'wp_widget_recent_comments_style')) {
        remove_filter('wp_head', 'wp_widget_recent_comments_style');
    }
}

// remove injected CSS from recent comments widget
function mona_remove_recent_comments_style() {
    global $wp_widget_factory;
    if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
        remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
    }
}


/* * *******************
  THEME SUPPORT
 * ******************* */

// Adding WP 3+ Functions & Theme Support
function mona_theme_support() {

    // wp thumbnails (sizes handled in functions.php)
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 400,
        'flex-height' => true,
        'flex-width' => true,
        'header-text' => array('site-title', 'site-description'),
    ));

    // rss thingy
    add_theme_support('automatic-feed-links');

    // to add header image support go here: http://themble.com/support/adding-header-background-image-support/
   

    // wp menus
    add_theme_support('menus');

    // registering wp3+ menus
    register_nav_menus(
            array(
                'primary-menu' => __('Theme Main Menu', 'monamedia'), 
                'footer-menu' => __('Theme Footer Menu', 'monamedia'), 
                'top-menu' => __('Theme Top Menu', 'monamedia'), 
            )
    );

    // Enable support for HTML5 markup.
    add_theme_support('html5', array(
        'comment-list',
        'search-form',
        'comment-form'
    ));
    
}

/* end bones theme support */


/* * *******************
  RELATED POSTS FUNCTION
 * ******************* */

// Related Posts Function (call using mona_related_posts(); )
function mona_related_posts() {
    echo '<ul id="bones-related-posts">';
    global $post;
    $tags = wp_get_post_tags($post->ID);
    if ($tags) {
        foreach ($tags as $tag) {
            $tag_arr .= $tag->slug . ',';
        }
        $args = array(
            'tag' => $tag_arr,
            'numberposts' => 5, /* you can change this to show more */
            'post__not_in' => array($post->ID)
        );
        $related_posts = get_posts($args);
        if ($related_posts) {
            foreach ($related_posts as $post) : setup_postdata($post);
                ?>
                <li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
                <?php
            endforeach;
        }
        else {
            ?>
            <?php echo '<li class="no_related_post">' . __('No Related Posts Yet!', 'monamedia') . '</li>'; ?>
            <?php
        }
    }
    wp_reset_postdata();
    echo '</ul>';
}

/* end bones related posts function */

/* * *******************
  PAGE NAVI
 * ******************* */

// Numeric Page Navi (built into the theme by default)
function mona_page_navi($wp_query='') {
	if($wp_query==''){
	global $wp_query;	
	}
    
    $bignum = 999999999;
    if ($wp_query->max_num_pages <= 1)
        return;
    echo '<nav class="pagination">';
    echo paginate_links(array(
        'base' => str_replace($bignum, '%#%', esc_url(get_pagenum_link($bignum))),
        'format' => '',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'prev_text' => '&larr;',
        'next_text' => '&rarr;',
        'type' => 'list',
        'end_size' => 3,
        'mid_size' => 3
    ));
    echo '</nav>';
}
function mona_page_navi_qr_sring($wp_query='') {
	if($wp_query==''){
	global $wp_query;	
	}
    
    $bignum = 999999999;
    if ($wp_query->max_num_pages <= 1)
        return;
    echo '<nav class="pagination">';
    echo paginate_links(array(
        'base' => get_the_permalink().'/page/%#%/',
        'format' => '',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'prev_text' => '&larr;',
        'next_text' => '&rarr;',
        'type' => 'list',
        'end_size' => 3,
        'mid_size' => 3
    ));
    echo '</nav>';
}
function mona_page_navi_sql($current,$max) {
    $bignum = 999999999;
    if ($max <= 1)
        return;
    echo '<nav class="pagination">';
    echo paginate_links(array(
        'base' => get_the_permalink().'/page/%#%/',
        'format' => '',
        'current' => max(1, $current),
        'total' => $max,
        'prev_text' => '&larr;',
        'next_text' => '&rarr;',
        'prev_next'          => false,
        'type' => 'list',
        'end_size' => 1,
        'mid_size' => 1
    ));
    echo '</nav>';
}
/* end page navi */

/* * *******************
  RANDOM CLEANUP ITEMS
 * ******************* */

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function mona_filter_ptags_on_images($content) {
    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

?>
