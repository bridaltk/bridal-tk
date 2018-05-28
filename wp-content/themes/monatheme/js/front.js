
jQuery(document).ready(function ($) {
    $('.action-view-tour .mona-view-schedule').on('click',function(e){
        e.preventDefault();
        var $this = $(this);
        var $id = $(this).closest('tr').attr('id');
        $.ajax({
            url: mona_ajax_url.ajaxURL,
            type: 'post',
            data: {
                action: 'mona_ajax_get_schedule',
                data:$id
            },
            error: function (request) {
                $this.removeClass('loading');
                showMessage('Oops! error', 'error')
            },
            beforeSend: function () {
                $this.addClass('loading');
            },
            success: function (result) {
                 $this.removeClass('loading');
                showMessage(result, 'success','mfp-zoom-in mona-schedule-pop')
            }
        });
    });
    
    $('.mona-logout-action').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            url: mona_ajax_url.ajaxURL,
            type: 'post',
            data: {
                action: 'mona_ajax_logout',
            },
            error: function (request) {
                showMessage('Oops! error', 'error')
            },
            beforeSend: function () {
            },
            success: function (result) {
                window.location.href = mona_ajax_url.siteURL;
            }
        });
    });
    $(document).on('click', '#mona-action-re-email a', function (e) {
        e.preventDefault();
        var $this = $(this);
        var $user = $this.attr('data-user');
        if (!$(this).hasClass('loading')) {
            $.ajax({
                url: mona_ajax_url.ajaxURL,
                type: 'post',
                data: {
                    action: 'mona_ajax_send_veryfi_email',
                    user: $user
                },
                error: function (request) {
                    $this.removeClass('loading');
                    showMessage('Oops! error', 'error')
                },
                beforeSend: function () {
                    $this.addClass('loading');
                },
                success: function (result) {
                    $this.removeClass('loading');
                    var $data = $.parseJSON(result);
                    if ($data.status == 'success') {
                        $('#mona-action-re-email').fadeOut();
                        setTimeout(function () {
                            $('#mona-action-re-email').fadeIn().show();
                        }, 10000);
                    } else {
                        showMessage($data.message, 'error')
                    }
                }
            });
        }
    });
    setTimeout(function () {
        $('#mona-action-re-email').fadeIn().show();
    }, 10000);

    $('#mona-update-galery-input').on('change', function () {
        var $this = $(this);
        var $file = $(this)[0].files[0];
        var reader = new FileReader();
        reader.onload = function (event) {
            var $f = {
                name: $file.name,
                size: $file.size,
                base64: event.target.result,
                type: $file.type,
            };
            $.ajax({
                url: mona_ajax_url.ajaxURL,
                type: 'post',
                data: {
                    action: 'mona_ajax_add_file',
                    files: $f,
                },
                error: function (request) {
                    showMessage('Oops! error', 'error')
                },
                beforeSend: function () {

                },
                success: function (result) {
                    var $data = $.parseJSON(result);
                    if ($data.status == 'success') {
                        var objectURL = URL.createObjectURL($file);
                        var $html = ' <li class="add-img-item"> <label class="form add-img"> <span class="block"> <input class="mona-hidden" type="hidden" name="mona_user_gallery[]" value="' + $data.message + '"> <img width="150" height="150" src="' + objectURL + '" class="attachment-thumbnail size-thumbnail" alt="" /> </span> </label> <i class="fa-icon fa fa-times" aria-hidden="true"></i> </li> ';
                        $($html).insertBefore($this.closest('.add-img-action'));
                    } else {
                        showMessage($data.message, 'error')
                    }
                }
            });
        }

        reader.readAsDataURL($file);
    });
    $('.mona-galery-edit .fa-icon').on('click', function (e) {
        e.preventDefault();
        $(this).closest('.add-img-item').hide().remove();
    });
    $('.mona-nav-item-action .item').on('click', function (e) {
        e.preventDefault();
        var $href = $(this).find('.link').attr('href');
        $(this).addClass('active').siblings().removeClass('active');
        $('.system-tag-content ' + $href).fadeIn().addClass('active').siblings().fadeOut().removeClass('active');
    });
    $(document).on('click', '.tag-list.active .mona-system-item .nav-item', function (e) {
        e.preventDefault();
        var $this = $(this);
        var $parrent = $(this).closest('.mona-system-item');
        if ($parrent.hasClass('active')) {
            $parrent.removeClass('active').find('.system-content').slideUp();

        } else {
            $parrent.addClass('active').find('.system-content').slideDown();
        }

    });
    $('#mona-booking-form-submit').on('submit', function (e) {

        var $this = $(this);
        if ($this.find('#email_required').length) {

            if (!$this.hasClass('compleate')) {
                e.preventDefault();
                var $email = $this.find('#email_required').val();

                $.ajax({
                    url: mona_ajax_url.ajaxURL,
                    type: 'post',
                    data: {
                        action: 'mona_ajax_check_booking',
                        form: $email,
                    },
                    error: function (request) {
                        showMessage('Oops! error', 'error')
                        $this.find('#mona-submit-button').removeClass('loading').removeAttr('disabled');
                    },
                    beforeSend: function () {
                        $this.find('#mona-submit-button').addClass('loading').attr('disabled', 'disabled');
                    },
                    success: function (result) {
                        $this.find('#mona-submit-button').removeClass('loading').removeAttr('disabled');
                        var $data = $.parseJSON(result);
                        if ($data.status == 'error') {
                            $('#mona-error').html('<li>' + $data.message + '</li>');
                            $('html,body').animate({
                                scrollTop: $("#mona-error").offset().top - 100});
                        } else {
                            $this.addClass('compleate');
                            $this.submit();
                        }

                    }
                });
            }
        }
    });
    $('#mona-register-form-submit').on('submit', function (e) {

        var $this = $(this);
        if (!$this.hasClass('compleate')) {
            e.preventDefault();
            var $form = $(this).serialize();

            $.ajax({
                url: mona_ajax_url.ajaxURL,
                type: 'post',
                data: {
                    action: 'mona_ajax_check_register',
                    form: $form,
                },
                error: function (request) {
                    showMessage('Oops! error', 'error')
                    $this.find('#mona-submit-button').removeClass('loading').removeAttr('disabled');
                },
                beforeSend: function () {
                    $this.find('#mona-submit-button').addClass('loading').attr('disabled', 'disabled');
                },
                success: function (result) {
                    $this.find('#mona-submit-button').removeClass('loading').removeAttr('disabled');
                    var $data = $.parseJSON(result);
                    if ($data.status == 'error') {
                        $('#mona-error').html('<li>' + $data.message + '</li>');
                        $('html,body').animate({
                            scrollTop: $("#mona-error").offset().top - 100});
                    } else {
                        $this.addClass('compleate');
                        $this.submit();
                    }

                }
            });
        }
    });
    $('#mona-submit-login').on('submit', function (e) {
        e.preventDefault();
        var $form = $(this).serialize();

        $.ajax({
            url: mona_ajax_url.ajaxURL,
            type: 'post',
            data: {
                action: 'mona_ajax_login',
                form: $form,
            },
            error: function (request) {
                showMessage('Oops! error', 'error')
            },
            beforeSend: function () {

            },
            success: function (result) {
                var $data = $.parseJSON(result);
                if ($data.status == 'success') {
                    showMessage($data.message);
                    setTimeout(function () {
                        window.location.href = $data.url;
                    }, 1500);
                } else if ($data.status == 'warnimg') {
                    $('#login-none-veri').slideUp().html($data.message).slideDown();
                    setTimeout(function () {
                        $('#login-none-veri').find('#mona-action-re-email').fadeIn().show();
                    }, 10000);
                } else {
                    showMessage($data.message, 'error')
                }

            }
        });
    });
    $('#mona-choice-avatar').on('change', function () {
        var $this = $(this);
        var $file = $(this)[0].files[0];
        var reader = new FileReader();
        reader.onload = function (event) {
            $this.closest('.mona-choice-avatar-wrapp').find('.block').addClass('has-img');
            $this.closest('.mona-choice-avatar-wrapp').find('.add-img').css('background-image', 'url(' + event.target.result + ')').find('.fa-icon').removeClass('fa-image').addClass('fa-edit');

        }

        reader.readAsDataURL($file);
    });
    $('#mona-choice-galery').on('change', function () {
        var $this = $(this);
        var $file = $(this)[0].files;
        var $html = '';
        var $parrent = $this.closest('.add-img');
        $.each($file, function (i, e) {
            var reader = new FileReader();
            reader.onload = function (event) {
                var $f = {
                    name: $file[i].name,
                    size: $file[i].size,
                    base64: event.target.result,
                    type: $file[i].type,
                };
                $.ajax({
                    url: mona_ajax_url.ajaxURL,
                    type: 'post',
                    data: {
                        action: 'mona_ajax_add_file',
                        files: $f,
                    },
                    error: function (request) {
                        showMessage('Oops! error', 'error');
                        $parrent.removeClass('loading');
                    },
                    beforeSend: function () {
                        $parrent.addClass('loading');
                    },
                    success: function (result) {
                        $parrent.removeClass('loading');
                        var $data = $.parseJSON(result);
                        if ($data.status == 'success') {
                            var objectURL = URL.createObjectURL($file[i]);
                            var $html = ' <li class="add-img-item mona-register-galleri"> <span class="block"> <input class="mona-hidden" type="hidden" name="mona_user_gallery_ids[]" value="' + $data.message + '"> <img width="150" height="150" src="' + objectURL + '" class="attachment-thumbnail size-thumbnail" alt="" /> </span>  <i class="fa-icon fa fa-times" aria-hidden="true"></i> </li> ';
                            $this.closest('.mona-choice-gallery-wrapp').find('.mona-galery-view').append($html);
                        }
                    }
                });
            }

            reader.readAsDataURL($file[i]);
        });

    });
    $(document).on('click', '.mona-galery-view .add-img-item.mona-register-galleri .fa-icon', function (e) {
        e.preventDefault();
        $(this).closest('.add-img-item').fadeOut().remove();
    });
    $('#mona-update-avatar').on('change', function () {
        var $this = $(this);
        var $file = $(this)[0].files[0];
        var objectURL = URL.createObjectURL($file);
        $this.closest('.avatar-label').css('background-image', 'url(' + objectURL + ')');
    });
    $('.mona-select-appent').on('change', function () {
        var $name = $(this).attr('data-name');
        var $value = $(this).find('option:selected').val();
        $('#mona-filter-form').find('#' + $name).val($value);
        $('#mona-filter-form').submit();
    });
    if ($('.mona-date-picker').length) {
        $('.mona-date-picker').datepicker('clearDates');
    }

    $('.banner-slide').slick({
        infinite: true,
        speed: 600,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 3000,
        fade: true
    });

    $('.newmem-slide').slick({
        rows: 2,
        infinite: true,
        speed: 1000,
        slidesToShow: 5,
        slidesToScroll: 5,
        dots: false,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 6000,
        responsive: [
            {
                breakpoint: 950,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 5,
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 650,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 470,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
        ]
    });
    $('.slick-dots li button').empty();
})
function showMessage(message, type, effect)
{
    if (typeof (type) == "undefined")
    {
        type = "success";
    }
    if (type == 'success') {
        var $src = '<div class="mona-popup-message mfp-with-anim success"><h2 class="popup-title">Success</h2><div class="popup-content">' + message + '</div></div>';
    } else if (type == 'notitle') {
        var $src = '<div class="mona-popup-message mfp-with-anim success"><div class="popup-content">' + message + '</div></div>';
    } else {
        var $src = '<div class="mona-popup-message mfp-with-anim error"><h2 class="popup-title">error</h2><div class="popup-content">' + message + '</div></div>';
    }
    if (typeof (effect) == "undefined")
    {
        effect = "mfp-zoom-in";
    }
    effect += ' mona-popup-main';
    jQuery.magnificPopup.open({
        preloader: true,
        mainClass: effect,
        items: {
            src: $src,
            type: "inline",
            midClick: true
        }
    });
}