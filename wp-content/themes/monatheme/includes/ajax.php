<?php

function mona_ajax_login() {
    $form = array();
    parse_str($_POST['form'], $form);
    $user = get_user_by('email', $form['mona_user_name']);
    if ($user == false) {
        $user = get_user_by('login', $form['mona_user_name']);
    }
    if ($user == false) {
        echo json_encode(array('status' => 'error', 'message' => __('Không tồn tại user', 'monamedia')));
        wp_die();
    }
    $check_pass = wp_check_password($form['mona_user_pass'], $user->data->user_pass, $user->data->ID);
    if ($check_pass == false) {
        echo json_encode(array('status' => 'error', 'message' => __('Mật khẩu không đúng', 'monamedia')));
        wp_die();
    }
    $check = mona_check_has_verify($form['mona_user_name']);
    if ($check == false) {
        mona_send_email_veryfi($form['mona_user_name']);
        echo json_encode(array('status' => 'warnimg',
            'message' => '<div class="content success-register mona-send-very"> ' . __('chúng tôi đã gửi 1 email để xác nhận tài khoản của bạn', 'monamedia') . ' <div id="mona-action-re-email" style="margin-bottom: 10px; display: none;"> <p style="margin-bottom: 10px;"><span style="color:red;">*</span>' . __('Không nhận được email', 'monamedia') . '</p> <a class="primary-btn small-btn" href="javascript:;" data-user="' . $form['mona_user_name'] . '">' . __('Gửi lại email', 'monamedia') . '</a> </div>',
            'user' => $form['mona_user_name']));
        wp_die();
    }

    $user = wp_signon(array('user_login' => $form['mona_user_name'], 'user_password' => $form['mona_user_pass']));
    if (is_wp_error($user)) {
        echo json_encode(array('status' => 'error', 'message' => $user->get_error_message()));
        wp_die();
    }
    if (isset($_SESSION['redierect'])) {

        $url = $_SESSION['redierect'];

        unset($_SESSION['redierect']);
    } else {
        if (isset($form['mona_redierect'])) {
            $url = esc_url($form['mona_redierect']);
        } else {
            $url = get_home_url();
        }
    }
    echo json_encode(array('status' => 'success', 'message' => 'Login success', 'url' => $url));
    wp_die();
}

add_action('wp_ajax_nopriv_mona_ajax_login', 'mona_ajax_login');

function mona_ajax_logout() {
    wp_logout();
    wp_die();
}

add_action('wp_ajax_mona_ajax_logout', 'mona_ajax_logout');

function mona_ajax_check_register() {
    $form = array();
    parse_str($_POST['form'], $form);
    $users = new Mona_user();
    $check = $users->check_before_insert($form);
    if (mona_iswp_error($check)) {
        echo json_encode($check);
        wp_die();
    }
    echo json_encode(array('status' => 'success'));
    wp_die();
}

add_action('wp_ajax_nopriv_mona_ajax_check_register', 'mona_ajax_check_register');

function mona_ajax_check_booking() {
    $email = @$_POST['form'];
    if ($email == '' || $email == null) {
        echo json_encode(array('status' => 'error', 'message' => __('Email không được trống', 'monamedia')));
        wp_die();
    }
    $check = get_user_by('email', $email);
    if ($check == false) {
        $check = get_user_by('login', $email);
    }
    if ($check == false) {
        echo json_encode(array('status' => 'success', 'message' => __('Email hợp lệ', 'monamedia')));
        wp_die();
    }
    echo json_encode(array('status' => 'error', 'message' => __('Email đã có người sử dụng', 'monamedia')));
    wp_die();
}

add_action('wp_ajax_nopriv_mona_ajax_check_booking', 'mona_ajax_check_booking');
add_action('wp_ajax_mona_ajax_check_booking', 'mona_ajax_check_booking');

