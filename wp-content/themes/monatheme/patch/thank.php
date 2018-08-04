<?php
global $global_id, $order_id;
if ($global_id != null && $order_id != null) {
    $user = new Mona_user($global_id);
    $data = $user->get_user_data();
    if (!mona_iswp_error($data)) {
        $user_data_id = $user->get_post_id();
        ?>

        <div class="join-detail__content clear">
            <p class="mona-thank-text"><?php _e('Cảm ơn bạn đã đăng ký!<br> chúng tôi sẻ liên hệ với bạn sớm nhất để xếp lịch', 'monamedia'); ?></p>
            <div class="side-left">
                <h3 class="input__title mona-info-table-title"><strong><?php _e('Thông tin đăng ký', 'monamedia'); ?></strong></h3>
                <div class="wrapper">
                    <table class="mona-input-info">
                        <tr>
                            <td><?php _e('ẢNH ĐẠI DIỆN', 'monamedia'); ?></td>
                            <td><?php echo get_the_post_thumbnail($user_data_id,'medium'); ?></td>
                        </tr>
                        <tr>
                            <td><?php _e('HỌ VÀ TÊN', 'monamedia'); ?></td>
                            <td><?php echo get_the_title($user_data_id); ?></td>
                        </tr>
           
                        <tr>
                            <td><?php _e('Email', 'monamedia'); ?></td>
                            <td><?php echo @$data['_email']; ?></td>
                        </tr>
                        <tr>
                            <td><?php _e('ĐIỆN THOẠI', 'monamedia'); ?></td>
                            <td><?php echo @$data['_phone']; ?></td>
                        </tr>
                        <tr>
                            <td><?php _e('NGHỀ NGHIỆP', 'monamedia'); ?></td>
                            <td><?php echo @$data['_nghe_nghiep']; ?></td>
                        </tr>
                        <tr>
                            <td><?php _e('NƠI Ở', 'monamedia'); ?></td>
                            <td><?php echo @$data['_address']; ?></td>
                        </tr>
                        <tr>
                            <td><?php _e('THỜI GIAN MUỐN ĐI', 'monamedia'); ?></td>
                            <td><?php echo get_post_meta($order_id,'__time_start',true); ?></td>
                        </tr>
                        <tr>
                            <td><?php _e('HỘI VIÊN ĐÃ CHỌN', 'monamedia'); ?></td>
                            <td>
                                <?php
                                $gais = get_post_meta($order_id,'__gai',true);
                                if (is_array($gais)) {
                                    foreach ($gais as $gai) {
                                        echo '<div class="item-view"><div class="img">' . get_the_post_thumbnail($gai, 'thumbnail') . '</div><p>#' . get_field('mona_gai_ma_hoi_vien',$gai) . '</p></div>';
                                    }
                                }
                                ?>
                            </td>
                        <tr>
                            <td><?php _e('GHI CHÚ', 'monamedia'); ?></td>
                            <td><?php echo get_the_content($order_id); ?></td>
                        </tr>
                        </tr>
                    </table>
                    <p class="" style="margin-top: 20px;">
                        <a  class="primary-btn small-btn" href="<?php echo get_home_url(); ?>"><?php _e('Về trang chủ','monamedia'); ?></a>
                        <a class="primary-btn small-btn" href="<?php echo get_the_permalink(MONA_BOOKING); ?>"><?php _e('Đăng ký mới','monamedia'); ?></a>
                    </p>
                </div>
            </div>
        </div>
    <?php }
} ?>