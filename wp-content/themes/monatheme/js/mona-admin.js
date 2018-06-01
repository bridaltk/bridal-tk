jQuery(document).ready(function ($) {
$('#mona-add-field-content').on('click',function(e){
    
    e.preventDefault();
    var $parrent = $(this).closest('#submit-hoat-dong').find('#mona_hoat_dong');
    var $total = $('#mona_hoat_dong').attr('data-total');
    $total = parseFloat($total) + 1;

    $('#mona_hoat_dong').attr('data-total',$total);
    var $html = '<li class="hd-item" data-id="'+$total+'"> <div class="item"> <div class="time"> <input name="mona_hoat_dong['+$total+'][mona_home_day]" type="text" class="mona-date-picker" value=""> </div> <div class="content"> <textarea name="mona_hoat_dong['+$total+'][content]"></textarea> </div> </div> <span class="dashicons dashicons-no"></span> </li>';
    $parrent.append($html);
});
    if ($('.mona-date-picker').length) {
        var pkcont = 'body';
        if ($('.picker-container').length) {
            pkcont = '.picker-container';
        }
        $('.mona-date-picker').datepicker({
            todayHighlight: true,
            format: 'mm/dd/yyyy',
            container: pkcont
        });
    }
    $(document).on('click','#mona_hoat_dong .hd-item .dashicons', function () {
        var $this = $(this),
                $parrent = $this.closest('.hd-item');
        $parrent.slideUp().remove();
    });
    function format(state) {
        if (!state.id)
            return state.text; // optgroup
        var originalOption = state.element;
        var $img = $(originalOption).attr('data-img');
        if ($img != '') {
            return "<img class='avatar' src='" + $img + "'/>" + state.text;
        }

    }

    $(".mona-select2").select2({
        placeholder: "Chọn",
        allowClear: true,
        //    matcher: matchCustom,
        width: "100%",
        templateResult: format,
        escapeMarkup: function (m) {
            return m;
        },
    });
    $(".mona-select2-no-multi").select2({
        placeholder: "Chọn",
        allowClear: true,
        //    matcher: matchCustom,
        width: "100%",
        templateResult: format,
        escapeMarkup: function (m) {
            return m;
        },
    });
});