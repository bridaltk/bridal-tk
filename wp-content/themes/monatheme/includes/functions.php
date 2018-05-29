<?php

function mona_get_avatar_img($uid) {
    if ($uid != '') {
        $user = new Mona_user($uid);
        $avatar = $user->get_post_id();
        if ($avatar != '' && !mona_iswp_error($avatar)) {
            $img = get_the_post_thumbnail($avatar, 'medium');
            if ($img != '') {
                return $img;
            }
        }
    }
    return '<img src="' . get_template_directory_uri() . '/images/avatar.png"/>';
}

function mona_gai_loop($post_id, $data = true) {
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
    ?>
    <div class="item mona-gai-item-loop <?php echo $stt; ?>">
        <div class="img">
            <span class="status <?php echo $stt; ?>" type-status="New"><?php echo $honnhan; ?></span>
            <a href="<?php echo get_the_permalink($post_id); ?>">
                <span class="mona-thumb-img" style="background-image: url(<?php echo get_the_post_thumbnail_url($post_id, 'medium'); ?>)">

                </span>
            </a>
            <?php
            $video = get_field('mona_gai_video_url', $post_id);
            if ($video != '') {
                $l = __('Có video', 'monamedia');
                ?><span class="status-video"><?php echo $l; ?></span><?php
            }
            ?>

        </div>
        <div class="info clear">
            <p class="mona-user-info"><a href="<?php echo get_the_permalink($post_id); ?>"><?php echo $ms; ?></a></p>
            <?php
            if ($data == true) {
                ?>

                <?php
                if ($day != '') {
                    echo '<p class="mona-user-info">' . $day[1] . __('Tháng', 'monamedia') . $day[0] . __('Ngày', 'monamedia') . '</p>';
                }
                if ($tuoi != '') {
                    echo '<p class="mona-user-info">' . $tuoi . '</p>';
                }

                if ($tinh != '') {
                    echo '<p class="mona-user-info">' . $tinh . '</p>';
                }
                if ($hv != '') {
                    echo '<p class="mona-user-info">' . $hv . '</p>';
                }
                if ($nghenghiep != '') {
                    echo '<p class="mona-user-info ">' . $nghenghiep . '</p>';
                }
                ?>
                <?php
            }
            ?>

        </div>
    </div>
    <?php
}

function mona_gai_status($post_id) {
    $hn = get_field('mona_gai_hon_nhan', $post_id);
    if ($hn == 'doc_than') {
        return __('Độc thân', 'monamedia');
    }
    if ($hn == 'ket_hon') {
        return __('Đã kết hôn', 'monamedia');
    }
    if ($hn == 'dinh_hon') {
        return __('Đính hôn', 'monamedia');
    }
    if ($hn == 'bo_hon') {
        return __('Bỏ hôn', 'monamedia');
    }
    return '';
}

function mona_upload_base64($file) {

    $upload_dir = wp_upload_dir();
    // @new
    $upload_path = str_replace('/', DIRECTORY_SEPARATOR, $upload_dir['path']) . DIRECTORY_SEPARATOR;

    $img = $file['base64'];
    if (!preg_match('/data:([^;]*);base64,(.*)/', $img, $matches)) {
        return false;
    }
// Decode the data
    $decoded = base64_decode($matches[2]);
    // @new
    if (file_exists($upload_path . $file['name'])) {
        $file['name'] = strtotime(current_time(0)) . $file['name'];
    }
    $upload_name = $upload_path . $file['name'];
    $image_upload = file_put_contents($upload_name, $decoded);
    $file['error'] = '';
    $file['tmp_name'] = $upload_name;

    if (!function_exists('wp_handle_sideload')) {

        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }
    if (!function_exists('wp_handle_upload')) {

        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }
    $overrides = array(
        'test_form' => false,
        // Setting this to false lets WordPress allow empty files, not recommended
        // Default is true
        'test_size' => true,
    );
    $file_return = wp_handle_sideload($file, $overrides);
    return $file_return;
}

