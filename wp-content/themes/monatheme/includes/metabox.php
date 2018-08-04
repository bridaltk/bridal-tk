<?php

function mona_add_metabox() {
    add_meta_box('order-meta', 'Order', 'mona_order_metabox', 'mona_order');
    add_meta_box('khachhang-meta', 'Thông tin khách hàng', 'mona_khach_hang_metabox', 'mona_khach_hang');
    add_meta_box('khachhang-meta-ga', 'Gallery', 'mona_khach_hang_ga_metabox', 'mona_khach_hang', 'side');
}

add_action('add_meta_boxes', 'mona_add_metabox');

function mona_order_metabox($post) {
    
    $gai = get_post_meta($post->ID, '__gai', true);
    $start = get_post_meta($post->ID, '__time_start', true);
    $status = get_post_meta($post->ID, '__status', true);
    $match = get_post_meta($post->ID, '__match', true);
    $author = get_post_field('post_author', $post->ID);
    ?>
    <div class="mona-input-wrapp clear">
        <?php
        $udata = get_userdata($author);
        if ($udata != false) {
            if (@$udata->caps['mona_khac_hang'] == true) {
                $kh= new Mona_user($author);
                $the_id = $kh->get_post_id();
                if(!mona_iswp_error($the_id)){
                ?>
                 <div class="input-wrap">
                    <p> Customer</p>
                    <a href="<?php echo get_edit_post_link($the_id); ?>" target="_blank"><?php echo $udata->data->display_name; ?></a> 
                </div>     
                <?php   
                }
            }
        }
        ?>
        <div class="input-wrap">
            <p>Start day</p>
            <textarea name="mona_ad_user_time_start" ><?php echo $start; ?></textarea>
        </div>    
        <div class="input-wrap">
            <p>Female members</p>
            <select id="chon"   class="mona-select2" multiple="multiple" name="mona_ad_choice_gai[]">
                <?php
                $args = array(
                    'post_type' => 'mona_gai',
                    'posts_per_page' => -1,
                    'order' => 'DESC',
                    'orderby' => 'date',
                );
                $my_query = new WP_Query($args);
                while ($my_query->have_posts()) {
                    $my_query->the_post();
                    $selet = '';
                    if (in_array(get_the_ID(), $gai)) {
                        $selet = 'selected';
                    }
                    echo '<option ' . $selet . ' value="' . get_the_ID() . '" data-img="' . get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') . '">#' . get_field('mona_gai_ma_hoi_vien') . '</option>';
                }
                wp_reset_query();
                ?>
            </select>
        </div> 
        <div class="input-wrap">
            <p>Status</p>
            <select id=""   class=""  name="mona_ad_user_status">
                <option value="doc_than" <?php echo ($status == 'doc_than' ? 'selected' : ''); ?>>Độc thân</option>
                <option value="dinh_hon" <?php echo ($status == 'dinh_hon' ? 'selected' : ''); ?>>Đính hôn</option>
                <option value="ket_hon" <?php echo ($status == 'ket_hon' ? 'selected' : ''); ?>>Kết hôn</option>
            </select>
        </div>
        <div class="input-wrap">
            <p>Match</p>
            <select id="" class="mona-select2-no-multi" name="mona_ad_user_match">
                <option value="">Chọn</option>
                <?php
                while ($my_query->have_posts()) {
                    $my_query->the_post();
                    $selet = '';
                    if (get_the_ID() == $match && $match != '') {
                        $selet = 'selected';
                    }
                    echo '<option ' . $selet . ' value="' . get_the_ID() . '" data-img="' . get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') . '">' . get_the_title() . '</option>';
                }
                wp_reset_query();
                ?>
            </select>
        </div>
    </div>
    <?php
}

