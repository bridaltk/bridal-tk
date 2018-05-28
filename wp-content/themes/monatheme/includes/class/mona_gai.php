<?php

class Mona_gai {

    protected $_post_id;
    protected $_postdata;
    protected $_table_data = "mona_gai_data";
    protected $_db;

    public function __construct($post_id) {
        $this->_post_id = $post_id;
        $this->get_post_data();
        global $wpdb;
        $this->_db = $wpdb;
    }

    protected function get_post_data() {
        $this->_postdata = get_post($this->_post_id);
        wp_reset_postdata();
    }

    public function check_row_exist() {
        $check = $this->get_data_table_id();
        if (!$check) {
            $check = $this->create_data_table_blank();
        }
        return $check;
    }

    public function get_data_table_id() {
        $sql = "SELECT `id` FROM {$this->_table_data} WHERE `post_id` ='{$this->_post_id}' ORDER BY `id` DESC LIMIT 0,1";
        $query = $this->_db->get_results($sql);
        if (count($query) > 0 && isset($query[0]->id)) {
            return $query[0]->id;
        };
        return false;
    }

    public function create_data_table_blank() {
        $this->_db->insert($this->_table_data, array('post_id' => $this->_post_id));
        return $this->get_data_table_id();
    }

    public function update_data_table($args, $where) {
        $this->_db->update($this->_table_data, $args, $where);
    }

    public function get_ms() {
        return $this->mona_get_field('mona_gai_ma_hoi_vien');
    }

    public function get_tuoi() {
        $birth = $this->get_birthday();
        if ($birth != '') {
            $exp = explode('/', $birth);
            if (isset($exp[2])) {
                $old = (int) date('Y', time()) - (int) $exp[2];
                if ($old > 0) {
                    return $old;
                }
            }
        }
        return __('Không cung cấp', 'monamedia');
    }

    public function get_day() {
        $ngay = $this->mona_get_field('mona_gai_nhap_hoi');
        return $ngay;
    }

    public function get_ngay_nhaphoi() {
        $ngay = $this->mona_get_field('mona_gai_nhap_hoi');
        $ngay = explode('/', $ngay);
        $ngay = $ngay[2] . __('Năm', 'monamedia') . $ngay[1] . __('Tháng', 'monamedia') . $ngay[0] . __('Ngày', 'monamedia');
        return $ngay;
    }

    public function get_height() {
        return $this->mona_get_field('mona_gai_height');
    }

    public function get_weight() {
        return $this->mona_get_field('mona_gai_weight');
    }

    public function get_hoc_van() {
        return $this->mona_get_field('mona_gai_hoc_van');
    }

    public function get_nghe_nghiep() {
        return $this->mona_get_field('mona_gai_nghe_nghiep');
    }

    public function get_quoc_gia() {
        return $this->mona_get_field('mona_gai_qg');
    }

    public function get_tinh() {
        return $this->mona_get_field('mona_gai_city');
    }

    public function get_sothich() {
        return $this->mona_get_field('mona_gai_hobby');
    }

    public function get_nhom_mau() {
        return $this->mona_get_field('mona_gai_nhom_mau');
    }

    public function get_english() {
        return $this->mona_get_field('mona_gai_english');
    }

    public function get_hon_nhan_status() {
        $stt = $this->mona_get_field('mona_gai_hon_nhan_status');
        if ($stt == 'tai_hon') {
            return __('Tái hôn', 'monamedia');
        }
        return __('Chưa kết hôn', 'monamedia');
    }

    public function get_japanese() {
        return $this->mona_get_field('mona_gai_japanese');
    }

    public function get_tuoi_bo() {
        return $this->mona_get_field('mona_gai_bo_tuoi');
    }

    public function get_nghe_bo() {
        return $this->mona_get_field('mona_gai_bo_nghe_nghiep');
    }

    public function get_tuoi_me() {
        return $this->mona_get_field('mona_gai_me_tuoi');
    }

    public function get_nghe_me() {
        return $this->mona_get_field('mona_gai_me_nghe_nghiep');
    }

    public function get_anh_em() {
        return $this->mona_get_field('mona_gai_so_anh_em');
    }

    public function get_banthan() {
        return $this->mona_get_field('mona_gai_ban_than');
    }

    public function get_note() {
        return $this->mona_get_field('mona_gai_note');
    }