function mona_upload_image($file) {
    if (!function_exists('wp_handle_sideload')) {

        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }
    if (!function_exists('wp_handle_upload')) {

        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }
    $overrides = array(
        'test_form' => false,
        // Setting this to false lets WordPress allow empty files, not recommended
        // Default is true
        'test_size' => true,
    );
    $file_return = wp_handle_sideload($file, $overrides);
    return $file_return;
}

function mona_create_attachment($file) {
    $attachment = array(
        'post_mime_type' => $file['type'],
        'post_title' => sanitize_file_name(basename($file['file'])),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $upload_dir = wp_upload_dir();
    $filepatch = $file['file'];
    $attach_id = wp_insert_attachment($attachment, $filepatch);
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata($attach_id, $filepatch);
    wp_update_attachment_metadata($attach_id, $attach_data);
    return $attach_id;
}

function mona_redierect_login() {

    if (is_user_logged_in()) {
        if (isset($_SESSION['redierect'])) {

            $login = $_SESSION['redierect'];

            unset($_SESSION['redierect']);

            wp_redirect($login, 302);

            die;
        } else {

            wp_redirect(get_home_url());

            die;
        }
    } else {
        if (get_the_ID() != MONA_LOGIN && get_the_ID() != MONA_REGISTER && get_the_ID() != MONA_LOST_PASS) {

            $_SESSION['redierect'] = "//" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];





            wp_redirect(get_the_permalink(MONA_LOGIN));

            die;
        }
    }
}

function mona_iswp_error($args) {

    if (is_array($args) && isset($args['status']) && $args['status'] == 'error') {

        return true;
    }

    return false;
}

function mona_num_output($num) {

    if ($num > 0) {

        $num = number_format($num);
    }

    return $num;
}

function wpse28782_remove_menu_items() {
    if (!current_user_can('administrator')):
        remove_menu_page('edit.php?post_type=mona_promotion');
        //remove_menu_page( 'edit.php?post_type=mona_tour' );
        remove_menu_page('edit.php?post_type=mona_gai');
        remove_menu_page('edit.php?post_type=page');
        remove_menu_page('edit.php?post_type=acf-field-group');
        remove_menu_page('wpcf7');
        remove_menu_page('edit.php'); // Posts
        remove_menu_page('profile.php'); // Posts
        remove_menu_page('upload.php'); // Media
        remove_menu_page('link-manager.php'); // Links
        remove_menu_page('edit-comments.php'); // Comments
        remove_menu_page('plugins.php'); // Plugins
        remove_menu_page('themes.php'); // Appearance
        remove_menu_page('users.php'); // Users
        remove_menu_page('tools.php'); // Tools
        remove_menu_page('loco'); // Tools
        remove_menu_page('options-general.php'); // Settings

    endif;
}

add_action('admin_menu', 'wpse28782_remove_menu_items', 9999999);

function add_roles_on_plugin_activation() {
    add_role('mona_khac_hang', 'Khách hàng', array('read' => true, 'level_0' => true, 'publish_posts' => true));
    $roles = array(
        'level_1' => true,
        'level_2' => true,
        'level_3' => true,
        'level_4' => true,
        'level_5' => true,
        'level_6' => true,
        'level_7' => true,
        'level_8' => true,
        'level_9' => true,
        'read' => true,
        'publish_posts' => true,
        'delete_others_pages' => true,
        'delete_others_posts' => true,
        'delete_pages' => true,
        'delete_posts' => true,
        'delete_private_posts' => true,
        'delete_private_pages' => true,
        'delete_published_pages' => true,
        'delete_published_posts' => true,
        'edit_others_pages' => true,
        'edit_others_posts' => true,
        'edit_pages' => true,
        'edit_posts' => true,
        'edit_private_posts' => true,
        'edit_private_pages' => true,
        'edit_published_pages' => true,
        'edit_published_posts' => true,
        'manage_links' => true,
        'manage_options' => true,
        'publish_pages' => true,
        'publish_posts' => true,
        'read_private_pages' => true,
        'read_private_posts' => true,
        'upload_files' => true,
    );
    add_role('mona_quan_ly', 'Quản Lý tour', $roles);
    $rl = get_role('mona_quan_ly');
    foreach ($roles as $k => $v) {
        $rl->add_cap($k);
    }
    $rl->remove_cap('loco_admin');
}

