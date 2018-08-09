<?php

require_once( get_template_directory() . '/core/huyen-bi.php' );
require_once( get_template_directory() . '/core/reset.php' );
require_once( get_template_directory() . '/core/class/aqua-resize.php' );
require_once( get_template_directory() . '/core/customizer.php' );
require_once( get_template_directory() . '/includes/metabox.php' );
require_once( get_template_directory() . '/includes/functions.php' );
require_once( get_template_directory() . '/includes/class/mona-user.php' );
require_once( get_template_directory() . '/includes/class/mona_gai.php' );
require_once( get_template_directory() . '/includes/ajax.php' );

//require(get_template_directory() . '/includes/metabox/register.php');
define('ACF_LITE', true);
define('MY_ACCOUNT', 278);
define('MONA_LOGIN', 252);
define('MONA_REGISTER', 19);
define('MONA_LOST_PASS', 254);
define('MONA_BOOKING', 291);
define('VERIFY', 1602);
define('MONA_REQUIRE_VERY', 1602);
define('MONA_MEMBER', 17);
define('MONA_NOT_SEND', true);

function mona_ahoy() {

//Allow editor style.
// add_editor_style(get_stylesheet_directory_uri() . '/css/editor-style.css');
// let's get language support going, if you need it
    load_theme_textdomain('monamedia', get_template_directory() . '/languages');

// launching operation cleanup
    add_action('init', 'mona_clear_head');
// A better title
    add_filter('wp_title', 'rw_title', 10, 3);
// remove WP version from RSS
    add_filter('the_generator', 'mona_rss_version');
// remove pesky injected css for recent comments widget
    add_filter('wp_head', 'mona_remove_wp_widget_recent_comments_style', 1);
// clean up comment styles in the head
    add_action('wp_head', 'mona_remove_recent_comments_style', 1);
// ie conditional wrapper
// launching this stuff after theme setup
    mona_theme_support();
// cleaning up random code around images
    add_filter('the_content', 'mona_filter_ptags_on_images');
    add_image_size('mona_thumb', 300, 300, true);
    add_image_size('blog_large', 370, 270, true);
    add_image_size('mona_banner_large', 262, 400, true);
    add_image_size('mona_about_img', 570, 400, false);
}

/* end bones ahoy */

// let's get this party started
add_action('after_setup_theme', 'mona_ahoy');

/* * *********** OEMBED SIZE OPTIONS ************ */