    public function get_format_cao() {
        $cao = $this->get_height();
        return $cao . __(' cm', 'monamedia');
    }

    public function get_format_label($key) {
        $values = array(
            'tieu_hoc' => __('Tốt nghiệp tiểu học', 'monamedia'),
            'trung_hoc' => __('Tốt nghiệp trung học', 'monamedia'),
            'pho_thong' => __('Tốt nghiệp phổ thông', 'monamedia'),
            'trung_cap' => __('Tốt nghiệp trung cấp', 'monamedia'),
            'cao_dang' => __('Tốt nghiệp cao đẳng', 'monamedia'),
            'dai_hoc' => __('Tốt nghiệp đại học', 'monamedia'),
            'vn' => __('Việt nam', 'monamedia'),
            'nhat' => __('Nhật', 'monamedia'),
            'no' => __('Không biết', 'monamedia'),
            'so_cap' => __('Sơ cấp', 'monamedia'),
            'trung_cap' => __('Trung cấp', 'monamedia'),
            'n1' => __('N1', 'monamedia'),
            'n2' => __('N2', 'monamedia'),
            'n3' => __('N3', 'monamedia'),
            'n4' => __('N4', 'monamedia'),
            'n5' => __('N5', 'monamedia'),
        );
        if (isset($values[$key])) {
            return $values[$key];
        }
        return '';
    }

    public function get_data() {
        $data = array(
            array(
                'label' => __('Mã số', 'monamedia'),
                'value' => '#' . $this->get_ms()
            ),
            array(
                'label' => __('Ngày nhập hội', 'monamedia'),
                'value' => $this->get_ngay_nhaphoi()
            ),
            array(
                'label' => __('Lý lịch hôn nhân', 'monamedia'),
                'value' => $this->get_hon_nhan_status()
            ),
            array(
                'label' => __('Tuổi', 'monamedia'),
                'value' => $this->get_tuoi()
            ),
            array(
                'label' => __('Chiều cao', 'monamedia'),
                'value' => $this->get_format_cao($this->get_height())
            ),
            array(
                'label' => __('Cân nặng', 'monamedia'),
                'value' => $this->get_weight()
            ),
            array(
                'label' => __('Học vấn', 'monamedia'),
                'value' => $this->get_format_label($this->get_hoc_van())
            ),
            array(
                'label' => __('Nghề nghiệp', 'monamedia'),
                'value' => $this->get_nghe_nghiep()
            ),
            array(
                'label' => __('Quốc gia', 'monamedia'),
                'value' => $this->get_format_label($this->get_quoc_gia())
            ),
            array(
                'label' => __('Tỉnh thành', 'monamedia'),
                'value' => $this->get_tinh()
            ),
            array(
                'label' => __('Sở thích', 'monamedia'),
                'value' => $this->get_sothich()
            ),
            array(
                'label' => __('Nhóm máu', 'monamedia'),
                'value' => $this->get_nhom_mau()
            ),
            array(
                'label' => __('Trình độ tiếng anh', 'monamedia'),
                'value' => $this->get_format_label($this->get_english())
            ),
            array(
                'label' => __('Trình độ tiếng nhật', 'monamedia'),
                'value' => $this->get_format_label($this->get_japanese())
            ),
            array(
                'label' => __('Ghi chú', 'monamedia'),
                'value' => $this->get_note()
            ),
        );
        return $data;
    }

    public function get_family() {
        $family = array(
            array(
                'label' => __('Tuổi bố', 'monamedia'),
                'value' => $this->get_tuoi_bo()
            ),
            array(
                'label' => __('Nghề nghiệp bố', 'monamedia'),
                'value' => $this->get_nghe_bo()
            ),
            array(
                'label' => __('Tuổi mẹ', 'monamedia'),
                'value' => $this->get_tuoi_me()
            ),
            array(
                'label' => __('Nghề nghiệp mẹ', 'monamedia'),
                'value' => $this->get_nghe_me()
            ),
            array(
                'label' => __('Số anh chị em', 'monamedia'),
                'value' => $this->get_anh_em()
            ),
            array(
                'label' => __('bản thân là con thứ', 'monamedia'),
                'value' => $this->get_banthan()
            ),
        );
        return $family;
    }

    public function get_birthday() {
        return $this->mona_get_field('mona_gai_birthday');
    }

    protected function mona_get_field($field) {
        return get_field($field, $this->_post_id);
    }

}
