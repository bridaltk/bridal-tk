<?php
get_header();
while (have_posts()):
    the_post();
    $error = '';
    $success = '';
    if (isset($_POST) && count($_POST) > 0 && isset($_POST['mona_user_email']) && isset($_POST['mona_user_phone'])) {
        $user = get_user_by('email', $_POST['mona_user_email']);
        if ($user == false) {
            $user_id = wp_insert_user(array(
                'user_login' => $_POST['mona_user_email'],
                'user_pass' => md5($_POST['mona_user_phone']),
                'user_email' => $_POST['mona_user_email'],
                'first_name' => @$_POST['mona_user_display_name'],
                'last_name' => @$_POST['mona_user_display_name'],
                'display_name' => @$_POST['mona_user_display_name'],
                'role' => 'mona_khac_hang'
            ));
            if (!is_wp_error($user_id)) {
                $user = get_userdata($user_id);
                update_user_meta($user->data->ID, '__phone', $_POST['mona_user_phone']);
            }
        }
        $postarr = array(
            'post_type' => 'mona_order',
            'post_title' => '#order-' . @$_POST['mona_user_email'],
            'post_status' => 'pending',
            'post_author' => @$user->ID,
            'meta_input' => array(),
            'post_content' => @$_POST['mona_user_note'],
        );
        if (isset($_FILES['mona_user_avatar'])) {
            $attm = mona_upload_image($_FILES['mona_user_avatar']);
            if ($attm) {
                $attm_id = mona_create_attachment($attm);
                $postarr['meta_input']['_thumbnail_id'] = $attm_id;
                 update_user_meta(@$user->data->ID, '__avatar', $attm_id);
            }
        }
        $insert = wp_insert_post($postarr);
        if (is_wp_error($insert)) {
            $error = $insert->get_error_message();
        } else {
            $meta = array(
                '__email' => @$_POST['mona_user_email'],
                '__phone' => @$_POST['mona_user_phone'],
                '__display_name' => @$_POST['mona_user_display_name'],
                '__old' => @$_POST['mona_user_old'],
                '__nghe_nghiep' => @$_POST['mona_user_nghe_nghiep'],
                '__address' => @$_POST['mona_user_address'],
                '__gai' => @$_POST['mona_choice_gai'],
                '__time_start' => @$_POST['mona_user_date_start'],
                '__status' => 'doc_than',
                '__match' => '',
            );
            foreach ($meta as $k => $v) {
                update_post_meta($insert, $k, $v);
            }
            $success = __('Đăng ký thành công', 'monamedia');
        }
        $post_data = $_POST;
        $post_data['attm'] = @$attm_id;
        unset($_POST);
        unset($_FILES);
    }
    ?>
    <main>


        <div class="join section-wrap">
            <div class="flower-right">
                <img src="<?php echo get_site_url(); ?>/template/images/flower-right.png" alt="bg flower">
            </div>
            <div class="flower-fall-2">
                <img src="<?php echo get_site_url(); ?>/template/images/flower-fall-2.png" alt="flower">
            </div>

            <div class="all">
                <?php
                if ($success != '') {
                    ?>
                    <div class="section-title success-title">
                        <h1 class="fz-36 f-title" style=" color: #5085d9;"><?php _e('Đăng ký thành công', 'monamedia'); ?></h1>
                    </div>   
                    <?php
                } else {
                    ?>
                    <div class="section-title">
                        <h1 class="fz-36 f-title"><?php the_title(); ?></h1>
                    </div>    
                    <?php
                }
                ?>


                <div class="join-detail__content clear mona-control-booking">

                    <div class="side-left">
                        <?php
                        if ($success != '') {
                            get_template_part('patch/thank');
                        } else {
                            ?>
                            <form method="post" action="" enctype="multipart/form-data">

                                <div class="box__input">
                                    <div class="title"><h3 class="fz-24 sub-title2"><?php _e('Thông tin chung', 'monamedia'); ?></h3></div>
                                    <div class="content">

                                        <div class="input__child">
                                            <h6 class="input__title"><?php _e('Email', 'monamedia'); ?></h6>
                                            <div class="form">
                                                <input type="text" required class="form-control" name="mona_user_email">
                                            </div>
                                        </div>
                                        <div class="input__child">
                                            <h6 class="input__title"><?php _e('Điện thoại', 'monamedia'); ?></h6>
                                            <div class="form">
                                                <input type="text" required class="form-control" name="mona_user_phone">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="br br-small">
                                    <i class="diamond"></i>
                                    <i class="diamond"></i>
                                </div>

                                <div class="box__input">
                                    <div class="title"><h3 class="fz-24 sub-title2"><?php _e('Thông tin chi tiết', 'monamedia'); ?></h3></div>
                                    <div class="content">
                                        <div class="input__child ">
                                            <h6 class="input__title"><?php _e('Họ và tên', 'monamedia'); ?></h6>
                                            <div class="form">
                                                <input type="text" class="form-control" name="mona_user_display_name">
                                            </div>
                                        </div>
                                        <div class="input__child">
                                            <h6 class="input__title"><?php _e('Tuổi', 'monamedia'); ?></h6>
                                            <div class="form">
                                                <input type="text" class="form-control" name="mona_user_old">
                                            </div>
                                        </div>
                                        <div class="input__child">
                                            <h6 class="input__title"><?php _e('Nghề nghiệp', 'monamedia'); ?></h6>
                                            <div class="form">
                                                <input type="text" class="form-control" name="mona_user_nghe_nghiep">
                                            </div>
                                        </div>
                                        <div class="input__child full">
                                            <h6 class="input__title"><?php _e('Nơi ở', 'monamedia'); ?></h6>
                                            <div class="form">
                                                <textarea type="text" class="form-control" name="mona_user_address"></textarea>
                                            </div>
                                        </div>
                                        <div class="input__child full mona-choice-avatar-wrapp">
                                            <h6 class="input__title"><?php _e('Ảnh đại diện', 'monamedia'); ?></h6>
                                            <div class="form add-img">
                                                <div class="block">
                                                    <label><input class="mona-hidden" type="file" name="mona_user_avatar" id="mona-choice-avatar"/><i class="far fa-image"></i><?php _e('Thêm ảnh', 'monamedia'); ?></label>
                                                </div>
                                            </div>
                                            <div class="mona-avatar-view"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="br br-small">
                                    <i class="diamond"></i>
                                    <i class="diamond"></i>
                                </div>

                                <div class="box__input">
                                    <div class="content">

                                        <div class="input__child full">
                                            <h6 class="input__title"><?php _e('Hội viên bạn yêu thích', 'monamedia'); ?></h6>
                                            <div class="form select2">

                                                <select id="chon"  required class="select2" multiple="multiple" name="mona_choice_gai[]">
                                                    <?php
                                                    $args = array(
                                                        'post_type' => 'mona_gai',
                                                        'posts_per_page' => -1,
                                                        'order' => 'DESC',
                                                        'orderby' => 'date',
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
                                                        echo '<option ' . $selet . ' value="' . get_the_ID() . '" data-img="' . get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') . '">' . get_the_title() . '</option>';
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
                                                <textarea type="text" required class="form-control" name="mona_user_note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="br br-small">
                                    <i class="diamond"></i>
                                    <i class="diamond"></i>
                                </div>
                                <div class="button">
                                    <button type="submit" class="btn btn-1"><?php _e('Đăng ký', 'monamedia'); ?></button>
                                </div>
                            </form>
                        <?php } ?>
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