<?php
global $userlogin;
?>
<div class="box__input">

    <div class="title"><h3 class="fz-24 sub-title2" style=" color: #4CAF50; font-weight: normal; "><?php _e('Đăng ký thành công', 'monamedia'); ?></h3></div>
    <div class="content success-register mona-send-very">
        <?php
        _e('chúng tôi đã gửi 1 email để xác nhận tài khoản của bạn', 'monamedia');
        ?>
        <div id="mona-action-re-email" style="margin-bottom: 10px; display: none;">
            <p style="margin-bottom: 10px;"><span style="color:red;">*</span><?php _e('Không nhận được email', 'monamedia'); ?></p>
            <a  class="primary-btn small-btn" href="javascript:;" data-user="<?php echo $userlogin; ?>"><?php _e('Gửi lại email', 'monamedia'); ?></a>
        </div>
    </div>
</div>