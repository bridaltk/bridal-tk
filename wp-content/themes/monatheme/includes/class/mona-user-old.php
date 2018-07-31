<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mona-user
 *
 * @author Hy
 */
class Mona_user {

    protected $_user_id = null;
    protected $_user_data = null;
    protected $_user_post_id = null;

    public function __construct($user_id = '') {
        if ($user_id == '') {
            if (is_user_logged_in()) {
                $user_id = get_current_user_id();
                $this->_user_post_id = $this->get_post_user();
            }
        }
        $this->_user_id = $user_id;
    }

    public function insert_user($data) {
        $check = $this->check_before_insert($data);
        if (mona_iswp_error($check)) {
            return $check;
        }
        $userdata = array(
            'user_login' => $data['mona_user_name'],
            'user_pass' => $data['mona_user_pass'],
            'user_email' => $data['mona_user_email'],
            'nickname' => $data['mona_user_name_romaji'],
            'user_nicename' => $data['mona_user_name_romaji'],
            'first_name' => $data['mona_user_name_kanji'],
            'last_name' => $data['mona_user_name_romaji'],
            'display_name' => $data['mona_user_name_kanji'] . '(' . $data['mona_user_name_romaji'] . ')',
            'role' => 'mona_khac_hang',
            'show_admin_bar_front' => false
        );
        $user_id = wp_insert_user($userdata);
        if (is_wp_error($user_id)) {
            return $this->get_error('error', $user_id->get_error_message());
        }
        $this->_user_id = $user_id;
        wp_signon(array(
            'user_login' => $data['mona_user_name'],
            'user_password' => $data['mona_user_pass'],
        ));
        $post_id = $this->inser_post_user($data);

        if (mona_iswp_error($post_id)) {
            return $post_id; 
        }
        $this->update_post_user_data($data);
        $user_data = $this->get_user_data();
        return true;
    }

    protected function inser_post_user($data = '') {
        if ($this->_user_id == NULL) {
            return $this->get_error('error', __('không tồn tại Khách hàng', 'monamedia'));
        }
        $userdata = get_userdata($this->_user_id);
        $post_args = array(
            'post_author' => $this->_user_id,
            'post_title' => $userdata->data->display_name,
            'post_type' => 'mona_khach_hang',
            'post_name' => $userdata->user_login,
            'post_status' => 'publish',
        );
        $insert = wp_insert_post($post_args);
        if (is_wp_error($insert)) {
            return $this->get_error('error', $insert->get_error_messages());
        }
        $this->_user_post_id = $insert;
        if ($data != '') {
            $this->update_post_user_data($data);
        }

        return $insert;
    }

    public function update_post_user_data($data) {
        $postargs = array(
            'ID' => $this->_user_post_id,
            'post_author' => $this->_user_id,
            'post_title' => $data['mona_user_name_kanji'] . '(' . $data['mona_user_name_romaji'] . ')',
            'post_type' => 'mona_khach_hang',
            'post_status' => 'publish',
            'meta_input' => array(
                '_ten_kanji' => @$data['mona_user_name_kanji'],
                '_ten_romaji' => @$data['mona_user_name_romaji'],
                '_birthday' => @$data['mona_user_birthday'],
                '_phone' => @$data['mona_user_phone'],
                '_height' => @$data['mona_user_height'],
                '_blood_type' => @$data['mona_user_nhom_mau'],
                '_hoc_van' => @$data['mona_user_hv'],
                '_honnhan' => @$data['mona_user_hon_nhan'],
                '_nghe_nghiep' => @$data['mona_user_nghe_nghiep'],
                '_thu_nhap' => @$data['mona_user_thu_nhap'],
                '_address' => @$data['mona_user_address'],
                '_so_thich' => @$data['mona_user_hobby'],
                '_tuoi_bo' => @$data['mona_user_tuoi_bo'],
                '_nghe_bo' => @$data['mona_user_nghe_bo'],
                '_tuoi_me' => @$data['mona_user_tuoi_me'],
                '_nghe_me' => @$data['mona_user_nghe_me'],
                '_anh_chi_em' => @$data['mona_user_anh_em'],
                '_ban_than' => @$data['mona_user_ban_than'],
                '_contact' => @$data['mona_user_contact'],
            ),
        );
        if (isset($data['thumbnail'])) {
            $thumb = mona_upload_image($data['thumbnail']);
            $thumb_id = mona_create_attachment($thumb);
            $postargs['meta_input']['_thumbnail_id'] = $thumb_id;
        }
        if (isset($data['gallery'])) {
            if (is_array($data['gallery']['name'])) {
                $ga = array();
                for ($i = 0; $i < count($data['gallery']); $i++) {
                    $file = array(
                        'name' => $data['gallery']['name'][$i],
                        'type' => $data['gallery']['type'][$i],
                        'tmp_name' => $data['gallery']['tmp_name'][$i],
                        'error' => $data['gallery']['error'][$i],
                        'size' => $data['gallery']['size'][$i],
                    );
                    $thumb = mona_upload_image($file);
                    $thumb_id = mona_create_attachment($thumb);
                    $ga[] = $thumb_id;
                }
            }
            $postargs['meta_input']['_gallery'] = $ga;
        }
        $insert = wp_insert_post($postargs);
        if (is_wp_error($insert)) {
            return $this->get_error('error', $insert->get_error_message());
        }
        return $insert;
    }