function mona_ajax_add_file() {
    $file = $_POST['files'];
    $upload = mona_upload_base64($file);
    if (isset($upload['error'])) {
        echo json_encode(array('status' => 'error', 'message' => $upload['error']));
        wp_die();
    }
    $thumb_id = mona_create_attachment($upload);
    if ($thumb_id == 0) {
        echo json_encode(array('status' => 'error', 'message' => __('Oops! can\'t upload file', 'monamedia')));
        wp_die();
    }
    echo json_encode(array('status' => 'success', 'message' => $thumb_id));
    wp_die();
}

add_action('wp_ajax_mona_ajax_add_file', 'mona_ajax_add_file');
add_action('wp_ajax_nopriv_mona_ajax_add_file', 'mona_ajax_add_file');

function mona_ajax_send_veryfi_email() {
    $user_login = @$_POST['user'];

    if ($user_login == '') {
        echo json_encode(array('status' => 'error', 'message' => 'Can\'t send email'));
        wp_die();
    }
    $user = get_user_by('email', $user_login);
    if ($user == false) {
        $user = get_user_by('login', $user_login);
    }

    if ($user == false) {
        echo json_encode(array('status' => 'error', 'message' => 'Can\'t send email'));
        wp_die();
    }
    mona_send_email_veryfi($user->user_login);
    echo json_encode(array('status' => 'success', 'message' => ''));
    wp_die();
}

add_action('wp_ajax_mona_ajax_send_veryfi_email', 'mona_ajax_send_veryfi_email');

function mona_ajax_get_schedule() {
    $post_id = @$_POST['data'];
    $html = '<div class="mona-schedule-popup">';
    if(has_post_thumbnail($post_id)){
        $html .='<div class="thumbnail">'.get_the_post_thumbnail($post_id,'large').'</div>';
    }
    $html .='<ul class="mona-list clear">';
    $type = get_field('mona_tour_type',$post_id);
    $tarr = array(
                            'di_gap_mat' => __('Meeting', 'monamedia'),
                            'di_ket_hon' => __('Wedding', 'monamedia'),
                            'di_choi' => __('Free', 'monamedia'),
                            'di_cong_chuyen' => __('Business', 'monamedia'),
                        );
    if($type !='' && isset($tarr[$type])){
        $html .='<li>'.__('Loại chuyến đi','monamedia').' : '.$tarr[$type].'</li>';
    }
    $tra = get_field('mona_tour_translate',$post_id);
    if($tra !=''){
        $html .='<li>'.__('Phiên dịch','monamedia').' : '.$tra.'</li>';
    }
    $depa = get_field('mona_tour_time_expected',$post_id);
    if($depa !=''){
        $html .='<li>'.__('Ngày đi','monamedia').' : '.$depa.'</li>';
    }
    $fly = get_field('mona_tour_flight_num',$post_id);
     if($fly !=''){
        $html .='<li>'.__('Mã chuyến bay','monamedia').' : '.$fly.'</li>';
    }
    $fly_date = get_field('mona_tour_flight_date',$post_id);
     if($fly_date !=''){
        $html .='<li>'.__('Ngày đi','monamedia').' : '.$fly_date.'</li>';
    }
    $fly_to = get_field('mona_tour_time_to_vn',$post_id);
     if($fly_to !=''){
        $html .='<li>'.__('Ngày đến','monamedia').' : '.$fly_to.'</li>';
    }
    $fly_from = get_field('mona_tour_time_back',$post_id);
     if($fly_from !=''){
        $html .='<li>'.__('Ngày rời việt nam','monamedia').' : '.$fly_from.'</li>';
    }
    $lt = get_field('mona_tour_schedule',$post_id);
     if($fly_from !=''){
        $html .='<li class="mona-lt"><h4 class="lt-title">'.__('Lịch trình','monamedia').'</h4> '.$lt.'</li>';
    }
    $html .='</ul>';
    $html.='</div>';
    echo $html;
    wp_die();
}

add_action('wp_ajax_mona_ajax_get_schedule', 'mona_ajax_get_schedule');