function mona_khach_hang_metabox($post) {
    $author = get_post_field('post_author', $post->ID);
    $user = new Mona_user($author);
    $datas = $user->get_user_data();
    $default = $user->get_default_meta();
    $status = get_post_meta($post->ID, '_trang_thai', true);
    $partner = get_post_meta($post->ID, '_hon_the', true);
    $history = get_post_meta($post->ID, '_history', true);
    ?>
    <div class="mona-wrap">
        <div class="mona-user-meta">
            <ul class="list clear">
                <?php
                if (!mona_iswp_error($datas)) {
                    ?>

                    <li>
                        <label>
                            <p>Trạng thái</p>
                            <select class="form-control " name="_trang_thai_admin">
                                <option <?php echo ($status == 'open' ? 'selected' : ''); ?> value="open"><?php _e('Mở', 'monamedia'); ?></option>
                                <option <?php echo ($status == 'dinh_hon' ? 'selected' : ''); ?> value="dinh_hon"><?php _e('Đã đính hôn', 'monamedia'); ?></option>
                                <option <?php echo ($status == 'ket_hon' ? 'selected' : ''); ?> value="ket_hon"><?php _e('Đã kết hôn', 'monamedia'); ?></option>
                                <option <?php echo ($status == 'huy_hon' ? 'selected' : ''); ?> value="huy_hon"><?php _e('Đã hủy hôn', 'monamedia'); ?></option>
                                <option <?php echo ($status == 'ly_hon' ? 'selected' : ''); ?> value="ly_hon"><?php _e('Đã ly hôn', 'monamedia'); ?></option>
                            </select>  
                        </label>
                    </li> 
                    <li>
                        <div>
                            <p>Hôn thê</p>
                            <select class="form-control mona-select2" name="_hon_the_admin" id="">
                                <option value=""></option>
                                <?php
                                $args = array(
                                    'post_type' => 'mona_gai',
                                    'posts_per_page' => -1,
                                    'order' => 'DESC',
                                    'orderby' => 'date',
                                    'meta_query' => array(
                                        array(
                                            'key' => 'mona_gai_hon_nhan',
                                            'value' => 'doc_than',
                                            'compare' => '='
                                        )
                                    )
                                );
                                $my_query = new WP_Query($args);

                                while ($my_query->have_posts()) {
                                    $my_query->the_post();
                                    $selet = '';
                                    if ($partner == get_the_ID()) {
                                        $selet = 'selected';
                                    }
                                    echo '<option ' . $selet . ' value="' . get_the_ID() . '" data-img="' . get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') . '">' . get_field('mona_gai_ma_hoi_vien', get_the_ID()) . '</option>';
                                }
                                ?>
                            </select>      
                        </div>
                    </li>
                    <li>
                        <label>
                            <p>Email</p>
                            <input disabled type="text" name="_email_admin" class="_email" value="<?php echo $datas['_email']; ?>"/>
                        </label>
                    </li>    
                    <?php
                    foreach ($default as $k => $v) {
                        ?>
                        <li>
                            <label>
                                <p><?php echo $v['label']; ?></p>
                                <?php
                                if ($k == '_blood_type') {
                                    ?>
                                    <select class="form-control <?php echo $k; ?>" name="_blood_type_admin">
                                        <option  value=""><?php _e('Chọn', 'monamedia'); ?></option>
                                        <option <?php echo (@$datas[$k] == 'A' ? 'selected' : ''); ?> value="A"><?php _e('A', 'monamedia'); ?></option>
                                        <option <?php echo (@$datas[$k] == 'B' ? 'selected' : ''); ?> value="B"><?php _e('B', 'monamedia'); ?></option>
                                        <option <?php echo (@$datas[$k] == 'AB' ? 'selected' : ''); ?> value="AB"><?php _e('AB', 'monamedia'); ?></option>
                                        <option <?php echo (@$datas[$k] == 'O' ? 'selected' : ''); ?> value="O"><?php _e('O', 'monamedia'); ?></option>
                                    </select>   
                                    <?php
                                } elseif ($k == '_hoc_van') {
                                    ?><select class="form-control <?php echo $k; ?>" name="_hoc_van_admin" required>
                                        <option value=""><?php _e('Chọn', 'monamedia'); ?></option>
                                        <option  <?php echo (@$datas[$k] == 'tieu_hoc' ? 'selected' : ''); ?> value="tieu_hoc"><?php _e('Tiểu học', 'monamedia'); ?></option>
                                        <option <?php echo (@$datas[$k] == 'trung_hoc' ? 'selected' : ''); ?> value="trung_hoc"><?php _e('Trung học', 'monamedia'); ?></option>
                                        <option <?php echo (@$datas[$k] == 'pho_thong' ? 'selected' : ''); ?> value="pho_thong"><?php _e('Phổ thông', 'monamedia'); ?></option>
                                        <option <?php echo (@$datas[$k] == 'trung_cap' ? 'selected' : ''); ?> value="trung_cap"><?php _e('Trung cấp', 'monamedia'); ?></option>
                                        <option <?php echo (@$datas[$k] == 'cao_dang' ? 'selected' : ''); ?> value="cao_dang"><?php _e('Cao đẳng', 'monamedia'); ?></option>
                                        <option <?php echo (@$datas[$k] == 'dai_hoc' ? 'selected' : ''); ?> value="dai_hoc"><?php _e('Đại học', 'monamedia'); ?></option>
                                    </select> <?php
                                } elseif ($k == '_honnhan') {
                                    ?>
                                    <select class="form-control <?php echo $k; ?>" name="_honnhan_admin" required>
                                        <option value=""><?php _e('Chọn', 'monamedia'); ?></option>
                                        <option <?php echo (@$datas[$k] == 'chua_ket_hon' ? 'selected' : ''); ?> value="chua_ket_hon"><?php _e('Chưa kết hôn', 'monamedia'); ?></option>
                                        <option <?php echo (@$datas[$k] == 'tai_hon' ? 'selected' : ''); ?> value="tai_hon"><?php _e('Tái hôn', 'monamedia'); ?></option>
                                    </select>    
                                    <?php
                                } elseif ($k == '_address' || $k == '_so_thich' || $k == '_contact') {
                                    ?>
                                    <textarea class="form-control <?php echo $k; ?>" name="<?php echo $k . '_admin'; ?>"><?php echo @$datas[$k]; ?></textarea>
                                    <?php
                                } else {
                                    ?>
                                    <input type="text" name="<?php echo $k . '_admin'; ?>" class="<?php echo $k; ?>" value="<?php echo @$datas[$k]; ?>"/>
                                    <?php
                                }
                                ?>

                            </label>
                        </li>    
                        <?php
                    }
                }
                ?>

            </ul>
        </div>
        <p>Lịch sử Trạng thái</p>
        <ul class="list-hist">
            <?php
            foreach ($history as $hs) {
                if (@$hs['label'] != '') {
                    ?><li>
                        <p><strong style=" color: #0085ba; "><?php echo @$hs['time']; ?>:</strong>   <?php echo mona_filter_status_user(@$hs['label']); ?></p>
                    </li><?php
                }
            }
            ?>
        </ul>
    </div>
    <link rel="stylesheet" href="<?php echo get_site_url() ?>/template/js/bootstrap-datepicker/bootstrap-datepicker.standalone.css"/>
    <script src="<?php echo site_url(); ?>/template/js/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script>
        jQuery(document).ready(function ($) {

            $('._birthday').datepicker({
                todayHighlight: true,
                format: 'mm/dd/yyyy',
                endDate: new Date()
            });
        });</script>
    <?php
}