add_action('init', 'add_roles_on_plugin_activation');

function mona_add_menu_page() {
    add_menu_page('Khách hàng', 'Khách hàng', 'publish_posts', 'mona_author', 'mona_author_page');
}

//add_action('admin_menu', 'mona_add_menu_page');

function mona_author_page() {
    if (isset($_GET['user_id']) && trim($_GET['user_id']) != '') {
        $user = get_userdata($_GET['user_id']);
        if ($user != false) {
            if (@$user->caps['mona_khac_hang'] == true) {
                get_template_part('patch/admin/admin', 'user');
                return;
            }
        }
    }
    get_template_part('patch/admin/admin', 'author');
}

function mona_dasboar_widget() {

    wp_add_dashboard_widget(
            'mona_dasboar_hoat_dong', // Widget slug.
            __('Hoạt động', 'monamedia'), // Title.
            'mona_dasboar_widget_function' // Display function.
    );
}

add_action('wp_dashboard_setup', 'mona_dasboar_widget');

function mona_dasboar_widget_function() {
    if (!current_user_can('administrator')) {
        return;
    }
    $post_id = get_option('page_on_front');
    if (isset($_POST['mona_hoat_dong'])) {
        $ht = array_values($_POST['mona_hoat_dong']);
        update_field('mona_home_hoat_dong', $ht, $post_id);
    }
    wp_enqueue_script('mona-datapicker-is', get_site_url() . '/template/js/bootstrap-datepicker/bootstrap-datepicker.min.js', array(), false, true);
    $hds = get_field('mona_home_hoat_dong', $post_id);
    ?>
    <form id="submit-hoat-dong" action="" method="post">
        <ul class="mona_hoat_dong" id="mona_hoat_dong" data-total="<?php echo count($hds); ?>">
            <?php
            if (is_array($hds)) {
                foreach ($hds as $k => $item) {
                    if ($item['mona_home_day'] != '' || $item['content'] != '') {
                        ?>
                        <li class="hd-item" data-id="<?php echo $k; ?>">
                            <div class="item">
                                <div class="time">
                                    <input name="mona_hoat_dong[<?php echo $k; ?>][mona_home_day]" type="text" class="mona-date-picker" value="<?php echo $item['mona_home_day']; ?>"/>
                                </div>
                                <div class="content">
                                    <textarea name="mona_hoat_dong[<?php echo $k; ?>][content]"><?php echo $item['content']; ?></textarea>
                                </div>
                            </div>
                            <span class="dashicons dashicons-no"></span>
                        </li>   
                        <?php
                    }
                }
            }
            ?>
            <li class="hd-item" data-id="<?php echo count($hds); ?>">
                <div class="item">
                    <div class="time">
                        <input name="mona_hoat_dong[<?php echo count($hds); ?>][mona_home_day]" type="text" class="mona-date-picker" value=""/>
                    </div>
                    <div class="content">
                        <textarea name="mona_hoat_dong[<?php echo count($hds); ?>][content]"></textarea>
                    </div>
                </div>
                <span class="dashicons dashicons-no"></span>
            </li>          
        </ul>    
        <button type="submit" class="button button-primary">Save</button>
        <button type="button" class="button " id="mona-add-field-content">+ Add</button>
    </form>
    <?php
}

function generateRandomString($length = 8) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function mona_disable_comment_url($fields) {
    unset($fields['url']);
    return $fields;
}

