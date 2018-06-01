jQuery(document).ready(function ($) {
  var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
  if (iOS) {
    $(document.body).addClass('ios');
  };
  //input date
  if ($('.input-date').length) {
    var pkcont = 'body';
    if ($('.picker-container').length) {
      pkcont = '.picker-container';
    }
    $('.input-date').datepicker({
      todayHighlight: true,
      format:'mm/dd/yyyy',
      container: pkcont
    });
  }
if ($('.input-birthdate').length) {
    var pkcont = 'body';
    if ($('.picker-container').length) {
      pkcont = '.picker-container';
    }
    $('.input-birthdate').datepicker({
      todayHighlight: true,
      format:'mm/dd/yyyy',
      container: pkcont,
      endDate:new Date()
    });
  }
  if ($('.input-futures').length) {
    var pkcont = 'body';
    if ($('.picker-container').length) {
      pkcont = '.picker-container';
    }
    $('.input-futures').datepicker({
      todayHighlight: true,
      format:'mm/dd/yyyy',
      container: pkcont,
      startDate:new Date()
    });
  }
  //Show/Hide scroll-top on Scroll
  // hide #back-top first
  $("#scroll-top").hide();
  // fade in #back-top
  $(function () {
    $(window).scroll(function () {
      if ($(this).scrollTop() > 100) {
        $('#scroll-top').fadeIn();
      } else {
        $('#scroll-top').fadeOut();
      }
    });
    // scroll body to 0px on click
    $('#scroll-top').click(function () {
      $('body,html').animate({
        scrollTop: 0
      }, 1000);
    });
  });
  $('.navbar-toggle').on('click', function (e) {
    $(this).toggleClass('open');
    $('body').toggleClass('menuin');
  });
  $('.nav-overlay').on('click', this, function (e) {
    $('.navbar-toggle').trigger('click');
  });
  $('.dropdown').hover(function () {
    var parent = $(this);
    parent.find('.sub-menu-wrap').stop().slideDown(300, function () {
      $(this).addClass('open');
    });
  }, function () {
    $(this).children('.sub-menu-wrap').stop().slideUp(300, function () {
      $(this).removeClass('open');
    });
  });
  $('.collapse').on('click', '.collapse-heading', function () {
    var container = $(this).parent('.collapse');
    $(container).siblings().removeClass('on').find('.collapse-body').slideUp();
    $(container).find('.collapse-body').is(':visible') ?
      $(container).removeClass('on').find('.collapse-body').slideUp() :
      $(container).addClass('on').find(':hidden').slideDown();

  });
  stickyHeader();
  //    $(window).scrollTop() > $("#header").height() ? $("#header").addClass("sticky") : $("#header").removeClass("sticky");
  $(window).scroll(function () {
    //        $(window).scrollTop() > $("#header").height() ? $("#header").addClass("sticky") : $("#header").removeClass("sticky");
    stickyHeader();
  });
  function stickyHeader() {
    var hdOffsetTop = $("#header").offset().top;
    if ($(window).scrollTop() > $("#header").height()) {
    //  $("#header").addClass("sticky");
    } else {
     // $("#header").removeClass("sticky");
    }
  }

  if ($('#slider-top').length) {
    $('#slider-top').slick({
      dots: false,
      arrows: false,
      infinite: true,
      speed: 300,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      prevArrow: '<span class="slick-prev slick-arrow"><i class="fa fa-angle-left"><i></span>',
      nextArrow: '<span class="slick-next slick-arrow"><i class="fa fa-angle-right"><i></span>',
      responsive: [
        {
          breakpoint: 480,
          settings: {
            arrows: false,
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });
  }


  $('.side-left .list .has-dropdown').hover(function () {
    $(this).find('.sub-list').stop().slideDown();
  }, function () {
    $(this).find('.sub-list').stop().slideUp();
  })

});