function mona_khach_hang_ga_metabox($post) {
    $gas = get_post_meta($post->ID, '_gallery', true);
    wp_enqueue_media();
    ?>
    <div class="mona-wrap" id="mona-wrap-gallery">
        <div class="mona-ga-view">
            <input type="hidden" name="mona_is_admin_page" value="true"/>
            <ul class="list clear">
                <?php
                if (is_array($gas)) {
                    foreach ($gas as $v) {
                        ?>
                        <li>
                            <div class="img"><?php echo wp_get_attachment_image($v, 'thumbnail'); ?></div>
                            <input type="hidden" name="mona_gallery_item[]" value="<?php echo $v; ?>"/>
                            <span class="dashicons dashicons-dismiss"></span>
                        </li>    
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
        <p><button  type="button" class="button" id="mona-add-gallery-btn">Thêm Ảnh</button></p>
    </div>    
    <script>
        jQuery(document).ready(function ($) {
            $(document).on('click', '#mona-wrap-gallery .list li .dashicons', function () {
                $(this).closest('li').slideUp().remove();
            });
            $('#mona-add-gallery-btn').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                var custom_uploader;
                custom_uploader = wp.media.frames.file_frame = wp.media({
                    title: 'Gallery',
                    button: {
                        text: 'Choice'
                    },
                    library: {type: 'image'},
                    multiple: true
                });
                //When a file is selected, grab the URL and set it as the text field's value
                custom_uploader.on('select', function () {
                    console.log(custom_uploader.state());
                    var selection = custom_uploader.state().get('selection');
                    selection.map(function (attachment) {
                        attachment = attachment.toJSON();
                        console.log(attachment);
                        var $html = '<li> <div class="img"><img src="' + attachment.url + '"/></div> <input type="hidden" name="mona_gallery_item[]" value="' + attachment.id + '"/> <span class="dashicons dashicons-dismiss"></span> </li>';
                        $this.closest('#mona-wrap-gallery').find('.mona-ga-view .list').append($html);
                    });
                });
                //Open the uploader dialog
                custom_uploader.open();
            });
        });
    </script>
    <?php
}

