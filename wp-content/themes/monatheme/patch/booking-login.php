<div class="box__input">
                                    <div class="title"><div class="input__child full"><h3 class="fz-24 sub-title2"><?php _e('Thông tin chung', 'monamedia'); ?></h3></div></div>
                                    <div class="content">
                                        <div class="input__child full  mona-choice-avatar-wrapp">
                                                <h6 class="input__title"><?php _e('Ảnh đại diện', 'monamedia'); ?></h6>
                                                <label class="form add-img">
                                                    <span class="block">
                                                        <input class="mona-hidden" type="file" name="mona_user_avatar" id="mona-choice-avatar"/><i class=" fa-icon far fa-image"></i>
                                                    </span>
                                                </label>
                                            </div>
                                        <div class="input__child full">
                                            <h6 class="input__title"><?php _e('Email', 'monamedia'); ?></h6>
                                            <div class="form">
                                                <input type="email" id="email_required" class="form-control" required name="mona_user_email">
                                            </div>
                                        </div>
                                        <div class="mona-wrap-debug">
                                            <div class="input__child">
                                                <h6 class="input__title"><?php _e('Họ Tên (Kanji)', 'monamedia'); ?></h6>
                                                <div class="form">
                                                    <input type="text" required class="form-control" required name="mona_user_name_kanji">
                                                </div>
                                            </div>
                                            <div class="input__child">
                                                <h6 class="input__title"><?php _e('Họ Tên (Romaji)', 'monamedia'); ?></h6>
                                                <div class="form">
                                                    <input type="text" required class="form-control" required name="mona_user_name_romaji">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mona-wrap-debug">
                                            <div class="input__child">
                                                <h6 class="input__title"><?php _e('Ngày sinh', 'monamedia'); ?></h6>
                                                <div class="form">
                                                    <input type="text" required class="form-control input-birthdate" name="mona_user_birthday">
                                                </div>
                                            </div>
                                            <div class="input__child">
                                                <h6 class="input__title"><?php _e('Điện thoại', 'monamedia'); ?></h6>
                                                <div class="form">
                                                    <input type="text" required class="form-control " name="mona_user_phone">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mona-wrap-debug">
                                            <div class="input__child">
                                                <h6 class="input__title"><?php _e('Chiều cao (cm)', 'monamedia'); ?></h6>
                                                <div class="form">
                                                    <input type="number" required class="form-control" name="mona_user_height">
                                                </div>
                                            </div>
                                            <div class="input__child">
                                                <h6 class="input__title"><?php _e('Cân nặng (kg)', 'monamedia'); ?></h6>
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
                                                <h6 class="input__title"><?php _e('Học vấn', 'monamedia'); ?></h6>
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
                                            <h6 class="input__title"><?php _e('Hôn nhân', 'monamedia'); ?></h6>
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
                                                <h6 class="input__title"><?php _e('Nghề nghiệp', 'monamedia'); ?></h6>
                                                <div class="form">
                                                    <input required type="text" class="form-control " name="mona_user_nghe_nghiep">
                                                </div>
                                            </div>
                                            <div class="input__child">
                                                <h6 class="input__title"><?php _e('Thu nhập', 'monamedia'); ?></h6>
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