<?php
/**
 * Template name: Xác nhận Page
 * @author : Hy Hý
 */
get_header();
while (have_posts()):
    the_post();
    ?>
    <main>
        <div class="join section-wrap">
            <div class="all">
                <div class="join-detail__content clear">

                    <div class="clear cont-570px mona-fix-670">
                        <div class="sec sec-table">
                            <table>
                                <tr>
                                    <td>Xác nhận qua điện thoại</td>
                                    <td>080-6190-2330</td>
                                </tr>
                                <tr>
                                    <td>Xác nhận qua Email</td>
                                    <td>bridal.tk@gmail.com</td>
                                </tr>
                            </table>
                        </div>
                        <div class="mynav-tab" id="register_tab">                           
                            <a href="#tab1" class="nv-item active">Nhập thông tin</a>
                            <a href="#tab2" class="nv-item ">Xác nhận thông tin</a>
                        </div>
                        <div id="mona-register-form-submit">
                            <div class="tab-cont-wrap">

                                <div class="box__input tab-item active" id="tab1">
                                    <div class="title"><div class="input__child full"><h3 class="fz-24 sub-title2">Nhập thông tin</h3></div></div>
                                    <div class="mona--table-xnhv">
                                        <div id="mona-table-xnhv" class="mona-table-xnhv">
                                            <div class="mona-wrap-debug">
                                                <div class="input__child">
                                                    <h6 class="input__title">Họ tên (kanji)<i class="sao">*</i></h6>
                                                    <div class="form">
                                                        [text* ho-kaj class:form-control placeholder "Họ"]
                                                    </div>
                                                </div>
                                                <div class="input__child">
                                                    <h6 class="input__title notitle">.</h6>
                                                    <div class="form">
                                                        [text* ten-kaj class:form-control placeholder "Tên"]
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mona-wrap-debug">
                                                <div class="input__child">
                                                    <h6 class="input__title">Họ tên (Romaji)<i class="sao">*</i></h6>
                                                    <div class="form">
                                                        [text* ho-rom class:form-control placeholder "Họ"]
                                                    </div>
                                                </div>
                                                <div class="input__child">
                                                    <h6 class="input__title notitle">.</h6>
                                                    <div class="form">
                                                        [text* ten-rom class:form-control placeholder "Tên"]
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title">Mã số bưu điện</h6>
                                                <div class="form">
                                                    [text* post-code class:form-control]
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title">Địa chỉ<i class="sao">*</i></h6>
                                                <div class="form">
                                                    [textarea* address class:form-control]
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title">Số điện thoại <i class="sao">*</i></h6>
                                                <div class="form">
                                                    [tel* phone class:form-control]    
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title">Địa chỉ email <i class="sao">*</i></h6>
                                                <div class="form">
                                                    [email* emails class:form-control]  
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title">Địa chỉ email (xác nhận) <i class="sao">*</i></h6>
                                                <div class="form">
                                                    [email* emails-xn class:form-control]  
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title">Chiều cao <i class="sao">*</i></h6>
                                                <div class="form">
                                                    [text* height class:form-control]
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title">Cân nặng <i class="sao">*</i></h6>
                                                <div class="form">
                                                    [text* cannang class:form-control]
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title">Học vấn <i class="sao">*</i></h6>
                                                <div class="form">
                                                    [text* hocvan class:form-control]
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title">Nghề nghiệp<i class="sao">*</i></h6>
                                                <div class="form">
                                                    [text* nghenghiep class:form-control]   
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title">Thu nhập<i class="sao">*</i></h6>
                                                <div class="form">
                                                    [text* thunhap class:form-control]
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title">Lý lịch hôn nhân<i class="sao">*</i></h6>
                                                <div class="form">
                                                    [text* honnhan class:form-control]
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title">Nhóm máu<i class="sao">*</i></h6>
                                                <div class="form">
                                                    [text* nhommau class:form-control]    
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title">Thành phần gia đình<i class="sao">*</i></h6>
                                                <div class="form">
                                                    [textarea* giadinh class:form-control]
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title">Ngày dự kiến đi được<i class="sao">*</i></h6>
                                                <div class="form">
                                                    [date* ngaydi class:form-control]    
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title">Danh sách hội viên xác nhận <i class="sao">*</i><br><small>(theo tứ tự nguyện vọng từ cao cao xuống thấp)<small></small></small></h6>
                                                <div class="form">
                                                    [textarea* hoivien class:form-control]
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title">Nội dung xác nhận (nếu có)</h6>
                                                <div class="form">
                                                    [textarea* note class:form-control]   
                                                </div>
                                            </div>
                                            <div class="input__child full">
                                                <h6 class="input__title">Upload</h6>
                                                <div class="form">
                                                    [file file-306]
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="br br-small">
                                        <i class="diamond"></i>
                                        <i class="diamond"></i>
                                    </div>
                                    <div class="button clear mona-action-register">
                                        <a href="javascript:;" class="btn btn-1 right mona-register-next">Tiếp theo<i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i></a>
                                    </div>
                                </div>

                                <div class="box__input tab-item" id="tab2">
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
                                        <a href="javascript:;" class="btn btn-1 left mona-register-prev"><i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i> Quay lại</a>
                                        [submit class:btn class:btn-1 class:right "Gửi"]
                                    </div>
                                </div>

                            </div>
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
<script type="text/javascript">
    jQuery(document).on('ready', function () {
        const $ = jQuery;
        function mona_get_content() {
            var $html = [];
            var $tab2 = $('#tab2');
            $.each($tab2.find('.input__child'), function (i, e) {
                if ($(e).find('.input__title').length > 0) {
                    $html.push({
                        title: $(e).find('.input__title').html(),
                        values: $(e).find('input.form-control').val() || $(e).find('select.form-control option:selected').val() || $(e).find('textarea.form-control').text()

                    })
                }

            });
            var $tab3 = $('#tab3');
            $.each($tab3.find('.input__child'), function (i, e) {
                if ($(e).find('.input__title').length > 0) {
                    $html.push({
                        title: $(e).find('.input__title').html(),
                        values: $(e).find('input.form-control').val() || $(e).find('select.form-control option:selected').val() || $(e).find('textarea.form-control').text()

                    })
                }

            });
            var $tab4 = $('#tab4');
            if ($tab4.find('.mona-choice-avatar-wrapp .block')) {
                $html.push({
                    title: 'thumbnail',
                    values: $tab4.find('.mona-choice-avatar-wrapp .block').attr('data-img')
                })
            }
            if ($tab4.find('.mona-choice-gallery-wrapp .mona-galery-view .mona-register-galleri').length) {
                $.each($tab4.find('.mona-choice-gallery-wrapp .mona-galery-view .mona-register-galleri'), function (i, e) {
                    $html.push({
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
                                $gallery.push(e.values);
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