function mona_save_metabox($post_id) {
    $ptype = get_post_type($post_id);
    if ($ptype == 'mona_order') {
        update_post_meta($post_id, '__email', @$_POST['mona_ad_user_email']);
        update_post_meta($post_id, '__phone', @$_POST['mona_ad_user_phone']);
        update_post_meta($post_id, '__display_name', @$_POST['mona_ad_user_name']);
        update_post_meta($post_id, '__old', @$_POST['mona_ad_user_old']);
        update_post_meta($post_id, '__nghe_nghiep', @$_POST['mona_ad_user_nghe_nghiep']);
        update_post_meta($post_id, '__address', @$_POST['mona_ad_user_address']);
        update_post_meta($post_id, '__gai', @$_POST['mona_ad_choice_gai']);
        update_post_meta($post_id, '__time_start', @$_POST['mona_ad_user_time_start']);
        $sttatus =@$_POST['mona_ad_user_status'];
        if(@$_POST['mona_ad_user_status']==''){
            $sttatus = 'doc_than';
        }
        update_post_meta($post_id, '__status', $sttatus);
        update_post_meta($post_id, '__match', @$_POST['mona_ad_user_match']);
    }
    if ($ptype == 'mona_gai') {
        $ms = get_field('mona_gai_ma_hoi_vien', $post_id);
        if ($ms == '') {
            $format = 8;
            $num = strlen($post_id);
            $leng = $format - $num;
            $ran = generateRandomString($leng);
            $ms = $ran . $post_id;
            update_field('mona_gai_ma_hoi_vien', $ms, $post_id);
            wp_update_post(array(
                'ID' => $post_id,
                'post_name' => $ms
            ));
        }
    }
    if ($ptype == 'mona_khach_hang') {
        if (isset($_POST['mona_is_admin_page'])) {
            $ga = @$_POST['mona_gallery_item'];
            $ga = (array) $ga;
            update_post_meta($post_id, '_gallery', $ga);
            $tt_old = get_post_meta($post_id, '_trang_thai', true);
            $his = get_post_meta($post_id, '_history', true);
            $author = get_post_field('post_author', $post_id);
            $user = new Mona_user($author);
            $datas = $user->get_user_data();
            $default = $user->get_default_meta();
            if (@$_POST['_trang_thai_admin'] == 'open' || @$_POST['_trang_thai_admin'] == '') {
                update_post_meta($post_id, '_trang_thai', 'open');
                update_post_meta($post_id, '_hon_the', '');
            } elseif (@$_POST['_trang_thai_admin'] != 'open' && @$_POST['_trang_thai_admin'] != '') {
                if (@$_POST['_hon_the_admin'] != '') {
                    update_post_meta($post_id, '_trang_thai', @$_POST['_trang_thai_admin']);
                    update_post_meta($post_id, '_hon_the', @$_POST['_hon_the_admin']);
                }
            }
            if ($tt_old != @$_POST['_trang_thai_admin']) {
                $his[] = array('time' => current_time('mysql'), 'label' => $tt_old);
                update_post_meta($post_id, '_history', $his);
            }
            if (!mona_iswp_error($datas)) {
                foreach ($default as $k => $v) {
                    update_post_meta($post_id, $k, @$_POST[$k . '_admin']);
                }
            }
        }
    }
    update_post_meta($post_id, '_date_update', current_time('d /m/ y H:i:s'));
}

add_action('save_post', 'mona_save_metabox');

function mona_afc_save_post($post_id) {
    $ptype = get_post_type($post_id);
    if ($ptype == 'mona_gai') {
        $gais = new Mona_gai($post_id);
        $data_id = $gais->check_row_exist();
        $nhaphoi = get_field('mona_gai_nhap_hoi', $post_id);
        if ($nhaphoi != '') {
            $nhaphoi = explode('/', $nhaphoi);
            $nhaphoi = @$nhaphoi[2] . @$nhaphoi[1] . @$nhaphoi[0];
        }
        $birthday = get_field('mona_gai_birthday', $post_id);
        if ($birthday != '') {
            $birthday = explode('/', $birthday);
            $birthday = @$birthday[2] . @$birthday[1] . @$birthday[0];
        }
        $args = array(
            'mhv' => get_field('mona_gai_ma_hoi_vien', $post_id),
            'ngay_nhap_hoi' => $nhaphoi,
            'height' => get_field('mona_gai_height', $post_id),
            'weight' => get_field('mona_gai_weight', $post_id),
            'quocgia' => get_field('mona_gai_qg', $post_id),
            'birthday' => $birthday,
            'hocvan' => get_field('mona_gai_hoc_van', $post_id),
        );
        $where = array(
            'post_id' => $post_id,
            'id' => $data_id
        );
        $gais->update_data_table($args, $where);
    }
}

add_action('acf/save_post', 'mona_afc_save_post', 20);
