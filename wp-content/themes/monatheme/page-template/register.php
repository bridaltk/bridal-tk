<?php
/**
 * Template name: Register Page
 * @author : Hy Hý
 */
if (is_user_logged_in()) {
    wp_redirect(get_home_url());
}
$error = array();
$success = false;
if (isset($_POST) && count($_POST) > 0) {
    $users = new Mona_user();
    $check = $users->check_before_insert($_POST);
    if (mona_iswp_error($check)) {
        $error[] = $check['message'];
    } else {
        $_POST['thumbnail'] = @$_FILES['mona_user_avatar'];
        $_POST['gallery'] = @$_POST['mona_user_gallery_ids'];
        if (MONA_NOT_SEND == true) {
            $register = $users->register_user($_POST, true);
        } else {
            $register = $users->register_user($_POST, false);
        }

        if (!mona_iswp_error($register)) {
            $success = true;
            $new_user = new Mona_user($register);
        } else {
            $error[] = $register['message'];
        }
    }
}
get_header();
while (have_posts()):
    the_post();
    ?>
    <main>


        <div class="join section-wrap">
            <?php if (!wp_is_mobile()) : ?>
                <div class="flower-right bot">
                    <img src="<?php echo get_site_url(); ?>/template/images/flower-right.png" alt="bg flower">
                </div>
            <?php endif; ?>

            <div class="flower-fall-2">
                <img src="<?php echo get_site_url(); ?>/template/images/flower-fall-2.png" alt="flower">
            </div>

            <div class="all">



                <div class="join-detail__content clear">

                    <div class="clear cont-570px mona-fix-670">
                        <div class="section-title">
                            <h1 class="fz-36 f-title"><?php _e('Đăng ký', 'monamedia'); ?></h1>
                        </div>
                        <?php
                        if ($success == true) {
                            mona_send_email_veryfi($_POST['mona_user_name']);
                            $userlogin = $_POST['mona_user_name'];
                            unset($_POST);
                            unset($_FILES);
                            if (!MONA_NOT_SEND == true) {
                                get_template_part('patch/success', 'sendveryfi');
                            } else {
                                get_template_part('patch/success', 'register');
                            }

                            // get_template_part('patch/success', 'register');
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
                            <div class="mynav-tab" id="register_tab">                           
                                <a href="#tab1" class="nv-item active"><?php _e('Điều khoản dịch vụ', 'monamedia'); ?></a>
                                <a href="#tab2" class="nv-item "><?php _e('Cơ bản', 'monamedia'); ?></a>
                                <a href="#tab3" class="nv-item"><?php _e('Thông tin gia đình', 'monamedia'); ?></a>
                                <a href="#tab4" class="nv-item"><?php _e('Upload ảnh cá nhân', 'monamedia'); ?></a>
                                <a href="#tab5" class="nv-item"><?php _e('Xác nhận thông tin', 'monamedia'); ?></a>
                            </div>
                            <form method="post" action="" enctype="multipart/form-data" id="mona-register-form-submit">
                                <div class="tab-cont-wrap">

                                    <div class="box__input tab-item active" id="tab1">
                                        <div class="title"><h3 class="fz-24 sub-title2"><?php _e('Điều khoản dịch vụ', 'monamedia'); ?></h3></div>
                                        <div class="content">
                                            <div class="input__child full mona-contet-policy">
                                                <div class="mona-content">
                                                    <?php the_content(); ?>   
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <div class="form">
                                                    <label class="mona-checkbox-wrap">
                                                        <input type="checkbox" required name="moan-dk" value="true" class="mona-hide"/>
                                                        <span class="check-label"></span>
                                                        <span class="label-name"><?php _e('Tôi đồng ý với điều khoản dịch vụ', 'monamedia'); ?></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="br br-small">
                                            <i class="diamond"></i>
                                            <i class="diamond"></i>
                                        </div>
                                        <div class="button clear mona-action-register">
                                            <a href="javascript:;" class="btn btn-1 right mona-register-next"><?php _e('Tiếp theo', 'monamedia'); ?><i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i></a>
                                        </div>
                                    </div>


                                    <div class="box__input tab-item " id="tab2">
                                        <div class="title"><div class="input__child full"><h3 class="fz-24 sub-title2"><?php _e('Cơ bản', 'monamedia'); ?></h3></div></div>
                                        <div class="content">
                                            <div class="mona-wrap-debug">

                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Tên đăng nhập', 'monamedia'); ?> <i class="sao">*</i></h6>
                                                    <div class="form">
                                                        <input type="text" class="form-control" required name="mona_user_name">
                                                    </div>
                                                </div>
                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Email', 'monamedia'); ?> <i class="sao">*</i></h6>
                                                    <div class="form">
                                                        <input type="email" class="form-control" required name="mona_user_email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mona-wrap-debug">
                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Mật khẩu', 'monamedia'); ?> <i class="sao">*</i></h6>
                                                    <div class="form">
                                                        <input type="password" class="form-control" required name="mona_user_pass">
                                                    </div>
                                                </div>
                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Nhập lại mật khẩu', 'monamedia'); ?> <i class="sao">*</i></h6>
                                                    <div class="form">
                                                        <input type="password" class="form-control" required name="mona_user_repass">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="title"><div class="input__child full"><h3 class="fz-24 sub-title2"><?php _e('Thông tin chung', 'monamedia'); ?></h3></div></div>
                                        <div class="content">

                                            <div class="mona-wrap-debug">
                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Họ Tên (Kanji)', 'monamedia'); ?> <i class="sao">*</i></h6>
                                                    <div class="form">
                                                        <input type="text" required class="form-control"  name="mona_user_name_kanji">
                                                    </div>
                                                </div>
                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Họ Tên (Romaji)', 'monamedia'); ?> <i class="sao">*</i></h6>
                                                    <div class="form">
                                                        <input type="text" required class="form-control"  name="mona_user_name_romaji">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mona-wrap-debug">
                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Ngày sinh', 'monamedia'); ?> <i class="sao">*</i></h6>
                                                    <div class="form">
                                                        <input type="text" required class="form-control input-birthdate" name="mona_user_birthday">
                                                    </div>
                                                </div>
                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Điện thoại', 'monamedia'); ?> <i class="sao">*</i></h6>
                                                    <div class="form">
                                                        <input type="text" required class="form-control " name="mona_user_phone">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mona-wrap-debug">
                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Chiều cao (cm)', 'monamedia'); ?> <i class="sao">*</i></h6>
                                                    <div class="form">
                                                        <input type="number" required class="form-control" name="mona_user_height">
                                                    </div>
                                                </div>
                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Cân nặng (kg)', 'monamedia'); ?> <i class="sao">*</i></h6>
                                                    <div class="form">
                                                        <input type="number" required class="form-control " name="mona_user_weight">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mona-wrap-debug">
                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Nhóm máu', 'monamedia'); ?></h6>
                                                    <div class="form">
                                                        <span  class="icon color"><i class="fas fa-caret-down"></i></span>
                                                        <select class="form-control" name="mona_user_nhom_mau">
                                                            <option value=""><?php _e('Chọn', 'monamedia'); ?></option>
                                                            <option  value="A"><?php _e('A', 'monamedia'); ?></option>
                                                            <option  value="B"><?php _e('B', 'monamedia'); ?></option>
                                                            <option  value="AB"><?php _e('AB', 'monamedia'); ?></option>
                                                            <option  value="O"><?php _e('O', 'monamedia'); ?></option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Học vấn', 'monamedia'); ?> <i class="sao">*</i></h6>
                                                    <div class="form">
                                                        <span  class="icon color"><i class="fas fa-caret-down"></i></span>
                                                        <select class="form-control" name="mona_user_hv" required>
                                                            <option value=""><?php _e('Chọn', 'monamedia'); ?></option>
                                                            <option  value="tieu_hoc"><?php _e('Tiểu học', 'monamedia'); ?></option>
                                                            <option value="trung_hoc"><?php _e('Trung học', 'monamedia'); ?></option>
                                                            <option  value="pho_thong"><?php _e('Phổ thông', 'monamedia'); ?></option>
                                                            <option  value="trung_cap"><?php _e('Trung cấp', 'monamedia'); ?></option>
                                                            <option  value="cao_dang"><?php _e('Cao đẳng', 'monamedia'); ?></option>
                                                            <option  value="dai_hoc"><?php _e('Đại học', 'monamedia'); ?></option>
                                                        </select> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title"><?php _e('Hôn nhân', 'monamedia'); ?> <i class="sao">*</i></h6>
                                                <div class="form">
                                                    <span  class="icon color"><i class="fas fa-caret-down"></i></span>
                                                    <select class="form-control" name="mona_user_hon_nhan" required>
                                                        <option value=""><?php _e('Chọn', 'monamedia'); ?></option>
                                                        <option  value="chua_ket_hon"><?php _e('Chưa kết hôn', 'monamedia'); ?></option>
                                                        <option  value="tai_hon"><?php _e('Tái hôn', 'monamedia'); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mona-wrap-debug">
                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Nghề nghiệp', 'monamedia'); ?> <i class="sao">*</i></h6>
                                                    <div class="form">
                                                        <input required type="text" class="form-control " name="mona_user_nghe_nghiep">
                                                    </div>
                                                </div>
                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Thu nhập', 'monamedia'); ?> <i class="sao">*</i></h6>
                                                    <div class="form">
                                                        <input required type="text" class="form-control " name="mona_user_thu_nhap">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mona-wrap-debug">
                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Địa chỉ', 'monamedia'); ?></h6>
                                                    <div class="form">
                                                        <textarea class="form-control " name="mona_user_address"></textarea>
                                                    </div>
                                                </div>

                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Sở thích', 'monamedia'); ?></h6>
                                                    <div class="form">
                                                        <textarea class="form-control " name="mona_user_hobby"></textarea>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="br br-small">
                                            <i class="diamond"></i>
                                            <i class="diamond"></i>
                                        </div>
                                        <div class="button clear mona-action-register">
                                            <a href="javascript:;" class="btn btn-1 left mona-register-prev"><i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i> <?php _e('Quay lại', 'monamedia'); ?></a>
                                            <a href="javascript:;" class="btn btn-1 right mona-register-next"><?php _e('Tiếp theo', 'monamedia'); ?><i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i></a>
                                        </div>
                                    </div>


                                    <div class="box__input tab-item" id="tab3">
                                        <div class="title"> <div class="input__child full"><h3 class="fz-24 sub-title2"><?php _e('Thông tin gia đình', 'monamedia'); ?></h3></div></div>
                                        <div class="content">
                                            <div class="mona-wrap-debug">
                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Tuổi bố', 'monamedia'); ?></h6>
                                                    <div class="form">
                                                        <input type="text" class="form-control" name="mona_user_tuoi_bo">
                                                    </div>
                                                </div>
                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Nghề nghiệp', 'monamedia'); ?></h6>
                                                    <div class="form">
                                                        <input type="text" class="form-control"  name="mona_user_nghe_bo">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mona-wrap-debug">
                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Tuổi mẹ', 'monamedia'); ?></h6>
                                                    <div class="form">
                                                        <input type="text" class="form-control"  name="mona_user_tuoi_me">
                                                    </div>
                                                </div>
                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Nghề nghiệp', 'monamedia'); ?></h6>
                                                    <div class="form">
                                                        <input type="text" class="form-control"  name="mona_user_nghe_me">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mona-wrap-debug">
                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Số anh chị em', 'monamedia'); ?></h6>
                                                    <div class="form">
                                                        <input type="text" class="form-control " name="mona_user_anh_em">
                                                    </div>
                                                </div>
                                                <div class="input__child">
                                                    <h6 class="input__title"><?php _e('Thứ tự bản thân', 'monamedia'); ?></h6>
                                                    <div class="form">
                                                        <input type="text" class="form-control " name="mona_user_ban_than">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title"><?php _e('Liên lạc', 'monamedia'); ?></h6>
                                                <div class="form">
                                                    <textarea class="form-control " name="mona_user_contact"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="br br-small">
                                            <i class="diamond"></i>
                                            <i class="diamond"></i>
                                        </div>
                                        <div class="button clear mona-action-register">
                                            <a href="javascript:;" class="btn btn-1 left mona-register-prev"><i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i> <?php _e('Quay lại', 'monamedia'); ?></a>
                                            <a href="javascript:;" class="btn btn-1 right mona-register-next"><?php _e('Tiếp theo', 'monamedia'); ?><i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <div class="box__input tab-item" id="tab4">
                                        <div class="title"> <div class="input__child full"><h3 class="fz-24 sub-title2"><?php _e('Upload ảnh cá nhân', 'monamedia'); ?></h3></div></div>
                                        <div class="content">
                                            <div class="input__child full mona-choice-avatar-wrapp">

                                                <label class="form add-img">
                                                    <span class="block">
                                                        <input class="mona-hidden" type="file" name="mona_user_avatar" id="mona-choice-avatar"/><i class=" fa-icon far fa-image"></i>
                                                    </span>
                                                </label>
                                                <h6 class="input__title"><?php _e('Ảnh đại diện', 'monamedia'); ?></h6>
                                            </div>
                                            <div class="input__child full mona-choice-gallery-wrapp">
                                                <h6 class="input__title"><?php _e('Thư viện ảnh', 'monamedia'); ?></h6>
                                                <label class="form add-img">
                                                    <span class="block">
                                                        <input class="mona-hidden" multiple type="file" name="mona_user_gallery[]" id="mona-choice-galery"><i class="fa-icon far fa-image"></i>
                                                    </span>
                                                </label>
                                                <ul class="mona-galery-view"></ul>
                                            </div>
                                        </div>
                                        <div class="br br-small">
                                            <i class="diamond"></i>
                                            <i class="diamond"></i>
                                        </div>
                                        <div class="button clear mona-action-register">
                                            <a href="javascript:;" class="btn btn-1 left mona-register-prev"><i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i> <?php _e('Quay lại', 'monamedia'); ?></a>
                                            <a href="javascript:;" class="btn btn-1 right mona-register-next"><?php _e('Tiếp theo', 'monamedia'); ?><i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <div class="box__input tab-item" id="tab5">
                                        <div class="title"> <div class="input__child full"><h3 class="fz-24 sub-title2"><?php _e('Xác nhận thông tin', 'monamedia'); ?></h3></div></div>
                                        <div class="content">
                                            <div id="mona-xac-nhan-thong-tin" class="mona-xac-nhan-thong-tin loading">

                                            </div>

                                        </div>
                                        <div class="br br-small">
                                            <i class="diamond"></i>
                                            <i class="diamond"></i>
                                        </div>
                                        <div class="button clear mona-action-register">
                                            <a href="javascript:;" class="btn btn-1 left mona-register-prev"><i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i> <?php _e('Quay lại', 'monamedia'); ?></a>
                                            <button type="submit" id="mona-submit-button" class="btn btn-1 right"><?php _e('Đăng ký', 'monamedia'); ?> <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> </button>
                                        </div>
                                    </div>
                            </form>

                            <script type="text/javascript">
                                jQuery(document).on('ready', function () {
                                    const $ = jQuery;
                                    function mona_get_content() {
                                        var $html = [];
                                        var $tab2 = $('#tab2');
                                        $.each($tab2.find('.input__child'), function (i, e) {
                                            if ($(e).find('.input__title').length > 0) {
                                                 $html.push ( {
                                                    title: $(e).find('.input__title').html(),
                                                    values: $(e).find('input.form-control').val() || $(e).find('select.form-control option:selected').val() || $(e).find('textarea.form-control').text()

                                                })
                                            }

                                        });
                                        var $tab3 = $('#tab3');
                                        $.each($tab3.find('.input__child'), function (i, e) {
                                            if ($(e).find('.input__title').length > 0) {
                                                $html.push ( {
                                                    title: $(e).find('.input__title').html(),
                                                    values: $(e).find('input.form-control').val() || $(e).find('select.form-control option:selected').val() || $(e).find('textarea.form-control').text()

                                                })
                                            }

                                        });
                                        var $tab4 = $('#tab4');
                                        if ($tab4.find('.mona-choice-avatar-wrapp .block')) {
                                            $html.push ( {
                                                title: 'thumbnail',
                                                values: $tab4.find('.mona-choice-avatar-wrapp .block').attr('data-img')
                                            })
                                        }
                                          if ($tab4.find('.mona-choice-gallery-wrapp .mona-galery-view .mona-register-galleri').length) {
                                            $.each($tab4.find('.mona-choice-gallery-wrapp .mona-galery-view .mona-register-galleri'), function (i, e) {
                                                $html.push ( {
                                                    title: 'gallery',
                                                    values: $(e).find('img').attr('src')
                                                })

                                            });
                                        }
                                        var $output = '';
                                        if ($html.length > 0) {
                                            var $thumb = '', $gallery = [];
                                            $output += '<div class="success-register">';
                                            $.each($html, function (i, e) {
                                                if (e) {
                                                    if (e.title != 'gallery' && e.title != 'thumbnail') {
                                                        $output += '<div><strong class="line">' + e.title + ' :</strong> <div class="valum">' + e.values + '</div> </div> ';
                                                    } else {
                                                        if (e.title == 'thumbnail') {
                                                            $thumb = e.values;
                                                        } else if (e.title == 'gallery') {
                                                            $gallery.push (e.values);
                                                        }
                                                    }
                                                }
                                            });
                                            if ($thumb != '') {
                                                $output += '<div><strong class="line img"><?php echo __('Avatar', 'monamedia'); ?>: </strong><img src="' + $thumb + '"/></div>';
                                            }
                                            if ($gallery.length > 0) {
                                                $output += '<div><strong class="line img gallery"><?php echo __('Gallery', 'monamedia'); ?>: </strong>';
                                                $.each($gallery, function (i, e) {
                                                    $output += '<img src="' + e + '"/>';
                                                });
                                            }
                                            $output += '</div>';
                                        }

                                        $('#mona-xac-nhan-thong-tin').html($output).removeClass('loading');
                                    }


                                    $('#register_tab').on('click', '.nv-item', function (e) {
                                        e.preventDefault();
                                        var idString = $(this).attr('href');
                                        var targetTab = $(idString);
                                        var ortherTab = targetTab.siblings('.tab-item');
                                        $(this).addClass('active').siblings().removeClass('active');
                                        ortherTab.hide().removeClass('active');
                                        targetTab.fadeIn().addClass('active');
                                        if ($(this).attr('href') == '#tab5') {
                                            mona_get_content();
                                        }

                                    });
                                    $('.mona-register-next').on('click', function (e) {
                                        e.preventDefault();
                                        var $this = $('#register_tab').find('.nv-item.active').next();
                                        if ($this.length) {
                                            var idString = $this.attr('href');
                                            var targetTab = $(idString);
                                            var ortherTab = targetTab.siblings('.tab-item');
                                            $this.addClass('active').siblings().removeClass('active');
                                            ortherTab.hide().removeClass('active');
                                            targetTab.fadeIn().addClass('active');
                                             if ($this.attr('href') == '#tab5') {
                                            mona_get_content();
                                        }
                                        }

                                    });
                                    $('.mona-register-prev').on('click', function (e) {
                                        e.preventDefault();
                                        var $this = $('#register_tab').find('.nv-item.active').prev();
                                        if ($this.length) {
                                            var idString = $this.attr('href');
                                            var targetTab = $(idString);
                                            var ortherTab = targetTab.siblings('.tab-item');
                                            $this.addClass('active').siblings().removeClass('active');
                                            ortherTab.hide().removeClass('active');
                                            targetTab.fadeIn().addClass('active');
                                        }

                                    });
                                    $("form#mona-register-form-submit input").on("invalid", function (e) {
                                        $(this).addClass('invalid-ip');
                                        var firstIV = $("form#mona-register-form-submit input.invalid-ip")[0];
                                        var tabparent = $(firstIV).closest('.tab-item').attr('id');
                                        console.log(tabparent);
                                        $('#register_tab [href="#' + tabparent + '"]').trigger('click');
                                    });
                                    $("form#mona-register-form-submit input").on("input", function (e) {
                                        if ($(this).val()) {
                                            $(this).removeClass('invalid-ip');
                                        }
                                    });
                                });
                            </script>
                        <?php } ?>
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