    public function get_user_data() {
        $output = array();
        if ($this->_user_id == NULL) {
            return $this->get_error('error', __('Không tồn tại khách hàng', 'monamedia'));
        }
        if ($this->_user_post_id == null) {
            $post_id = $this->get_post_user();
            if (mona_iswp_error($post_id)) {
                $post_id = $this->inser_post_user();
            }
            $this->_user_post_id = $post_id;
        }
    }

    public function get_post_user() {
        if ($this->_user_id == null) {
            return $this->get_error('error', __('Không tồn tại user', 'monamedia'));
        }
        $args = array(
            'post_type' => 'mona_khach_hang',
            'posts_per_page' => 1,
            'order' => 'DESC',
            'orderby' => 'date',
            'author' => $this->_user_id,
            'post_status' => 'publish'
        );
        $posts = new WP_Query($args);
        if ($posts->have_posts()) {
            $posts->the_post();
            $this->_user_post_id = get_the_ID();
            return get_the_ID();
        } else {
            return $this->get_error('error', __('Không tồn tại user data', 'monamedia'));
        }
        wp_reset_query();
    }

    public function get_data($uid) {
        
    }

    public function check_before_insert($data) {
        if (!isset($data['mona_user_name']) || trim($data['mona_user_name']) == '') {
            return $this->get_error('error', __('Tên đăng nhập không được trống', 'monamedia'));
        }
        $user = get_user_by('login', trim($data['mona_user_name']));
        if ($user != false) {
            return $this->get_error('error', __('Tên đăng nhập đã tồn tại', 'monamedia'));
        }
        if (!isset($data['mona_user_email']) || trim($data['mona_user_email']) == '') {
            return $this->get_error('error', __('Email không được trống', 'monamedia'));
        }
        $user = get_user_by('email', trim($data['mona_user_email']));
        if ($user != false) {
            return $this->get_error('error', __('Email đã tồn tại', 'monamedia'));
        }
        if (!isset($data['mona_user_pass']) || strlen(($data['mona_user_pass'])) < 6) {
            return $this->get_error('error', __('Mật khẩu phải có ít nhất 6 ký tự', 'monamedia'));
        }
        if (!isset($data['mona_user_repass']) || $data['mona_user_repass'] != $data['mona_user_pass']) {
            return $this->get_error('error', __('Mật khẩu và xác nhận mật khẩu không trùng khớp', 'monamedia'));
        }
        if (!isset($data['mona_user_name_kanji']) || trim($data['mona_user_name_kanji']) == '') {
            return $this->get_error('error', __('Họ Tên (Kanji) không được trống', 'monamedia'));
        }
        if (!isset($data['mona_user_name_romaji']) || trim($data['mona_user_name_romaji']) == '') {
            return $this->get_error('error', __('Họ Tên (romaji) không được trống', 'monamedia'));
        }
        if (!isset($data['mona_user_birthday']) || trim($data['mona_user_birthday']) == '') {
            return $this->get_error('error', __('Ngày sinh không được trống', 'monamedia'));
        }
        if (!isset($data['mona_user_phone']) || trim($data['mona_user_phone']) == '') {
            return $this->get_error('error', __('Điện thoại không được trống', 'monamedia'));
        }
        if (!isset($data['mona_user_height']) || trim($data['mona_user_height']) == '') {
            return $this->get_error('error', __('Chiều cao không được trống', 'monamedia'));
        }
        if (!isset($data['mona_user_weight']) || trim($data['mona_user_weight']) == '') {
            return $this->get_error('error', __('Cân nặng không được trống', 'monamedia'));
        }
        if (!isset($data['mona_user_hv']) || trim($data['mona_user_hv']) == '') {
            return $this->get_error('error', __('Học vấn không được trống', 'monamedia'));
        }
        if (!isset($data['mona_user_hon_nhan']) || trim($data['mona_user_hon_nhan']) == '') {
            return $this->get_error('error', __('Hôn nhân không được trống', 'monamedia'));
        }
        if (!isset($data['mona_user_nghe_nghiep']) || trim($data['mona_user_nghe_nghiep']) == '') {
            return $this->get_error('error', __('Nghề nghiệp không được trống', 'monamedia'));
        }
        if (!isset($data['mona_user_thu_nhap']) || trim($data['mona_user_thu_nhap']) == '') {
            return $this->get_error('error', __('Thu nhập không được trống', 'monamedia'));
        }
        return true;
    }

    public function get_error($status, $message) {
        return array('status' => $status, 'message' => $message);
    }

}
