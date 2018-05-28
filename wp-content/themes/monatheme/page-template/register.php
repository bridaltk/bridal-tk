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
        $register = $users->register_user($_POST,false);
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
            <div class="flower-right">
                <img src="<?php echo get_site_url(); ?>/template/images/flower-right.png" alt="bg flower">
            </div>
            <div class="flower-fall-2">
                <img src="<?php echo get_site_url(); ?>/template/images/flower-fall-2.png" alt="flower">
            </div>

            <div class="all">

                <div class="section-title">
                    <h1 class="fz-36 f-title"><?php _e('Đăng ký', 'monamedia'); ?></h1>
                </div>

                <div class="join-detail__content clear">

                    <div class="side-left">
                        <?php
                        if ($success == true) {
                            mona_send_email_veryfi($_POST['mona_user_name']);
                            $userlogin = $_POST['mona_user_name'];
                            unset($_POST);
                            unset($_FILES);
                            
                            get_template_part('patch/success', 'sendveryfi');
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
                            <form method="post" action="" enctype="multipart/form-data" id="mona-register-form-submit">
                                <div class="box__input">
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
                                </div>

                                <div class="br br-small">
                                    <i class="diamond"></i>
                                    <i class="diamond"></i>
                                </div>
                                <div class="box__input">
                                    <div class="title"><div class="input__child full"><h3 class="fz-24 sub-title2"><?php _e('Thông tin chung', 'monamedia'); ?></h3></div></div>
                                    <div class="content">
                                            <div class="input__child full mona-choice-avatar-wrapp">
                                                
                                                <label class="form add-img">
                                                    <span class="block">
                                                        <input class="mona-hidden" type="file" name="mona_user_avatar" id="mona-choice-avatar"/><i class=" fa-icon far fa-image"></i>
                                                    </span>
                                                </label>
                                                <h6 class="input__title"><?php _e('Ảnh đại diện', 'monamedia'); ?></h6>
                                            </div>
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
<div class="input__child full mona-choice-gallery-wrapp">
                                                <h6 class="input__title"><?php _e('Thư viện ảnh', 'monamedia'); ?></h6>
                                                <label class="form add-img">
                                                    <span class="block">
                                                        <input class="mona-hidden" multiple type="file" name="mona_user_gallery[]" id="mona-choice-galery"/><i class="fa-icon far fa-image"></i>
                                                    </span>
                                                </label>
                                                <ul class="mona-galery-view"></ul>
                                            </div>
                                    </div>
                                </div>

                                <div class="br br-small">
                                    <i class="diamond"></i>
                                    <i class="diamond"></i>
                                </div>

                                <div class="box__input">
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
                                                    <input type="text" class="form-control " name="mona_user_anh_em"/>
                                                </div>
                                            </div>
                                            <div class="input__child">
                                                <h6 class="input__title"><?php _e('Thứ tự bản thân', 'monamedia'); ?></h6>
                                                <div class="form">
                                                    <input type="text" class="form-control " name="mona_user_ban_than"/>
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
                                </div>
                                <div class="br br-small">
                                    <i class="diamond"></i>
                                    <i class="diamond"></i>
                                </div>
                                <div class="box__input">
                                    <div class="button input__child full">
                                        <button type="submit" id="mona-submit-button" class="btn btn-1"><?php _e('Đăng ký', 'monamedia'); ?></button>
                                    </div>
                                </div>
                            </form>
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