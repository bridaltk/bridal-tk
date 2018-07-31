
jQuery(document).ready(function ($) {
    if ($('#mona-table-xnhv').length) {
        function mona_get_content() {
            console.log('asd');
            var $html = [];
            var $tab2 = $('#mona-table-xnhv');
            $.each($tab2.find('.input__child.full:not(.upload-wrap)'), function (i, e) {
                if ($(e).find('.input__title').length > 0) {
                    $html.push({
                        title: $(e).find('.input__title').html(),
                        values: $(e).find('.form-control').val() ||  $(e).find('.form-control').text()

                    })
                }

            });

            var $output = '';
            if ($html.length > 0) {
                $output += '<div class="success-register">';
                    $output += '<div><strong class="line">' + $('.kanjiname').html() + ' :</strong> <div class="valum">' + $('[name="ho-kaj"]').val() + ' '+$('[name="ten-kaj"]').val()+'</div> </div> ';
                    $output += '<div><strong class="line">' + $('.romajname .input__title').html() + ' :</strong> <div class="valum">' + $('[name="ho-rom"]').val() + ' '+$('[name="ten-rom"]').val()+'</div> </div> ';
                     
                $.each($html, function (i, e) {
                    if (e) {
                       $output += '<div><strong class="line">' + e.title + ' :</strong> <div class="valum">' + e.values + '</div> </div> ';
                       
                    }
                });

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
            if ($(this).attr('href') == '#tab2') {
                mona_get_content();
            }

        });
        $('.mona-register-next').on('click', function (e) {
            e.preventDefault();
			console.log('12323');
            var $this = $('#register_tab').find('.nv-item.active').next();
            if ($this.length) {
                var idString = $this.attr('href');
                var targetTab = $(idString);
                var ortherTab = targetTab.siblings('.tab-item');
                $this.addClass('active').siblings().removeClass('active');
                ortherTab.hide().removeClass('active');
                targetTab.fadeIn().addClass('active');
                if ($this.attr('href') == '#tab2') {
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
        var wpcf7Elm = document.querySelector('.wpcf7');
        wpcf7Elm.addEventListener('wpcf7invalid', function (event) {
           $('#register_tab [href="#tab1"]').addClass('active').siblings().removeClass('active');
           $('#tab1').addClass('active').fadeIn().siblings().hide().removeClass('active');
        }, false);

    }
    //end dmm



    $(document).on('click', '.mon-close-froms', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
    });
    $('.mona-popup-apply as').magnificPopup({
        type: 'inline',
        mainClass: 'mona-popup-main mona-custom-form',
        preloader: false,
        modal: true
    });
    $('.action-view-tour .mona-view-schedule').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        var $id = $(this).closest('tr').attr('id');
        $.ajax({
            url: mona_ajax_url.ajaxURL,
            type: 'post',
            data: {
                action: 'mona_ajax_get_schedule',
                data: $id
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
                showMessage(result, 'success', 'mfp-zoom-in mona-schedule-pop')
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
            var objectURL = URL.createObjectURL($file);
            $this.closest('.mona-choice-avatar-wrapp').find('.block').addClass('has-img').attr('data-img', objectURL);
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

function loadGoogleMap2() {
    var mapElement = document.getElementById('map_canvas');
    if (mapElement == null)
        return;
    google.maps.event.addDomListener(window, 'load', initmap);
    var infowindow = new google.maps.InfoWindow({
        size: new google.maps.Size(150, 50)
    });
    var map;
    var gmarkers = [];
    function createMarker(latlng, title) {
        var marker = new google.maps.Marker({
            position: latlng,
            title: 'Mona Meida',
            icon: 'data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCI+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTI1NiwwQzE1My43NTUsMCw3MC41NzMsODMuMTgyLDcwLjU3MywxODUuNDI2YzAsMTI2Ljg4OCwxNjUuOTM5LDMxMy4xNjcsMTczLjAwNCwzMjEuMDM1ICAgIGM2LjYzNiw3LjM5MSwxOC4yMjIsNy4zNzgsMjQuODQ2LDBjNy4wNjUtNy44NjgsMTczLjAwNC0xOTQuMTQ3LDE3My4wMDQtMzIxLjAzNUM0NDEuNDI1LDgzLjE4MiwzNTguMjQ0LDAsMjU2LDB6IE0yNTYsMjc4LjcxOSAgICBjLTUxLjQ0MiwwLTkzLjI5Mi00MS44NTEtOTMuMjkyLTkzLjI5M1MyMDQuNTU5LDkyLjEzNCwyNTYsOTIuMTM0czkzLjI5MSw0MS44NTEsOTMuMjkxLDkzLjI5M1MzMDcuNDQxLDI3OC43MTksMjU2LDI3OC43MTl6IiBmaWxsPSIjYTQ3MTJhIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg=='
        });
        infowindow.setContent(title);
        infowindow.open(map, marker);
        google.maps.event.addListener(marker, 'click', function () {
            infowindow.setContent(title);
            infowindow.open(map, marker);
        });
        gmarkers.push(marker);
        return marker;
    }
    function callinfobox(i) {
        google.maps.event.trigger(gmarkers[i], "click");
    }
    function deleteMarkers() {
        clearMarkers();
        gmarkers = [];
    }
    // Sets the map on all markers in the array.
    function setMapOnAll(map) {
        for (var i = 0; i < gmarkers.length; i++) {
            gmarkers[i].setMap(map);
        }
    }

    // Removes the markers from the map, but keeps them in the array.
    function clearMarkers() {
        setMapOnAll(null);
    }
    function initmap() {
        console.log($lat);
        var myLatlng = new google.maps.LatLng(parseFloat($lat), parseFloat($long));
//        var myLatlng = new google.maps.LatLng(15.879935, 108.32703200000003);
//        var myLatlng = new google.maps.LatLng(15.8798827, 108.3271684);
        var mapOptions = {
            // How zoomed in you want the map to start at (always required)
            zoom: 16,
            disableDefaultUI: true,
            scrollwheel: false,
            zoomControl: true,
            draggable: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.TOP_RIGHT
            },
            // The latitude and longitude to center the map (always required)
            center: myLatlng,
            // How you would like to style the map. 
            // This is where you would paste any style found on Snazzy Maps.
            styles: [{"featureType": "water", "elementType": "geometry", "stylers": [{"color": "#e9e9e9"}, {"lightness": 17}]}, {"featureType": "landscape", "elementType": "geometry", "stylers": [{"color": "#f5f5f5"}, {"lightness": 20}]}, {"featureType": "road.highway", "elementType": "geometry.fill", "stylers": [{"color": "#ffffff"}, {"lightness": 17}]}, {"featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [{"color": "#ffffff"}, {"lightness": 29}, {"weight": 0.2}]}, {"featureType": "road.arterial", "elementType": "geometry", "stylers": [{"color": "#ffffff"}, {"lightness": 18}]}, {"featureType": "road.local", "elementType": "geometry", "stylers": [{"color": "#ffffff"}, {"lightness": 16}]}, {"featureType": "poi", "elementType": "geometry", "stylers": [{"color": "#f5f5f5"}, {"lightness": 21}]}, {"featureType": "poi.park", "elementType": "geometry", "stylers": [{"color": "#dedede"}, {"lightness": 21}]}, {"elementType": "labels.text.stroke", "stylers": [{"visibility": "on"}, {"color": "#ffffff"}, {"lightness": 16}]}, {"elementType": "labels.text.fill", "stylers": [{"saturation": 36}, {"color": "#333333"}, {"lightness": 40}]}, {"elementType": "labels.icon", "stylers": [{"visibility": "off"}]}, {"featureType": "transit", "elementType": "geometry", "stylers": [{"color": "#f2f2f2"}, {"lightness": 19}]}, {"featureType": "administrative", "elementType": "geometry.fill", "stylers": [{"color": "#fefefe"}, {"lightness": 20}]}, {"featureType": "administrative", "elementType": "geometry.stroke", "stylers": [{"color": "#fefefe"}, {"lightness": 17}, {"weight": 1.2}]}]
        };


        // Create the Google Map using our element and options defined above
        map = new google.maps.Map(mapElement, mapOptions);
        var bounds = new google.maps.LatLngBounds();
        createMarker(myLatlng, $content).setMap(map);

    }
}