function mona_register_sidebars() {
    register_sidebar(array(
        'id' => 'sidebar1',
        'name' => __('About', 'mona_media'),
        'description' => __('The first (primary) sidebar.', 'mona_media'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="lbl">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'id' => 'sidebar2',
        'name' => __('System', 'mona_media'),
        'description' => __('The first (primary) sidebar.', 'mona_media'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="lbl">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 1', 'mono-theme'),
        'id' => 'footer_1',
        'description' => '',
        'class' => '',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="f-title"><h3 class="fz-24">',
        'after_title' => '</h3></div>'
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 2', 'mono-theme'),
        'id' => 'footer_2',
        'description' => '',
        'class' => '',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="f-title"><h3 class="fz-24">',
        'after_title' => '</h3></div>'
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 3', 'mono-theme'),
        'id' => 'footer_3',
        'description' => '',
        'class' => '',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="f-title"><h3 class="fz-24">',
        'after_title' => '</h3></div>'
    ));
}

add_action('widgets_init', 'mona_register_sidebars');
if (!isset($content_width)) {
    $content_width = 1170;
}

// add widget
function mona_widget() {
    require_once(get_template_directory() . '/widget/mona-contact-info.php');
    register_widget('Mona_contact_info');
    require_once(get_template_directory() . '/widget/mona-social-info.php');
    register_widget('Mona_Social_Info_Widget');
}

add_action('widgets_init', 'mona_widget');



add_filter('get_the_archive_title', function ( $title ) {

    if (is_category()) {

        $title = str_replace(array('Category:', 'Tag:', 'Tags:'), array('', '', ''), $title);
    }
    return $title;
});

function mona_style() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('mona-SmoothScroll', get_template_directory_uri() . '/js/SmoothScroll.js', array(), false, true);
    wp_enqueue_style('mona-magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css');
    wp_enqueue_style('mona-custom', get_template_directory_uri() . '/css/mona-custom2.css?ver=1.05');
    wp_enqueue_script('mona-magnific', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array(), false, true);
    wp_enqueue_script('mona-comment', get_template_directory_uri() . '/js/libs.js', array(), false, true);
    wp_enqueue_script('mona-front', get_template_directory_uri() . '/js/front2.js', array(), false, true);
    wp_localize_script('mona-front', 'mona_ajax_url', array('ajaxURL' => admin_url('admin-ajax.php'), 'siteURL' => get_site_url()));
}

add_action('wp_enqueue_scripts', 'mona_style');

function mona_admin_style() {
    wp_enqueue_style('mona-admin_css', get_template_directory_uri() . '/css/admin.css');
    wp_enqueue_style('mona-datapicker', get_site_url() . '/template/js/bootstrap-datepicker/bootstrap-datepicker.standalone.css');
    wp_enqueue_style('mona-select_css', get_site_url() . '/template/js/select2/select2.min.css');
  //  wp_enqueue_script('mona-datapicker-is', get_site_url() . '/template/js/bootstrap-datepicker/bootstrap-datepicker.min.js', array(), false, true);
    wp_enqueue_script('mona-select', get_site_url() . '/template/js/select2/select2.min.js', array(), false, true);
    wp_enqueue_script('mona-admin', get_template_directory_uri() . '/js/mona-admin.js', array(), false, true);
}

add_action('admin_enqueue_scripts', 'mona_admin_style');

class Mona_Custom_Walker_Nav_Menu extends Walker_Nav_Menu {

    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class='dropdown-menu'><ul class='sub-menu'>\n";
    }

    function end_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    }

}

function add_menu_parent_class($items) {
    $parents = array();
    foreach ($items as $item) {
        //Check if the item is a parent item
        if ($item->menu_item_parent && $item->menu_item_parent > 0) {
            $parents[] = $item->menu_item_parent;
        }
    }

    foreach ($items as $item) {
        if (in_array($item->ID, $parents)) {
            //Add "menu-parent-item" class to parents
            $item->classes[] = 'has-dropdown ';
        }
    }

    return $items;
}

add_filter('wp_nav_menu_objects', 'add_menu_parent_class');