add_filter('comment_form_default_fields', 'mona_disable_comment_url');

function mona_filter_title($title) {
    if (is_singular('mona_gai')) {
        $ms = get_field('mona_gai_ma_hoi_vien', get_the_ID());
        return '#' . $ms . ' | ';
    }
}

add_filter('wp_title', 'mona_filter_title');

function mona_add_revision_field($fields, $post) {
    $fields['_date_update'] = '';

    return $fields;
}

add_filter('_wp_post_revision_fields', 'mona_add_revision_field', 10, 2);

function mona_filter_status_user($stt) {
    switch ($stt) {
        case 'dinh_hon':
            return __('Đã đính hôn', 'monamedia');
            break;
        case 'ket_hon':
            return __('Đã kết hôn', 'monamedia');
            break;
        case 'huy_hon':
            return __('Đã hủy hôn', 'monamedia');
            break;
        case 'ly_hon':
            return __('Đã ly hôn', 'monamedia');
            break;
        default:
            return __('Open', 'monamedia');
            break;
    }
}

function mona_filter_hv_user($stt) {
    $args = array(
        'tieu_hoc' => __('Tiểu học', 'monamedia'),
        'trung_hoc' => __('Trung học', 'monamedia'),
        'pho_thong' => __('Phổ thông', 'monamedia'),
        'trung_cap' => __('Trung cấp', 'monamedia'),
        'cao_dang' => __('Cao đẳng', 'monamedia'),
        'dai_hoc' => __('Đại học', 'monamedia'),
    );
    if (isset($args[$stt])) {
        return $args[$stt];
    }
    return __('Không cung cấp', 'monamedia');
}

function mona_send_email_veryfi($user_login) {

    $user = get_user_by('login', $user_login);

    if (!$user) {

        $user = get_user_by('email', $user_login);
    }

    $key = wp_generate_password(20, false);

    update_user_meta($user->data->ID, '_mona_general_verify', array('key' => $key, 'expr' => date('Ymdhis', time())));

    $to = $user->data->user_email;

    $subject = sprintf('Register %s', get_bloginfo('name'));
    $body = sprintf(__('<p>Chào %s </p><p>Cảm ơn bạn đã tham gia vào <a href="%s" target="_blank">%s</a></p><p>Chúng tôi đã gửi bạn 1 Email chứa Url để verify tài khoản:</p> <p><a href="%s?verify=%s&login=%s">%s?verify=%s&login=%s</a></p>', 'monamedia'), $user_login, get_home_url(), get_bloginfo('name'), get_the_permalink(VERIFY), $key, rawurlencode($user_login), get_the_permalink(VERIFY), $key, rawurlencode($user_login));
    $headers = array('Content-Type: text/html; charset=UTF-8');

    wp_mail($to, $subject, $body, $headers);

    remove_filter('wp_mail_content_type', 'wpse27856_set_content_type');
}

function mona_check_has_verify($login) {
    $user = get_user_by('login', $login);

    if (!$user) {

        $user = get_user_by('email', $login);
    }

    if ($user) {

        $check = get_user_meta($user->data->ID, '__none_active', true);

        if ($check == 'false') {

            return true;
        }
    }

    return false;
}

function mona_check_veryfi($key, $login) {

    $user = get_user_by('login', $login);

    if (!$user) {

        $user = get_user_by('email', $login);
    }

    if ($user) {

        $check = get_user_meta($user->data->ID, '_mona_general_verify', true);
        if (is_array($check)) {
            $current = date(date('Ymdhis', time()));
            if ((int) $current - (int) $check['expr'] <=1500) {
               if ($check == $key && $check != '') {

            delete_user_meta($user->data->ID, '_mona_general_verify');

            update_user_meta($user->data->ID, '__none_active', 'false');

            return true;
        } 
            }
        }
        
    }

    return false;
}
