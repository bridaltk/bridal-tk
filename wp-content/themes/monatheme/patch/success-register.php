<div class="box__input">
    <?php
    global $new_user;
    $user = $new_user;
    $user_data = $user->get_user_data();
    if (mona_iswp_error($user_data)) {
        echo '<div class="title"><h3 class="fz-24 sub-title2" style=" color: red; font-weight: normal; ">' . __('Không lấy được data', 'monamedia') . '</h3></div>';
    } else {
        $default = $user->get_default_meta();
        ?>
        <div class="title"><h3 class="fz-24 sub-title2" style=" color: #4CAF50; font-weight: normal; "><?php _e('Đăng ký thành công', 'monamedia'); ?></h3></div>
        <div class="content success-register">
            <div><strong class="line"><?php _e('Tên đăng nhập', 'monamedia') ?> :</strong> <p class="valum"><?php echo @$user_data['_login']; ?></p> </div> 
            <div><strong class="line"><?php _e('Email', 'monamedia') ?>: </strong> <p class="valum"><?php echo $user_data['_email']; ?></p> </div> 
            <?php
            foreach ($default as $k => $v) {
                if (isset($user_data[$k]) && $user_data[$k] != '') {
                    $valumc = $user_data[$k];
                    if ($k == '_hoc_van') {
                        $valumc = mona_filter_hv_user($user_data[$k]);
                    }elseif ($k == '_honnhan'){
                        $arg = array(
                            'chua_ket_hon'=>__('Chưa kết hôn','monamedia'),
                            'tai_hon'=>__('Tái hôn','monamedia'),
                        );
                        if(isset($arg[$user_data[$k]])){
                            $valumc = $arg[$user_data[$k]];
                        }else{
                             $valumc = __('Không cung cấp','monamedia');
                        }
                    }
                    ?>
                    <div><strong class="line"><?php echo $v['label'] ?> :</strong> <div class="valum"><?php echo wpautop($valumc); ?></div> </div> 
                    <?php
                }
            }
            if (isset($user_data['_thumbnail'])) {
                echo '<div><strong class="line img">' . __('Avatar', 'monamedia') . ': </strong>' . wp_get_attachment_image($user_data['_thumbnail'], 'thumbnail') . '</div>';
            }
            if (isset($user_data['_gallery'])) {
                if (is_array($user_data['_gallery']) && count($user_data['_gallery']) > 0) {
                    echo '<div><strong class="line img gallery">' . __('Gallery', 'monamedia') . ': </strong>';
                    foreach ($user_data['_gallery'] as $v) {
                        echo wp_get_attachment_image($v, 'thumbnail');
                    }
                    echo '</div>';
                }
            }
            ?>
            <p class="" style="margin-top: 20px;">
                <a  class="primary-btn small-btn" href="<?php echo get_home_url(); ?>"><?php _e('Về Trang Chủ', 'monamedia'); ?></a>
                <a class="primary-btn small-btn" href="<?php echo get_the_permalink(MY_ACCOUNT); ?>"><?php _e('Trang cá nhân', 'monamedia'); ?></a>
            </p>
        </div>
        <?php
    }
    ?>
</div>