function mona_add_custom_post() {
    $args = array(
        'labels' => array(
            'name' => __('Customer', 'monamedia'),
            'singular_name' => __('Customer', 'monamedia'),
            'add_new' => __('Add Customer', 'monamedia'),
            'add_new_item' => __('New Customer', 'monamedia'),
            'edit_item' => __('Edit Customer', 'monamedia'),
            'new_item' => __('New Customer', 'monamedia'),
            'view_item' => __('View Customer', 'monamedia'),
            'view_items' => __('View Customers', 'monamedia'),
        ),
        'description' => 'Add Customer',
        'supports' => array(
            'title',
            //'editor',
            'author',
            'thumbnail',
            'comments',
            'revisions',
            'custom-fields'
        ),
        'taxonomies' => array(),
        'hierarchical' => false,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'customer',
            'with_front' => true
        ),
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-universal-access-alt',
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => false,
        'capability_type' => 'post',
        'map_meta_cap' => true,
    );
    register_post_type('mona_khach_hang', $args);

    $args = array(
        'labels' => array(
            'name' => __('Tour', 'monamedia'),
            'singular_name' => __('Tour', 'monamedia'),
            'add_new' => __('Add Tour', 'monamedia'),
            'add_new_item' => __('New Tour', 'monamedia'),
            'edit_item' => __('Edit Tour', 'monamedia'),
            'new_item' => __('New Tour', 'monamedia'),
            'view_item' => __('View Tour', 'monamedia'),
            'view_items' => __('View Tours', 'monamedia'),
        ),
        'description' => 'Add Tour',
        'supports' => array(
            'title',
            //'editor',
            'author',
            //  'thumbnail',
            // 'comments',
            //'revisions',
            'custom-fields'
        ),
        'taxonomies' => array(),
        'hierarchical' => false,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'tour',
            'with_front' => true
        ),
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-universal-access-alt',
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post'
    );
    register_post_type('mona_tour', $args);

    $args = array(
        'labels' => array(
            'name' => __('Meeting', 'monamedia'),
            'singular_name' => __('Meeting', 'monamedia'),
            'add_new' => __('Add Meeting', 'monamedia'),
            'add_new_item' => __('New Meeting', 'monamedia'),
            'edit_item' => __('Edit Meeting', 'monamedia'),
            'new_item' => __('New Meeting', 'monamedia'),
            'view_item' => __('View Meeting', 'monamedia'),
            'view_items' => __('View Meetings', 'monamedia'),
        ),
        'description' => 'Add Meeting',
        'supports' => array(
            'title',
            'editor',
            'author',
            'thumbnail',
            //  'comments',
            'revisions',
            'custom-fields'
        ),
        'taxonomies' => array(),
        'hierarchical' => false,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'orders',
            'with_front' => true
        ),
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-universal-access-alt',
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post'
    );
    register_post_type('mona_order', $args);
    $args = array(
        'labels' => array(
            'name' => __('Promotion', 'monamedia'),
            'singular_name' => __('Promotion', 'monamedia'),
            'add_new' => __('Add Promotion', 'monamedia'),
            'add_new_item' => __('New Promotion', 'monamedia'),
            'edit_item' => __('Edit Promotion', 'monamedia'),
            'new_item' => __('New Promotion', 'monamedia'),
            'view_item' => __('View Promotion', 'monamedia'),
            'view_items' => __('View Promotions', 'monamedia'),
        ),
        'description' => 'Add Promotion',
        'supports' => array(
            'title',
            'editor',
            'author',
            'thumbnail',
            'comments',
            'revisions',
            'custom-fields'
        ),
        'taxonomies' => array(),
        'hierarchical' => false,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'promotion',
            'with_front' => true
        ),
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-universal-access-alt',
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post'
    );
    register_post_type('mona_promotion', $args);
    $args = array(
        'labels' => array(
            'name' => __('Hoạt Động', 'monamedia'),
            'singular_name' => __('Hoạt Động', 'monamedia'),
            'add_new' => __('Add Hoạt Động', 'monamedia'),
            'add_new_item' => __('New Hoạt Động', 'monamedia'),
            'edit_item' => __('Edit Hoạt Động', 'monamedia'),
            'new_item' => __('New Hoạt Động', 'monamedia'),
            'view_item' => __('View Hoạt Động', 'monamedia'),
            'view_items' => __('View Hoạt Độngs', 'monamedia'),
        ),
        'description' => 'Add Hoạt Động',
        'supports' => array(
            'title',
            'editor',
            'author',
            'thumbnail',
            'comments',
            'revisions',
            'custom-fields'
        ),
        'taxonomies' => array(),
        'hierarchical' => false,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'hoat-dong',
            'with_front' => false
        ),
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-universal-access-alt',
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post'
    );
    //register_post_type('mona_hoat_dong', $args);
    $args = array(
        'labels' => array(
            'name' => __('Member', 'monamedia'),
            'singular_name' => __('Member', 'monamedia'),
            'add_new' => __('Add Member', 'monamedia'),
            'add_new_item' => __('New Member', 'monamedia'),
            'edit_item' => __('Edit Member', 'monamedia'),
            'new_item' => __('New Member', 'monamedia'),
            'view_item' => __('View Member', 'monamedia'),
            'view_items' => __('View Members', 'monamedia'),
        ),
        'description' => 'Add Member',
        'supports' => array(
            'title',
            'editor',
            'author',
            'thumbnail',
            'comments',
            'revisions',
            'custom-fields'
        ),
        'taxonomies' => array(),
        'hierarchical' => false,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'female-members',
            'with_front' => false
        ),
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-universal-access-alt',
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post'
    );
    register_post_type('mona_gai', $args);
    flush_rewrite_rules();
}

