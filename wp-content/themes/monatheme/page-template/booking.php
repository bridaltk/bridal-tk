<?php
/**
 * Template name: Booking Page
 * @author : Hy Hý
 */
get_header();
while (have_posts()):
    the_post();
    $error = array();
    $success = '';
    if (is_user_logged_in()) {
        $u = get_userdata(get_current_user_id());
        if (in_array('mona_khac_hang', $u->roles)) {
             
            $user = new Mona_user(get_current_user_id());
            $post_id = $user->get_post_id();
           
            $userdata = $user->get_user_data(get_current_user_id());
        }
    }
    if (isset($_POST) && count($_POST) > 0) {
        $uid = '';
        if (is_user_logged_in()) {
            $uid = get_current_user_id();
        } else {
            $check = get_user_by('email', $_POST['mona_user_email']);
            if ($check == false) {
                $check = get_user_by('login', $_POST['mona_user_email']);
            }
            if ($check == false) {
                $user_class = new Mona_user();
                $data = $_POST;
                $data['mona_user_name'] = $_POST['mona_user_email'];
                $data['user_pass'] = null;
                if (isset($_FILES['mona_user_avatar'])) {
                    $data['thumbnail'] = $_FILES['mona_user_avatar'];
                }
                if (isset($_FILES['mona_user_gallery'])) {
                    $data['gallery'] = @$_POST['mona_user_gallery_ids'];
                }
                $uid = $user_class->register_user($data, false);
            } else {
                $error[] = __('Email đã có người sử dụng', 'monamedia');
            }
        }
        if ($uid != '') {
            $user = new Mona_user($uid);
            $post_id = $user->get_post_id();
            $userdata = $user->get_user_data($uid);
            $postarr = array(
                'post_type' => 'mona_order',
                'post_title' => get_the_title($post_id),
                'post_status' => 'pending',
                'post_author' => $uid,
                'post_content' => @$_POST['mona_user_note'],
            );
            $insert = wp_insert_post($postarr);
            $meta = array(
                '__time_start' => $_POST['mona_user_date_start'],
                '__gai' => $_POST['mona_choice_gai'],
            );
            if (!is_wp_error($insert)) {
                foreach ($meta as $k => $v) {
                    update_post_meta($insert, $k, $v);
                }
                $success = true;
                $global_id = $uid;
                $order_id = $insert;
            } else {
                $error[] = $insert->get_error_message();
            }
        }
    }
    ?>
    <main>
        <div class="account  section-wrap">
            <?php if (!wp_is_mobile()) : ?>
                <div class="flower-right bot">
                    <img src="<?php echo get_site_url(); ?>/template/images/flower-right.png" alt="bg flower">
                </div>
            <?php endif; ?>

            <div class="flower-fall-2">
                <img src="<?php echo get_site_url(); ?>/template/images/flower-fall-2.png" alt="flower">
            </div>

            <div class="all">

                <div class="section-title">
                    <h1 class="fz-36 f-title"><?php _e('Đăng ký gặp mặt', 'monamedia'); ?></h1>
                </div>

                <div class="join-detail__content clear">
                    <div class="side-left">

                    <ul class="list">
                        <li class="item " >
                            <div class="icon"><i class="fas fa-fw fa-user"></i></div>
                            <div class="info"><h4 class="fz-18"><a href="<?php echo get_the_permalink(MY_ACCOUNT); ?>"><?php _e('Quản lý tài khoản', 'monamedia'); ?></a></h4></div>
                        </li>
                        <li class="item ">
                            <div class="icon"><i class="far fa-fw fa-clock"></i></div>
                            <div class="info"><h4 class="fz-18"><a href="<?php echo get_the_permalink(MY_ACCOUNT); ?>/chuyen-di/"><?php _e('Chuyến đi', 'monamedia');   ?></a></h4></div>
                        </li>
                        <li class="item active">
                            <div class="icon"><i class="far fa-address-card"></i></div>
                            <div class="info"><h4 class="fz-18"><a href="<?php echo get_the_permalink(MONA_BOOKING);   ?>"><?php _e('Đăng ký gặp mặt', 'monamedia');   ?></a></h4></div>
                        </li>
                        <li class="item " >
                            <div class="icon"><i class="fas fa-fw fa-lock"></i></div>
                            <div class="info"><h4 class="fz-18"><a href="<?php echo get_the_permalink(MY_ACCOUNT); ?>/doi-mat-khau/"><?php _e('Thay đổi mật khẩu', 'monamedia'); ?></a></h4></div>
                        </li>
                        <li class="item">
                            <div class="icon"><i class="fas fa-fw fa-sign-out-alt"></i></div>
                            <div class="info"><h4 class="fz-18"><a class="mona-logout-action" href="<?php echo wp_logout_url(get_home_url()); ?>"><?php _e('Đăng xuất', 'monamedia'); ?></a></h4></div>
                        </li>
                    </ul>
                </div>
                    <div class="side-right join">
                    <?php
                       
                    if (is_user_logged_in() && (!in_array('mona_khac_hang', $u->roles) || mona_iswp_error($post_id) || @$post_id == '')) {
                        ?>
                        <p class="mona-thank-text" style="color:red;"><?php _e('Oops! Tài khoản của bạn không đủ quyền để thao tác trên trang này', 'monamedia'); ?></p>   
                        <p class="mona-thank-text" style="color:red;"><?php _e('Phiền bạn ', 'monamedia'); ?><a href="<?php echo esc_url(wp_logout_url('//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])); ?>" style=" color: #528ee2; font-weight: bold; text-decoration: underline; "><?php _e('đăng xuất', 'monamedia'); ?></a><?php _e(' để tiếp tục', 'monamedia'); ?></p>   

                        <?php
                    } else {
                        ?>
                        
                            <?php
                            if ($success == true) {
                                unset($_POST);
                                unset($_FILES);
                                get_template_part('patch/thank');
                            } else {
                                ?>
                                <div class="mona-error-register">
                                    <ul class="mona-error" id="mona-error">
                                        <?php
                                        if (count($error) > 0) {
                                            echo '<li>' . implode('</li><li>', $error) . '</li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <?php
                                if (!is_user_logged_in()) {
                                    ?><div class="note"><strong><i style="color: red;">＊</i><?php _e(' Note:', 'monamedia'); ?> </strong><em><?php _e(' Bạn phải ', 'monamedia'); ?><a href="<?php echo get_the_permalink(MONA_LOGIN); ?>?redierect=<?php echo '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" style=" color: #2748a3; font-weight: bold; "><?php _e('đăng nhập', 'monamedia'); ?></a> <?php _e(' để tiếp tục thao tác', 'monamedia'); ?></em></div><?php
                                }else{
                                ?>

                                <form method="post" action="" enctype="multipart/form-data" id="mona-booking-form-submit">
                                    <?php
                                    if (!is_user_logged_in()) {
                                       // get_template_part('patch/booking', 'login');
                                    }
                                    ?>
                                    <div class="box__input">
                                        <div class="title"><div class="input__child full"><h3 class="fz-24 sub-title2"><?php _e('Thông tin đăng ký gặp mặt','monamedia'); ?></h3></div></div>
                                        <div class="content">
                                            <?php if (@$post_id != '') {
                                                ?>
                                                <div class="input__child full  mona-choice-avatar-wrapp">

                                                    <div class="form add-img" style="background-image: url(<?php echo (@$post_id != '' ? get_the_post_thumbnail_url($post_id, 'mona_thumb') : ''); ?>);"></div>
                                                    <h6 class="input__title"><?php echo (@$post_id != '' ? get_the_title($post_id) : ''); ?></h6>
                                                </div>   
                                            <?php }
                                            ?>

                                            <div class="input__child full">
                                                <h6 class="input__title"><?php _e('Hội viên bạn yêu thích', 'monamedia'); ?></h6>
                                                <div class="form select2">

                                                    <select id="chon"  required class="select2 form-control " multiple="multiple" name="mona_choice_gai[]">
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
                                                        $str = '';
                                                        if (isset($_GET['choice'])) {
                                                            $pid = url_to_postid($_GET['choice']);
                                                            if ($pid > 0) {
                                                                $str = $pid;
                                                            }
                                                        }
                                                        while ($my_query->have_posts()) {
                                                            $my_query->the_post();
                                                            $selet = '';
                                                            if ($str != '' && $str == get_the_ID()) {
                                                                $selet = 'selected';
                                                            }
                                                            echo '<option ' . $selet . ' value="' . get_the_ID() . '" data-img="' . get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') . '">' . get_field('mona_gai_ma_hoi_vien') . '</option>';
                                                        }
                                                        wp_reset_query();
                                                        ?>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title"><?php _e('Thời gian muốn đi', 'monamedia'); ?></h6>
                                                <div class="form">
                                                    <input type="text" required class="form-control input-futures" name="mona_user_date_start">
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title"><?php _e('Ghi chú', 'monamedia'); ?></h6>
                                                <div class="form">
                                                    <textarea type="text"  class="form-control" name="mona_user_note"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="br br-small">
                                        <i class="diamond"></i>
                                        <i class="diamond"></i>
                                    </div>
                                    <div class="box__input">
                                        <div class="button input__child full">
                                            <button type="submit" id="mona-submit-button" class="btn btn-1 btn-fullw"><?php _e('Đăng ký gặp mặt', 'monamedia'); ?></button>
                                        </div>
                                    </div>
                                </form>
                            <?php }
                            }?>
                        


                        <?php
                    }
                    ?>
                      </div>              
                </div>

            </div>


        </div>
    </div>

    </main>
    <?php
endwhile;
get_footer();
?>
<script>
    jQuery(document).ready(function ($) {

        function format(state) {
            if (!state.id)
                return state.text; // optgroup
            var originalOption = state.element;
            var $img = $(originalOption).attr('data-img');
            if ($img != '') {
                return "<img class='avatar' src='" + $img + "'/>" + state.text;
            }

        }
        $("#chon").select2({
           placeholder: "<?php _e('Chọn', 'monamedia'); ?>",
            multiple: true,
            allowClear: true,
            //    matcher: matchCustom,
            width: "100%",
            templateResult: format,
            escapeMarkup: function (m) {
                return m;
            },
        });
    });
</script>