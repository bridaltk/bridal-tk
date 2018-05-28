<?php
/**
 * Template name: Lost Password Page
 * @author : Hy Hý
 */
if (is_user_logged_in()) {
    wp_logout();
}
get_header();
$error = '';
$success = '';
$none_very = false;
if (isset($_POST) && isset($_POST['your_email']) && $_POST['your_email'] != '') {
    if (is_email(@$_POST['your_email'])) {
        $user_data = get_user_by('email', trim(($_POST['your_email'])));
        if ($user_data != false) {
            $user_login = $user_data->user_login;
            $user_email = $user_data->user_email;
            $key = get_password_reset_key($user_data);

            $message = __('Someone has requested a password reset for the following account:', 'monamedia') . "\r\n\r\n";
            $message .= network_home_url('/') . "\r\n\r\n";

            $message .= sprintf(__('Username: %s', 'monamedia'), $user_login) . "\r\n\r\n";
            $message .= __('If this was a mistake, just ignore this email and nothing will happen.', 'monamedia') . "\r\n\r\n";
            $message .= __('To reset your password, visit the following address:', 'monamedia') . "\r\n\r\n";
            $message .= '<' . network_site_url("lost-password/?reset&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";
            if ($message && !wp_mail($user_email, wp_specialchars_decode('Email Reset password'), $message)) {
                $error = (__('The email could not be sent.', 'monamedia') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function.', 'monamedia'));
            } else {
                $success = '<h3 class="success">' . __('Email have been Send ! please check your to reset password', 'monamedia') . '</h3>';
            }
        } else {
            $error = __('Oops! the user email is not valid', 'monamedia');
        }
        unset($_POST);
    } else {
        $error = __('Oops! the user email is not valid', 'monamedia');
    }
} elseif (isset($_GET['reset'])) {
    $error_message = '';
    if (@$_POST['usr_reset_pass'] == 'true') {
        if (@$_POST['new_password'] != '') {

            $check = check_password_reset_key(@$_GET['key'], @$_GET['login']);
            if (!is_wp_error($check)) {
                $user_data = get_user_by('login', $_GET['login']);
                wp_set_password($_POST['new_password'], $user_data->ID);
                $check_very = mona_check_has_verify($_GET['login']);
                if ($check_very == true) {
                    $user = wp_signon(array('user_login' => $user_data->data->user_email, 'user_password' => $_POST['new_password']));
                    if (!is_wp_error($user)) {
                        if (isset($_SESSION['redierect'])) {
                            $login = $_SESSION['redierect'];
                            unset($_SESSION['redierect']);
                            $url = '<p class="center-txt"><a href="' . $login . '" class="btn">Login <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a></p>';
                        } else {
                            $url = '<p class="center-txt"><a href="' . get_the_permalink(MONA_LOGIN) . '" class="btn">Login <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a></p>';
                        }
                        $success = '<h3 class="success">Reset password Success</br> Login Success</h3>' . $url;
                    } else {

                        $success = '<h3 class="success">Reset password Success</h3>';
                    }
                } else {
                    $none_very = true;
                }
            } else {
                $error_message = $check->get_error_message();
            }
        } else {
            $error_message = 'Opp! the password is not null';
        }
        unset($_POST);
    }
}
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
                <h1 class="fz-36 f-title"><?php
                    if (isset($_GET['reset'])) {
                        _e('Cập nhật mật khẩu', 'monamedia');
                    } else {
                        _e('Quên mật khẩu', 'monamedia');
                    }
                    ?></h1>
            </div>

            <div class="join-detail__content clear">

                <div class="side-left">
                    <?php
                    if ($error != '') {
                        echo '<p style="color:red;margin-bottom:  20px;">' . $error . '</p>';
                    }
                    ?>
                    <form action="" method="post" >
                        <div class="box__input">
                            <div class="content">
                                <?php
                                if ($success != '') {
                                    echo $success;
                                } else {
                                    if (isset($_GET['reset'])) {
                                        if($none_very==true){
                                            $userlogin = $user_data->user_login;
                                             mona_send_email_veryfi($user_data->user_login);
                                            get_template_part('patch/success','sendveryfi');
                                        }else{
                                          ?>


                                        <div class="input__child full">
                                            <h6 class="input__title"><?php _e('Mật khẩu mới', 'monamedia'); ?></h6>
                                            <div class="form">
                                                <input type="password" name="new_password" required class="form-control"   value="">
                                            </div>
                                        </div>
                                        <div class="box__input">
                                            <div class="mona-login-action input__child full">
                                                <button type="submit" name="usr_reset_pass" value="true" class="btn primary-btn mona-fw" ><?php _e('Cập nhật', 'monamedia'); ?> </button>
                                            </div>
                                        </div>


                                        <?php  
                                        }
                                        
                                    } else {
                                        ?>
                                        <div class="input__child full">
                                            <h6 class="input__title"><?php _e('Email đăng nhập', 'monamedia'); ?></h6>
                                            <div class="form">
                                                <input type="email" name="your_email" required class="form-control" placeholder="Email" value="">
                                            </div>
                                        </div>
                                        <div class="box__input">
                                            <div class="mona-login-action input__child full">
                                                <button type="submit" class="btn primary-btn mona-fw" ><?php _e('Gửi email đăng nhập', 'monamedia'); ?></button>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="br br-small">
                            <i class="diamond"></i>
                            <i class="diamond"></i>
                        </div>
                    </form>
                </div>

            </div>

        </div>


    </div>
</div>

</main>
<?php
get_footer();
?>