add_action('init', 'mona_add_custom_post');

function prefix_limit_post_types_in_search($query) {
    $query->set('ignore_sticky_posts', true);
    $ptype = $query->get('post_type');
    if($ptype=='mona_gai'){
        $query->set('meta_key','mona_gai_nhap_hoi'); 
       $query->set('orderby','meta_value'); 
       $query->set('order','DESC'); 
    }
    return $query;
}

add_filter('pre_get_posts', 'prefix_limit_post_types_in_search');

function mona_menu_control($items, $args) {
    if ($args->theme_location == 'primary-menu') {
        if (is_user_logged_in()) {
            $items .= '<li id="menu-item-' . MY_ACCOUNT . '" class="' . (MY_ACCOUNT == get_the_ID() ? 'current-menu-item' : '') . ' menu-item-has-children has-dropdown menu-item menu-item-type-post_type menu-item-object-page menu-item-' . MY_ACCOUNT . '"><a href="' . get_the_permalink(MY_ACCOUNT) . '">' . __('Tài khoản', 'monamedia') . '</a>';
            $items .= '<div class="dropdown-menu"><ul class="sub-menu">
                            <li class="menu-item menu-item-type-post_type menu-item-object-page ' . (MY_ACCOUNT == get_the_ID() && get_query_var('my_account_var') != 'doi-mat-khau' && get_query_var('my_account_var') != 'chuyen-di' ? 'current-menu-item' : '') . '"><a href="' . get_the_permalink(MY_ACCOUNT) . '/quan-ly-tai-khoan">' . __('Quản lý tài khoản', 'monamedia') . '</a></li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page ' . (MY_ACCOUNT == get_the_ID() && get_query_var('my_account_var') == 'chuyen-di' ? 'current-menu-item' : '') . '"><a href="' . get_the_permalink(MY_ACCOUNT) . '/chuyen-di">' . __('Chuyến đi', 'monamedia') . '</a></li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page ' . (MY_ACCOUNT == get_the_ID() && get_query_var('my_account_var') == 'doi-mat-khau' ? 'current-menu-item' : '') . '"><a href="' . get_the_permalink(MY_ACCOUNT) . '/doi-mat-khau">' . __('Đổi mật khẩu', 'monamedia') . '</a></li>
                            
                            <li class="menu-item menu-item-type-post_type menu-item-object-page "><a class="mona-logout-action" href="' . wp_logout_url() . '">' . __('đăng xuất', 'monamedia') . '</a></li>
                        </ul></div></li>';
        } else {
            $items .= '<li id="menu-item-' . MY_ACCOUNT . '" class="' . (MY_ACCOUNT == get_the_ID() ? 'current-menu-item' : '') . ' menu-item-has-children has-dropdown menu-item menu-item-type-post_type menu-item-object-page menu-item-' . MY_ACCOUNT . '"><a href="' . get_the_permalink(MY_ACCOUNT) . '">' . __('Tài khoản', 'monamedia') . '</a>';
            $items .= '<div class="dropdown-menu"><ul class="sub-menu">
                            <li id="menu-item-' . MONA_LOGIN . '" class=" ' . (MONA_LOGIN == get_the_ID() ? 'current-menu-item' : '') . ' menu-item menu-item-type-post_type menu-item-object-page menu-item-' . MONA_LOGIN . '"><a href="' . get_the_permalink(MONA_LOGIN) . '">' . __('Đăng nhập', 'monamedia') . '</a></li>
                            <li id="menu-item-' . MONA_REGISTER . '" class=" ' . (MONA_REGISTER == get_the_ID() ? 'current-menu-item' : '') . ' menu-item menu-item-type-post_type menu-item-object-page menu-item-' . MONA_REGISTER . '"><a href="' . get_the_permalink(MONA_REGISTER) . '">' . __('Đăng ký', 'monamedia') . '</a></li>
                        </ul></div></li>';
            //$items .= '<li id="menu-item-' . MONA_LOGIN . '" class=" ' . (MONA_LOGIN == get_the_ID() ? 'current-menu-item' : '') . ' menu-item menu-item-type-post_type menu-item-object-page menu-item-' . MONA_LOGIN . '"><a href="' . get_the_permalink(MONA_LOGIN) . '">' . __('Đăng nhập', 'monamedia') . '</a></li>';
            //$items .= '<li id="menu-item-' . MONA_REGISTER . '" class=" ' . (MONA_REGISTER == get_the_ID() ? 'current-menu-item' : '') . ' menu-item menu-item-type-post_type menu-item-object-page menu-item-' . MONA_REGISTER . '"><a href="' . get_the_permalink(MONA_REGISTER) . '">' . __('Đăng ký', 'monamedia') . '</a></li>';
        }
    }
    return $items;
}

