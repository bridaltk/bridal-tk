<?php
$error = '';
if (isset($_POST) && count($_POST)>0 && isset($_POST['mona_user_pass']) && isset($_POST['mona_user_new_pass']) && isset($_POST['mona_user_renew_pass'])) {
    $user = new Mona_user();
    $old_pass = $user->get_old_password();
    $check = wp_check_password($_POST['mona_user_pass'], $old_pass, get_current_user_id());
    if ($check == true) {
        if (strlen($_POST['mona_user_new_pass']) > 5) {
            if ($_POST['mona_user_new_pass'] == $_POST['mona_user_renew_pass']) {
                wp_set_password($_POST['mona_user_new_pass'], get_current_user_id());
               @wp_logout();
                ?><script>
                 window.location.href = "<?php echo get_the_permalink(MONA_LOGIN); ?>"
                </script><?php
                die;
            } else {
                $error = __('Mật khẩu mới và xác nhận mật khẩu không trùng khớp', 'monamedia');
            }
        } else {
            $error = __('Mật khẩu mới quá ngắn', 'monamedia');
        }
    } else {
        $error = __('Mật khẩu hiện tại không đúng', 'monamedia');
    }
}
?>
<div class="content-nav">
    
    <form method="post" action="" enctype="multipart/form-data">
        <div class="box__input">
            <div class="title"><h3 class="fz-24 sub-title2"><?php _e('Đổi mật khẩu', 'monamedia'); ?></h3></div>
            <div class="content">

                <div class="input__child full">
                    <h6 class="input__title"><?php _e('Mật khẩu hiện tại', 'monamedia'); ?></h6>
                    <div class="form">
                        <input value="" type="password" class="form-control" required name="mona_user_pass">
                    </div>
                </div>
                <div class="input__child">
                    <h6 class="input__title"><?php _e('Mật khẩu Mới', 'monamedia'); ?></h6>
                    <div class="form">
                        <input value="" type="password" class="form-control" required name="mona_user_new_pass">
                    </div>
                </div>
                <div class="input__child">
                    <h6 class="input__title"><?php _e('Nhập lại mật khẩu Mới', 'monamedia'); ?></h6>
                    <div class="form">
                        <input value="" type="password" class="form-control" required name="mona_user_renew_pass">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box__input">
            <div class="button input__child full">
                <button type="submit" class="btn btn-1 fw mona-fw"><?php _e('Đổi mật khẩu', 'monamedia'); ?></button>
            </div>
        </div>
    </form>
    <?php
    if ($error != '') {
        echo '<div style="color:red;">' . $error . '</div>';
    }
    ?>
</div>

