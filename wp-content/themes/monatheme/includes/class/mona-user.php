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
    protected $_user_post_id = null;
    protected $_default_user_meta = array();

    public function __construct($user_id = '') {
        if ($user_id == '') {
            $user_id = null;
            if (is_user_logged_in()) {
                $user_id = get_current_user_id();
            }
        }
        $this->_user_id = $user_id;
        if ($this->_user_id != NULL) {
            if ($this->_user_post_id == null) {
                $post_id = $this->get_post_id();
                if (!mona_iswp_error($post_id)) {
                    $this->_user_post_id = $post_id;
                }
            }
        }
        $this->_default_user_meta = array(
            '_ten_kanji' => array(
                'label' => __('Tên Kanji', 'monamedia'),
                'value' => 'mona_user_name_kanji'
            ),
            '_ten_romaji' => array(
                'label' => __('Tên Romaji', 'monamedia'),
                'value' => 'mona_user_name_romaji'
            ),
            '_birthday' => array(
                'label' => __('Ngày sinh', 'monamedia'),
                'value' => 'mona_user_birthday'
            ),
            '_phone' => array(
                'label' => __('Điện thoại', 'monamedia'),
                'value' => 'mona_user_phone'
            ),
            '_height' => array(
                'label' => __('Chiều cao', 'monamedia'),
                'value' => 'mona_user_height'
            ),
            '_weight' => array(
                'label' => __('Cân nặng', 'monamedia'),
                'value' => 'mona_user_weight'
            ),
            '_blood_type' => array(
                'label' => __('Nhóm máu', 'monamedia'),
                'value' => 'mona_user_nhom_mau'
            ),
            '_hoc_van' => array(
                'label' => __('Học vấn', 'monamedia'),
                'value' => 'mona_user_hv'
            ),
            '_honnhan' => array(
                'label' => __('Hôn nhân', 'monamedia'),
                'value' => 'mona_user_hon_nhan'
            ),
            '_nghe_nghiep' => array(
                'label' => __('Nghề nghiệp', 'monamedia'),
                'value' => 'mona_user_nghe_nghiep'
            ),
            '_thu_nhap' => array(
                'label' => __('Thu nhập', 'monamedia'),
                'value' => 'mona_user_thu_nhap'
            ),
            '_address' => array(
                'label' => __('Địa chỉ', 'monamedia'),
                'value' => 'mona_user_address'
            ),
            '_so_thich' => array(
                'label' => __('Sở thích', 'monamedia'),
                'value' => 'mona_user_hobby'
            ),
            '_tuoi_bo' => array(
                'label' => __('Tuổi bố', 'monamedia'),
                'value' => 'mona_user_tuoi_bo'
            ),
            '_nghe_bo' => array(
                'label' => __('Nghề nghiệp bố', 'monamedia'),
                'value' => 'mona_user_nghe_bo'
            ),
            '_tuoi_me' => array(
                'label' => __('Tuổi mẹ', 'monamedia'),
                'value' => 'mona_user_tuoi_me'
            ),
            '_nghe_me' => array(
                'label' => __('Nghề nghiệp mẹ', 'monamedia'),
                'value' => 'mona_user_nghe_me'
            ),
            '_anh_chi_em' => array(
                'label' => __('Số anh chị em', 'monamedia'),
                'value' => 'mona_user_anh_em'
            ),
            '_ban_than' => array(
                'label' => __('Thứ tự bản thân', 'monamedia'),
                'value' => 'mona_user_ban_than'
            ),
            '_contact' => array(
                'label' => __('Liên lạc', 'monamedia'),
                'value' => 'mona_user_contact'
            ),
        );
    }

    public function register_user($data, $fulldata = true) {
        if ($fulldata == true) {
            $check = $this->check_before_insert($data);
            if (mona_iswp_error($check)) {
                return $check;
            }
        }
        $uid = $this->insert_user($data);
        if (mona_iswp_error($uid)) {
            return $uid;
        }
        $this->_user_id = $uid;
        if ($fulldata == true) {
            wp_signon(array(
                'user_login' => $data['mona_user_name'],
                'user_password' => $data['mona_user_pass'],
            ));
        }

        $post_id = $this->inser_post_temp();
        if (mona_iswp_error($post_id)) {
            return $post_id;
        }
        $this->_user_post_id = $post_id;
        $update_post_data = $this->update_post_data($data);
        if (mona_iswp_error($update_post_data)) {
            return $update_post_data;
        }
        return $uid;
    }

    public function get_user_data() {
        if ($this->_user_id == null) {
            return $this->get_error('error', __('Không tồn tại user', 'monamedia'));
        }
        if ($this->_user_post_id == null) {
            $post_id = $this->get_post_id();
            if (!mona_iswp_error($post_id)) {
                $this->_user_post_id = $post_id;
            }
        }

        $userdata = get_userdata($this->_user_id);
        $output = array(
            '_login' => $userdata->user_login,
            '_email' => $userdata->user_email,
        );
        foreach ($this->_default_user_meta as $k => $v) {
            $output[$k] = get_post_meta($this->_user_post_id, $k, true);
        }
        $output['_thumbnail'] = get_post_thumbnail_id($this->_user_post_id);
        $output['_gallery'] = get_post_meta($this->_user_post_id, '_gallery', true);
        return $output;
    }

    public function get_post_id() {
        if ($this->_user_id == null) {
            return $this->get_error('error', __('Không tồn tại user', 'monamedia'));
        }
        $args = array(
            'post_type' => 'mona_khach_hang',
            'posts_per_page' => 1,
            'order' => 'DESC',
            'orderby' => 'date',
            'author' => $this->_user_id,
            'post_status' => array('publish', 'pending')
        );
        $posts = new WP_Query($args);
        if ($posts->have_posts()) {
            $posts->the_post();
            return get_the_ID();
        } else {
            return $this->get_error('error', __('Không tồn tại user data', 'monamedia'));
        }
        wp_reset_query();
    }

    protected function insert_user($data) {
        $userdata = array(
            'user_login' => @$data['mona_user_name'],
            'user_pass' => @$data['mona_user_pass'],
            'user_email' => @$data['mona_user_email'],
            'nickname' => @$data['mona_user_name_romaji'],
            'user_nicename' => @$data['mona_user_name_romaji'],
            'first_name' => @$data['mona_user_name_kanji'],
            'last_name' => @$data['mona_user_name_romaji'],
            'display_name' => @$data['mona_user_name_kanji'],
            'role' => 'mona_khac_hang',
            'show_admin_bar_front' => false
        );
        $user_id = wp_insert_user($userdata);
        if (is_wp_error($user_id)) {
            return $this->get_error('error', $user_id->get_error_message());
        }
        add_user_meta($user_id, '__none_active', 'true');
        return $user_id;
    }

    protected function inser_post_temp() {
        if ($this->_user_id == null) {
            return $this->get_error('error', __('Không tồn tại khách hàng', 'monamedia'));
        }
        $userdata = get_userdata($this->_user_id);
        $post_args = array(
            'post_author' => $this->_user_id,
            'post_title' => $userdata->data->display_name,
            'post_type' => 'mona_khach_hang',
            'post_name' => $userdata->user_login,
            'post_status' => 'pending',
        );
        $insert = wp_insert_post($post_args);
        if (is_wp_error($insert)) {
            return $this->get_error('error', $insert->get_error_messages());
        }
        return $insert;
    }

    protected function update_post_data($data) {
        $postargs = array(
            'ID' => $this->_user_post_id,
            'post_status' => 'publish',
            'meta_input' => array(),
        );
        $title = '';
        if (isset($data['mona_user_name_kanji'])) {
            $title .=$data['mona_user_name_kanji'];
        }

        if ($title != '') {
            $postargs['post_title'] = $title;
        }
        foreach ($this->_default_user_meta as $k => $v) {
            if (isset($data[$v['value']])) {
                $postargs['meta_input'][$k] = $data[$v['value']];
            }
        }
        if (isset($data['thumbnail'])) {
            $thumb = mona_upload_image($data['thumbnail']);
            $thumb_id = mona_create_attachment($thumb);
            $postargs['meta_input']['_thumbnail_id'] = $thumb_id;
        }
        if (isset($data['gallery'])) {
           
            $postargs['meta_input']['_gallery'] = $data['gallery'];
        }
        $postargs['meta_input']['_hon_the'] = '';
        $postargs['meta_input']['_trang_thai'] = 'open';
        $postargs['meta_input']['_history'] = array('time' => current_time('mysql'), 'label' => '');
        $update = wp_update_post($postargs);
        if ($update == 0) {
            return $this->get_error('error', __('Không cập nhật được data khách hàng', 'monamedia'));
        }
        return $update;
    }

    public function update_my_profile($data) {
        $postargs = array(
            'ID' => $this->_user_post_id,
            'post_status' => 'publish',
            'meta_input' => array(),
        );
        $title = '';
        if (isset($data['mona_user_name_kanji'])) {
            $title .=$data['mona_user_name_kanji'];
        }

        if ($title != '') {
            $postargs['post_title'] = $title;
        }
        foreach ($this->_default_user_meta as $k => $v) {
            if (isset($data[$v['value']])) {
                $postargs['meta_input'][$k] = $data[$v['value']];
            }
        }
        if (isset($data['thumbnail'])) {
            $thumb = mona_upload_image($data['thumbnail']);
            $thumb_id = @mona_create_attachment($thumb);
            $postargs['meta_input']['_thumbnail_id'] = $thumb_id;
        }
        $postargs['meta_input']['_gallery'] = $data['gallery'];
        $update = wp_update_post($postargs);
        if ($update == 0) {
            return $this->get_error('error', __('Không cập nhật được data khách hàng', 'monamedia'));
        }
        return $update;
    }
    
    
    public function get_default_meta() {
        return $this->_default_user_meta;
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
