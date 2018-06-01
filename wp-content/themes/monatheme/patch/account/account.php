<?php
$error = array();
$success=array();
$u = get_userdata(get_current_user_id());
$user = new Mona_user(get_current_user_id());
if(count($_POST)>0){
    $data = $_POST;
    if(isset($_FILES['mona_user_avatar']) && @$_FILES['mona_user_avatar']['tmp_name'] !=''){
       $data['thumbnail']= $_FILES['mona_user_avatar'];
    }
    if(isset($_POST['mona_user_gallery']) && count($_POST['mona_user_gallery'])>0){
       $data['gallery']= $_POST['mona_user_gallery'];
    }
    $update = $user->update_my_profile($data);
    if(mona_iswp_error($update)){
        $error[]=$update['message'];
    }else{
        $success[] = __('Cập nhật thành công','monamedia');
    }
}
$post_id = $user->get_post_id();
$udata = $user->get_user_data();
?>
<div class="content-nav">
    <ul class="mona-error" id="mona-error">
        <?php
        if (count($error) > 0) {
            echo '<li>' . implode('</li><li>', $error) . '</li>';
        }elseif(count($success)>0){
              echo '<li style="color:#2772dbcc">' . implode('</li><li style="color:#2772dbcc">', $success) . '</li>';
        }
        ?>
    </ul>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="box__input">
            <div class="title"><div class="input__child full"><h3 class="fz-24 sub-title2"><?php _e('Cơ bản', 'monamedia'); ?></h3></div></div>
            <div class="content">
                <div class="mona-wrap-debug">

                    <div class="input__child">
                        <h6 class="input__title"><?php _e('Tên đăng nhập', 'monamedia'); ?></h6>
                        <div class="form">
                            <input type="text" value="<?php echo $u->user_login; ?>" readonly class="form-control" >
                        </div>
                    </div>
                    <div class="input__child">
                        <h6 class="input__title"><?php _e('Email', 'monamedia'); ?></h6>
                        <div class="form">
                            <input type="email" readonly class="form-control" value="<?php echo $u->user_email; ?>">
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

                    <label class="form add-img" <?php echo (has_post_thumbnail($post_id) ? 'style="background-image:url(' . get_the_post_thumbnail_url($post_id, 'medium') . ')"' : ''); ?>>
                        <span class="block <?php echo (has_post_thumbnail($post_id) ? 'has-img' : ''); ?>">
                            <input class="mona-hidden" type="file"  name="mona_user_avatar" id="mona-choice-avatar"/>
                            <?php
                            echo (has_post_thumbnail($post_id) ? '<i class="fa-icon far fa-edit"></i>' : '<i class=" fa-icon far fa-image"></i>');
                            ?>

                        </span>
                    </label>
                    <h6 class="input__title"><?php _e('Ảnh đại diện', 'monamedia'); ?></h6>
                </div>
                <div class="mona-wrap-debug">
                    <div class="input__child">
                        <h6 class="input__title"><?php _e('Họ Tên (Kanji)', 'monamedia'); ?></h6>
                        <div class="form">
                            <input value="<?php echo @$udata['_ten_kanji']; ?>" type="text" required class="form-control" required name="mona_user_name_kanji">
                        </div>
                    </div>
                    <div class="input__child">
                        <h6 class="input__title"><?php _e('Họ Tên (Romaji)', 'monamedia'); ?></h6>
                        <div class="form">
                            <input value="<?php echo @$udata['_ten_romaji']; ?>" type="text" required class="form-control" required name="mona_user_name_romaji">
                        </div>
                    </div>
                </div>
                <div class="mona-wrap-debug">
                    <div class="input__child">
                        <h6 class="input__title"><?php _e('Ngày sinh', 'monamedia'); ?></h6>
                        <div class="form">
                            <input value="<?php echo @$udata['_birthday']; ?>" type="text" required class="form-control input-birthdate" name="mona_user_birthday">
                        </div>
                    </div>
                    <div class="input__child">
                        <h6 class="input__title"><?php _e('Điện thoại', 'monamedia'); ?></h6>
                        <div class="form">
                            <input value="<?php echo @$udata['_phone']; ?>" type="text" required class="form-control " name="mona_user_phone">
                        </div>
                    </div>
                </div>
                <div class="mona-wrap-debug">
                    <div class="input__child">
                        <h6 class="input__title"><?php _e('Chiều cao (cm)', 'monamedia'); ?></h6>
                        <div class="form">
                            <input value="<?php echo @$udata['_height']; ?>" type="number" required class="form-control" name="mona_user_height">
                        </div>
                    </div>
                    <div class="input__child">
                        <h6 class="input__title"><?php _e('Cân nặng (kg)', 'monamedia'); ?></h6>
                        <div class="form">
                            <input value="<?php echo @$udata['_weight']; ?>" type="number" required class="form-control " name="mona_user_weight">
                        </div>
                    </div>
                </div>
                <div class="mona-wrap-debug">
                    <div class="input__child">
                        <h6 class="input__title"><?php _e('Nhóm máu', 'monamedia'); ?></h6>
                        <div class="form">
                            <span  class="icon color"><i class="fas fa-caret-down"></i></span>
                            <select class="form-control" name="mona_user_nhom_mau">
                                <option  value=""><?php _e('Chọn', 'monamedia'); ?></option>
                                <option <?php echo (@$udata['_blood_type'] == 'A' ? 'selected' : ''); ?> value="A"><?php _e('A', 'monamedia'); ?></option>
                                <option <?php echo (@$udata['_blood_type'] == 'B' ? 'selected' : ''); ?> value="B"><?php _e('B', 'monamedia'); ?></option>
                                <option <?php echo (@$udata['_blood_type'] == 'AB' ? 'selected' : ''); ?> value="AB"><?php _e('AB', 'monamedia'); ?></option>
                                <option <?php echo (@$udata['_blood_type'] == 'O' ? 'selected' : ''); ?> value="O"><?php _e('O', 'monamedia'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="input__child">
                        <h6 class="input__title"><?php _e('Học vấn', 'monamedia'); ?></h6>
                        <div class="form">
                            <span  class="icon color"><i class="fas fa-caret-down"></i></span>
                            <select class="form-control" name="mona_user_hv" required>
                                <option value=""><?php _e('Chọn', 'monamedia'); ?></option>
                                <option <?php echo (@$udata['_hoc_van'] == 'tieu_hoc' ? 'selected' : ''); ?> value="tieu_hoc"><?php _e('Tiểu học', 'monamedia'); ?></option>
                                <option <?php echo (@$udata['_hoc_van'] == 'trung_hoc' ? 'selected' : ''); ?> value="trung_hoc"><?php _e('Trung học', 'monamedia'); ?></option>
                                <option <?php echo (@$udata['_hoc_van'] == 'pho_thong' ? 'selected' : ''); ?> value="pho_thong"><?php _e('Phổ thông', 'monamedia'); ?></option>
                                <option <?php echo (@$udata['_hoc_van'] == 'trung_cap' ? 'selected' : ''); ?> value="trung_cap"><?php _e('Trung cấp', 'monamedia'); ?></option>
                                <option <?php echo (@$udata['_hoc_van'] == 'cao_dang' ? 'selected' : ''); ?> value="cao_dang"><?php _e('Cao đẳng', 'monamedia'); ?></option>
                                <option <?php echo (@$udata['_hoc_van'] == 'dai_hoc' ? 'selected' : ''); ?> value="dai_hoc"><?php _e('Đại học', 'monamedia'); ?></option>
                            </select> 
                        </div>
                    </div>
                </div>
                <div class="input__child full">
                    <h6 class="input__title"><?php _e('Hôn nhân', 'monamedia'); ?></h6>
                    <div class="form">
                        <span  class="icon color"><i class="fas fa-caret-down"></i></span>
                        <select class="form-control" name="mona_user_hon_nhan" required>
                            <option  value=""><?php _e('Chọn', 'monamedia'); ?></option>
                            <option <?php echo (@$udata['_honnhan'] == 'chua_ket_hon' ? 'selected' : ''); ?> value="chua_ket_hon"><?php _e('Chưa kết hôn', 'monamedia'); ?></option>
                            <option <?php echo (@$udata['_honnhan'] == 'tai_hon' ? 'selected' : ''); ?> value="tai_hon"><?php _e('Tái hôn', 'monamedia'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="mona-wrap-debug">
                    <div class="input__child">
                        <h6 class="input__title"><?php _e('Nghề nghiệp', 'monamedia'); ?></h6>
                        <div class="form">
                            <input value="<?php echo @$udata['_nghe_nghiep']; ?>" required type="text" class="form-control " name="mona_user_nghe_nghiep">
                        </div>
                    </div>
                    <div class="input__child">
                        <h6 class="input__title"><?php _e('Thu nhập', 'monamedia'); ?></h6>
                        <div class="form">
                            <input value="<?php echo @$udata['_thu_nhap']; ?>" required type="text" class="form-control " name="mona_user_thu_nhap">
                        </div>
                    </div>
                </div>
                <div class="mona-wrap-debug">
                    <div class="input__child">
                        <h6 class="input__title"><?php _e('Địa chỉ', 'monamedia'); ?></h6>
                        <div class="form">
                            <textarea class="form-control " name="mona_user_address"><?php echo @$udata['_address']; ?></textarea>
                        </div>
                    </div>

                    <div class="input__child">
                        <h6 class="input__title"><?php _e('Sở thích', 'monamedia'); ?></h6>
                        <div class="form">
                            <textarea class="form-control " name="mona_user_hobby"><?php echo @$udata['_so_thich']; ?></textarea>
                        </div>
                    </div>

                </div>
                <div class="input__child full mona-choice-gallery-wrapp">
                    <h6 class="input__title"><?php _e('Thư viện ảnh', 'monamedia'); ?></h6>

                    <ul class="mona-galery-edit">
                        <?php
                        if (is_array(@$udata['_gallery']) && count(@$udata['_gallery']) > 0) {
                            foreach ($udata['_gallery'] as $item) {
                                ?>
                        <li class="add-img-item">
                                    <label class="form add-img">
                                        <span class="block">
                                            <input class="mona-hidden"  type="hidden" name="mona_user_gallery[]" value="<?php echo $item; ?>"/>
                                            <?php echo wp_get_attachment_image($item, 'thumbnail'); ?>
                                        </span>

                                    </label>
                                    <i class="fa-icon fa fa-times"></i>
                                </li>    
                                <?php
                            }
                        }
                        ?>
                                <li class="add-img-action">
                            <label class="form add-img">
                                <span class="block">
                                    <input class="mona-hidden mona-update-galery-input" id="mona-update-galery-input" type="file" name="" />

                                </span>
                                <i class="fa-icon far fa-image"></i>
                            </label>
                        </li>    
                    </ul>
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
                            <input value="<?php echo @$udata['_tuoi_bo']; ?>" type="text" class="form-control" name="mona_user_tuoi_bo">
                        </div>
                    </div>
                    <div class="input__child">
                        <h6 class="input__title"><?php _e('Nghề nghiệp', 'monamedia'); ?></h6>
                        <div class="form">
                            <input value="<?php echo @$udata['_nghe_bo']; ?>" type="text" class="form-control"  name="mona_user_nghe_bo">
                        </div>
                    </div>
                </div>
                <div class="mona-wrap-debug">
                    <div class="input__child">
                        <h6 class="input__title"><?php _e('Tuổi mẹ', 'monamedia'); ?></h6>
                        <div class="form">
                            <input  value="<?php echo @$udata['_tuoi_me']; ?>" type="text" class="form-control"  name="mona_user_tuoi_me">
                        </div>
                    </div>
                    <div class="input__child">
                        <h6 class="input__title"><?php _e('Nghề nghiệp', 'monamedia'); ?></h6>
                        <div class="form">
                            <input value="<?php echo @$udata['_nghe_me']; ?>" type="text" class="form-control"  name="mona_user_nghe_me">
                        </div>
                    </div>
                </div>
                <div class="mona-wrap-debug">
                    <div class="input__child">
                        <h6 class="input__title"><?php _e('Số anh chị em', 'monamedia'); ?></h6>
                        <div class="form">
                            <input value="<?php echo @$udata['_anh_chi_em']; ?>" type="text" class="form-control " name="mona_user_anh_em"/>
                        </div>
                    </div>
                    <div class="input__child">
                        <h6 class="input__title"><?php _e('Thứ tự bản thân', 'monamedia'); ?></h6>
                        <div class="form">
                            <input value="<?php echo @$udata['_ban_than']; ?>" type="text" class="form-control " name="mona_user_ban_than"/>
                        </div>
                    </div>
                </div>
                <div class="input__child full">
                    <h6 class="input__title"><?php _e('Liên lạc', 'monamedia'); ?></h6>
                    <div class="form">
                        <textarea class="form-control " name="mona_user_contact"><?php echo @$udata['_contact']; ?></textarea>
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
                <button type="submit" id="mona-submit-button" class="btn btn-1 mona-update-button"><?php _e('Đăng ký', 'monamedia'); ?></button>
            </div>
        </div>
    </form>
</div>