add_filter('wp_nav_menu_items', 'mona_menu_control', 10, 2);

function myStartSession() {
    if (!session_id()) {
        session_start();
    }
}

add_action('init', 'myStartSession', 1);

function mona_rewrite_url() {
    global $wp_rewrite;
    add_rewrite_rule('^tai-khoan/([^/]*)/?', 'index.php?page_id=' . MY_ACCOUNT . '&my_account_var=$matches[1]', 'top');
    $wp_rewrite->flush_rules(true);
}

add_action('init', 'mona_rewrite_url');

function register_custom_query_vars($vars) {
    array_push($vars, 'my_account_var');
    return $vars;
}

add_filter('query_vars', 'register_custom_query_vars', 1);
add_action('init', 'myStartSession', 1);

function mona_admin_bar($bar){
    if(current_user_can('administrator')){
        return true;
    }
    return false;
}
add_filter('show_admin_bar','mona_admin_bar');

function my_custom_popular_posts_html_list( $mostpopular, $instance ){
    $output = '';
    // loop the array of popular posts objects
    foreach( $mostpopular as $popular ) {
        $post_id = $popular->id;
        $gais = new Mona_gai($post_id);
        $tuoi = $gais->get_tuoi();
        $ms = $gais->get_ms();
        $nghenghiep = $gais->get_nghe_nghiep();
        $honnhan = mona_gai_status($post_id);
        $stt = get_field('mona_gai_hon_nhan', $post_id);
        $day = $gais->get_day();
        $day = explode('/', $day);
        $tinh = $gais->get_tinh();
        $hv = $gais->get_hoc_van();
        $hv = $gais->get_format_label($hv);

        $output .= '<div class="item mona-gai-item-loop '.$stt.'">';
        $output .= '<div class="img">';
        $output .= '<span class="status '.$stt.'" type-status="New">'.$honnhan.'</span>';
        $output .= '<a href="'.get_the_permalink($post_id).'">';
        $output .= '<span class="mona-thumb-img" style="background-image: url('.get_the_post_thumbnail_url($post_id, 'medium').'")></span>"';
        $output .= '</a>';
        $video = get_field('mona_gai_video_url', $post_id);
        if ($video != '') {
            $l = __('Có video', 'monamedia');
            $output .= '<span class="status-video">'.$l.'</span>';
        }
        $output .= '</div><div class="info clear">';
        $output .= '<p class="mona-user-info"><a href="'.get_the_permalink($post_id).'">'.$ms.'</a></p>';

        if ($day != '') {
            $output .= '<p class="mona-user-info">' . $day[1] . __('Tháng', 'monamedia') . $day[0] . __('Ngày', 'monamedia') . '</p>';
        }
        if ($tuoi != '') {
            $output .= '<p class="mona-user-info">' . $tuoi . '</p>';
        }
        if ($tinh != '') {
            $output .= '<p class="mona-user-info">' . $tinh . '</p>';
        }
        if ($hv != '') {
            $output .= '<p class="mona-user-info">' . $hv . '</p>';
        }
        if ($nghenghiep != '') {
            $output .= '<p class="mona-user-info ">' . $nghenghiep . '</p>';
        }
        $output .= '</div></div>';
    }
    return $output;
}

add_filter( 'wpp_custom_html', 'my_custom_popular_posts_html_list', 10, 2 );